<?php

namespace App\Http\Controllers;

use App\Mail\VoteTokenMail;
use App\Models\Election;
use App\Models\EligibleVoter;
use App\Models\Vote;
use App\Models\VoterToken;
use App\Services\VoterIdentifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ElectionController extends Controller
{
    public function index(): View
    {
        $election = Election::query()
            ->where('status', Election::STATUS_OPEN)
            ->latest('id')
            ->with('candidates')
            ->first()
            ?? Election::query()->where('status', Election::STATUS_CLOSED)->latest('id')->with('candidates')->first();

        $results = collect();
        $totalVotes = 0;
        $totalEligible = 0;

        if ($election && $election->status === Election::STATUS_CLOSED) {
            $counts = Vote::query()
                ->where('election_id', $election->id)
                ->selectRaw('candidate_id, COUNT(*) as total')
                ->groupBy('candidate_id')
                ->pluck('total', 'candidate_id');

            $results = $election->candidates->map(fn ($candidate) => [
                'candidate' => $candidate,
                'votes' => (int) ($counts[$candidate->id] ?? 0),
            ]);
            $totalVotes = $results->sum('votes');
            $totalEligible = $election->eligibleVoters()->count();
        }

        return view('pages.pemilu.index', compact('election', 'results', 'totalVotes', 'totalEligible'));
    }

    public function requestToken(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'election_id' => ['required', 'integer', 'exists:elections,id'],
            'identifier' => ['required', 'string', 'min:4', 'max:64'],
            'email' => ['required', 'email:rfc', 'max:160'],
        ], [
            'identifier.required' => 'NPM atau NIDN wajib diisi.',
            'email.required' => 'Email terdaftar wajib diisi oleh mahasiswa maupun dosen.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $election = Election::query()->findOrFail($validated['election_id']);

        if (! $election->isCurrentlyOpen()) {
            return redirect()->route('pemilu.index')->with('error', 'Sesi pemungutan suara saat ini tidak dibuka.');
        }

        $identifierHash = VoterIdentifier::hash($validated['identifier']);
        $email = strtolower(trim($validated['email']));

        $voter = EligibleVoter::query()
            ->where('election_id', $election->id)
            ->where('identifier_hash', $identifierHash)
            ->where('email', $email)
            ->first();

        if ($voter && ! $voter->has_voted) {
            $rawToken = Str::random(64);
            $expiresAt = now()->addMinutes(20);

            DB::transaction(function () use ($election, $voter, $rawToken, $expiresAt): void {
                // Invalidate any prior unused tokens for this voter.
                VoterToken::query()
                    ->where('election_id', $election->id)
                    ->where('eligible_voter_id', $voter->id)
                    ->whereNull('used_at')
                    ->update(['used_at' => now()]);

                VoterToken::create([
                    'election_id' => $election->id,
                    'eligible_voter_id' => $voter->id,
                    'token_hash' => hash('sha256', $rawToken),
                    'expires_at' => $expiresAt,
                ]);
            });

            $ballotUrl = route('pemilu.ballot', ['token' => $rawToken]);
            Mail::to($voter->email)->send(new VoteTokenMail(
                $election,
                $voter->voter_name,
                $ballotUrl,
                $expiresAt->timezone('Asia/Jakarta')->format('d M Y H:i')
            ));
        }

        // Generic response prevents enumeration of registered voters or voting status.
        return redirect()->route('pemilu.index')->with(
            'success',
            'Jika NPM/NIDN dan email Anda terdaftar dalam DPT serta belum memilih, tautan surat suara rahasia telah dikirimkan ke email tersebut.'
        );
    }

    public function showBallot(string $token): View|RedirectResponse
    {
        $voterToken = VoterToken::query()
            ->where('token_hash', hash('sha256', $token))
            ->with(['election.candidates', 'eligibleVoter'])
            ->first();

        if (! $voterToken || ! $voterToken->isUsable() || ! $voterToken->election?->isCurrentlyOpen() || $voterToken->eligibleVoter?->has_voted) {
            return redirect()->route('pemilu.index')->with('error', 'Tautan surat suara tidak valid, sudah digunakan, atau masa berlaku telah habis.');
        }

        return view('pages.pemilu.ballot', [
            'election' => $voterToken->election,
            'voter' => $voterToken->eligibleVoter,
            'rawToken' => $token,
        ]);
    }

    public function castVote(Request $request, string $token): RedirectResponse
    {
        $tokenHash = hash('sha256', $token);
        $voterToken = VoterToken::query()->where('token_hash', $tokenHash)->first();

        if (! $voterToken || ! $voterToken->election) {
            return redirect()->route('pemilu.index')->with('error', 'Tautan surat suara tidak valid.');
        }

        $electionId = $voterToken->election_id;

        $validated = $request->validate([
            'candidate_id' => [
                'required',
                'integer',
                Rule::exists('election_candidates', 'id')->where('election_id', $electionId),
            ],
        ], [
            'candidate_id.required' => 'Silakan pilih salah satu kandidat sebelum mengirim suara.',
            'candidate_id.exists' => 'Kandidat yang dipilih tidak valid untuk pemilu ini.',
        ]);

        $result = DB::transaction(function () use ($tokenHash, $validated) {
            $lockedToken = VoterToken::query()
                ->where('token_hash', $tokenHash)
                ->lockForUpdate()
                ->first();

            if (! $lockedToken || ! $lockedToken->isUsable()) {
                return ['ok' => false, 'message' => 'Token surat suara sudah digunakan atau kadaluarsa.'];
            }

            $election = Election::query()->whereKey($lockedToken->election_id)->lockForUpdate()->first();
            if (! $election || ! $election->isCurrentlyOpen()) {
                return ['ok' => false, 'message' => 'Sesi pemungutan suara telah ditutup.'];
            }

            $lockedVoter = EligibleVoter::query()
                ->whereKey($lockedToken->eligible_voter_id)
                ->lockForUpdate()
                ->first();

            if (! $lockedVoter || $lockedVoter->has_voted) {
                return ['ok' => false, 'message' => 'Hak pilih Anda sudah tercatat sebelumnya.'];
            }

            $lockedToken->update(['used_at' => now()]);
            $lockedVoter->update([
                'has_voted' => true,
                'voted_at' => now(),
            ]);

            $receiptHash = hash('sha256', Str::uuid()->toString().bin2hex(random_bytes(16)));

            // Stored without voter_id/email/npm/ip to preserve absolute ballot secrecy.
            Vote::create([
                'election_id' => $election->id,
                'candidate_id' => $validated['candidate_id'],
                'receipt_hash' => $receiptHash,
                'cast_at' => now(),
            ]);

            return [
                'ok' => true,
                'receipt' => $receiptHash,
                'election_title' => $election->title,
            ];
        });

        if (! $result['ok']) {
            return redirect()->route('pemilu.index')->with('error', $result['message']);
        }

        return redirect()->route('pemilu.receipt')->with([
            'vote_receipt' => $result['receipt'],
            'election_title' => $result['election_title'],
        ]);
    }

    public function receipt(): View|RedirectResponse
    {
        if (! session()->has('vote_receipt')) {
            return redirect()->route('pemilu.index');
        }

        return view('pages.pemilu.receipt', [
            'receipt' => session('vote_receipt'),
            'electionTitle' => session('election_title'),
        ]);
    }
}
