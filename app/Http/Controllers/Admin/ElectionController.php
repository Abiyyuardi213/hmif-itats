<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\EligibleVoter;
use App\Models\Period;
use App\Models\Vote;
use App\Services\AuditLogger;
use App\Services\MediaService;
use App\Services\VoterIdentifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ElectionController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $elections = Election::query()
            ->with('period')
            ->withCount(['candidates', 'eligibleVoters', 'votes'])
            ->latest('id')
            ->get();

        return view('admin.pemilu.index', compact('periods', 'elections'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:2000'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
        ]);

        $election = Election::create([
            'period_id' => $validated['period_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(4)),
            'description' => $validated['description'] ?? null,
            'status' => Election::STATUS_DRAFT,
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
        ]);

        AuditLogger::record('election.created', "Membuat pemilu {$election->title}", $election);

        return redirect()->route('admin.pemilu.show', $election)->with('success', 'Pemilu berhasil dibuat sebagai draft.');
    }

    public function show(Election $pemilu): View
    {
        $pemilu->load(['period', 'candidates']);
        $voters = $pemilu->eligibleVoters()->latest('id')->paginate(25);

        $voteCounts = Vote::query()
            ->where('election_id', $pemilu->id)
            ->selectRaw('candidate_id, COUNT(*) as total')
            ->groupBy('candidate_id')
            ->pluck('total', 'candidate_id');

        $stats = [
            'eligible' => $pemilu->eligibleVoters()->count(),
            'voted' => $pemilu->eligibleVoters()->where('has_voted', true)->count(),
            'ballots' => $pemilu->votes()->count(),
        ];

        return view('admin.pemilu.show', compact('pemilu', 'voters', 'voteCounts', 'stats'));
    }

    public function updateStatus(Request $request, Election $pemilu): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Election::STATUSES))],
        ]);

        if ($validated['status'] === Election::STATUS_OPEN) {
            if ($pemilu->candidates()->count() < 1) {
                return back()->with('error', 'Tambahkan minimal 1 kandidat sebelum membuka pemilu.');
            }
            if ($pemilu->eligibleVoters()->count() < 1) {
                return back()->with('error', 'Tambahkan daftar pemilih tetap (DPT) sebelum membuka pemilu.');
            }
        }

        $pemilu->update(['status' => $validated['status']]);
        AuditLogger::record('election.status', "Mengubah status pemilu {$pemilu->title} -> {$validated['status']}", $pemilu);

        return redirect()->route('admin.pemilu.show', $pemilu)->with('success', 'Status pemilu diperbarui.');
    }

    public function storeCandidate(Request $request, Election $pemilu): RedirectResponse
    {
        $validated = $request->validate([
            'candidate_number' => [
                'required',
                'integer',
                'min:1',
                'max:99',
                Rule::unique('election_candidates', 'candidate_number')->where('election_id', $pemilu->id),
            ],
            'ketua_name' => ['required', 'string', 'max:120'],
            'wakil_name' => ['nullable', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'vision_mission' => ['required', 'string', 'max:5000'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = $request->hasFile('photo')
            ? $this->media->storeImage($request->file('photo'), 'candidates', 700)
            : null;

        $candidate = ElectionCandidate::create([
            'election_id' => $pemilu->id,
            'candidate_number' => $validated['candidate_number'],
            'ketua_name' => $validated['ketua_name'],
            'wakil_name' => $validated['wakil_name'] ?? null,
            'tagline' => $validated['tagline'] ?? null,
            'vision_mission' => $validated['vision_mission'],
            'photo_path' => $photoPath,
        ]);

        AuditLogger::record('election.candidate_added', "Menambahkan paslon #{$candidate->candidate_number} pada {$pemilu->title}", $candidate);

        return redirect()->route('admin.pemilu.show', $pemilu)->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function importVoters(Request $request, Election $pemilu): RedirectResponse
    {
        $validated = $request->validate([
            'voters_csv' => ['required', 'string', 'max:100000'],
        ]);

        $lines = array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $validated['voters_csv']) ?: []));
        $added = 0;
        $skipped = 0;

        foreach ($lines as $line) {
            $parts = array_map('trim', str_getcsv($line));
            if (count($parts) < 3) {
                $skipped++;

                continue;
            }

            [$identifier, $name, $email] = $parts;
            $type = isset($parts[3]) && strtolower($parts[3]) === 'dosen' ? 'dosen' : 'mahasiswa';
            $email = strtolower($email);

            if ($identifier === '' || $name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;

                continue;
            }

            $hash = VoterIdentifier::hash($identifier);

            $exists = EligibleVoter::query()
                ->where('election_id', $pemilu->id)
                ->where(fn ($q) => $q->where('identifier_hash', $hash)->orWhere('email', $email))
                ->exists();

            if ($exists) {
                $skipped++;

                continue;
            }

            EligibleVoter::create([
                'election_id' => $pemilu->id,
                'identifier_hash' => $hash,
                'identifier_masked' => VoterIdentifier::mask($identifier),
                'voter_name' => $name,
                'voter_type' => $type,
                'email' => $email,
            ]);
            $added++;
        }

        AuditLogger::record('election.voters_imported', "Import DPT {$pemilu->title}: {$added} masuk, {$skipped} dilewati", $pemilu);

        return redirect()->route('admin.pemilu.show', $pemilu)->with(
            'success',
            "Import DPT selesai: {$added} pemilih ditambahkan, {$skipped} baris dilewati/duplikat."
        );
    }

    public function exportAuditCsv(Election $pemilu): StreamedResponse
    {
        AuditLogger::record('election.audit_exported', "Mengekspor berita acara & log partisipasi {$pemilu->title}", $pemilu);

        $filename = 'audit-pemilu-'.$pemilu->slug.'-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($pemilu): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['LAPORAN AUDIT PEMILU HMIF ITATS']);
            fputcsv($handle, ['Judul Pemilu', $pemilu->title]);
            fputcsv($handle, ['Status', $pemilu->statusLabel()]);
            fputcsv($handle, ['Waktu Ekspor', now()->timezone('Asia/Jakarta')->toIso8601String()]);
            fputcsv($handle, []);

            fputcsv($handle, ['NO URUT', 'NAMA KANDIDAT', 'JUMLAH SUARA SAH']);
            $counts = Vote::query()
                ->where('election_id', $pemilu->id)
                ->selectRaw('candidate_id, COUNT(*) as total')
                ->groupBy('candidate_id')
                ->pluck('total', 'candidate_id');

            foreach ($pemilu->candidates()->get() as $candidate) {
                fputcsv($handle, [
                    $candidate->candidate_number,
                    $candidate->ketua_name.($candidate->wakil_name ? ' & '.$candidate->wakil_name : ''),
                    (int) ($counts[$candidate->id] ?? 0),
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['LOG PARTISIPASI DPT (TANPA PILIHAN SUARA - KERAHASIAAN TERJAGA)']);
            fputcsv($handle, ['ID DPT', 'IDENTIFIER MASKED', 'NAMA', 'KATEGORI', 'STATUS MEMILIH', 'WAKTU MEMILIH']);

            $pemilu->eligibleVoters()->orderBy('id')->chunk(200, function ($voters) use ($handle): void {
                foreach ($voters as $voter) {
                    fputcsv($handle, [
                        $voter->id,
                        $voter->identifier_masked,
                        $voter->voter_name,
                        $voter->voter_type,
                        $voter->has_voted ? 'SUDAH' : 'BELUM',
                        $voter->voted_at?->timezone('Asia/Jakarta')->toIso8601String() ?? '-',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
