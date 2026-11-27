<?php

namespace Tests\Feature;

use App\Mail\VoteTokenMail;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\EligibleVoter;
use App\Models\Period;
use App\Models\Vote;
use App\Models\VoterToken;
use App\Services\VoterIdentifier;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EVotingSecurityTest extends TestCase
{
    use RefreshDatabase;

    private Election $openElection;

    private ElectionCandidate $candidateOne;

    private ElectionCandidate $candidateTwo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $period = Period::current();

        $this->openElection = Election::create([
            'period_id' => $period->id,
            'title' => 'Pemira Uji Keamanan',
            'slug' => 'pemira-uji-keamanan',
            'description' => 'Sesi uji integritas pemungutan suara.',
            'status' => Election::STATUS_OPEN,
            'starts_at' => now()->subHour(),
            'ends_at' => now()->addHours(4),
        ]);

        $this->candidateOne = ElectionCandidate::create([
            'election_id' => $this->openElection->id,
            'candidate_number' => 1,
            'ketua_name' => 'Kandidat Satu',
            'vision_mission' => 'Visi Misi Satu',
        ]);

        $this->candidateTwo = ElectionCandidate::create([
            'election_id' => $this->openElection->id,
            'candidate_number' => 2,
            'ketua_name' => 'Kandidat Dua',
            'vision_mission' => 'Visi Misi Dua',
        ]);

        EligibleVoter::create([
            'election_id' => $this->openElection->id,
            'identifier_hash' => VoterIdentifier::hash('06.2024.1.07901'),
            'identifier_masked' => VoterIdentifier::mask('06.2024.1.07901'),
            'voter_name' => 'Pemilih Mahasiswa',
            'voter_type' => 'mahasiswa',
            'email' => 'mhs1@itats.ac.id',
        ]);

        EligibleVoter::create([
            'election_id' => $this->openElection->id,
            'identifier_hash' => VoterIdentifier::hash('198501012015011001'),
            'identifier_masked' => VoterIdentifier::mask('198501012015011001'),
            'voter_name' => 'Pemilih Dosen',
            'voter_type' => 'dosen',
            'email' => 'dosen1@itats.ac.id',
        ]);
    }

    public function test_request_token_requires_email_for_both_mahasiswa_and_dosen_and_rejects_unregistered(): void
    {
        Mail::fake();

        // Missing email rejected by validation
        $this->post(route('pemilu.request-token'), [
            'election_id' => $this->openElection->id,
            'identifier' => '06.2024.1.07901',
        ])->assertSessionHasErrors('email');

        // Unregistered / mismatched email does not send token mail
        $this->post(route('pemilu.request-token'), [
            'election_id' => $this->openElection->id,
            'identifier' => '06.2024.1.07901',
            'email' => 'impersonator@example.com',
        ])->assertRedirect(route('pemilu.index'));

        Mail::assertNothingSent();
    }

    public function test_verified_voter_can_cast_once_and_double_vote_is_blocked(): void
    {
        Mail::fake();

        $capturedUrl = null;
        $this->post(route('pemilu.request-token'), [
            'election_id' => $this->openElection->id,
            'identifier' => '06.2024.1.07901',
            'email' => 'mhs1@itats.ac.id',
        ])->assertRedirect(route('pemilu.index'));

        Mail::assertSent(VoteTokenMail::class, function (VoteTokenMail $mail) use (&$capturedUrl) {
            $capturedUrl = $mail->ballotUrl;

            return $mail->hasTo('mhs1@itats.ac.id');
        });

        $this->assertNotNull($capturedUrl);
        $rawToken = basename((string) parse_url($capturedUrl, PHP_URL_PATH));

        // Open ballot screen
        $this->get(route('pemilu.ballot', ['token' => $rawToken]))->assertOk();

        // Cast ballot
        $this->post(route('pemilu.cast', ['token' => $rawToken]), [
            'candidate_id' => $this->candidateOne->id,
        ])->assertRedirect(route('pemilu.receipt'));

        $this->assertSame(1, Vote::where('election_id', $this->openElection->id)->count());

        // Replay attack using same token must be rejected
        $this->post(route('pemilu.cast', ['token' => $rawToken]), [
            'candidate_id' => $this->candidateTwo->id,
        ])->assertRedirect(route('pemilu.index'))->assertSessionHas('error');

        $this->assertSame(1, Vote::where('election_id', $this->openElection->id)->count());

        // Requesting another token after already voting must not issue a token
        Mail::fake();
        $this->post(route('pemilu.request-token'), [
            'election_id' => $this->openElection->id,
            'identifier' => '06.2024.1.07901',
            'email' => 'mhs1@itats.ac.id',
        ])->assertRedirect(route('pemilu.index'));

        Mail::assertNothingSent();
    }

    public function test_expired_token_and_closed_election_and_cross_election_candidate_are_rejected(): void
    {
        $voter = EligibleVoter::where('email', 'dosen1@itats.ac.id')->firstOrFail();
        $rawToken = 'expired-test-token-123456';

        VoterToken::create([
            'election_id' => $this->openElection->id,
            'eligible_voter_id' => $voter->id,
            'token_hash' => hash('sha256', $rawToken),
            'expires_at' => now()->subMinute(),
        ]);

        $this->get(route('pemilu.ballot', ['token' => $rawToken]))
            ->assertRedirect(route('pemilu.index'))
            ->assertSessionHas('error');

        // Valid token but cross-election candidate rejected
        $validToken = 'valid-token-cross-check';
        VoterToken::create([
            'election_id' => $this->openElection->id,
            'eligible_voter_id' => $voter->id,
            'token_hash' => hash('sha256', $validToken),
            'expires_at' => now()->addMinutes(10),
        ]);

        $otherCandidate = ElectionCandidate::where('election_id', '!=', $this->openElection->id)->firstOrFail();

        $this->post(route('pemilu.cast', ['token' => $validToken]), [
            'candidate_id' => $otherCandidate->id,
        ])->assertSessionHasErrors('candidate_id');

        // Closed election blocks cast
        $this->openElection->update(['status' => Election::STATUS_CLOSED]);
        $this->post(route('pemilu.cast', ['token' => $validToken]), [
            'candidate_id' => $this->candidateOne->id,
        ])->assertRedirect(route('pemilu.index'))->assertSessionHas('error');

        $this->assertSame(0, Vote::where('election_id', $this->openElection->id)->count());
    }

    public function test_votes_table_preserves_ballot_secrecy_without_voter_columns(): void
    {
        $columns = Schema::getColumnListing('votes');

        $this->assertNotContains('eligible_voter_id', $columns);
        $this->assertNotContains('user_id', $columns);
        $this->assertNotContains('email', $columns);
        $this->assertNotContains('npm', $columns);
        $this->assertNotContains('ip_address', $columns);
    }
}
