<?php

namespace Tests\Feature;

use App\Models\Election;
use App\Models\Period;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminElectionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_panitia_can_create_election_import_voters_open_and_export_audit_csv(): void
    {
        $panitia = User::factory()->create([
            'role' => User::ROLE_PANITIA_PEMILU,
            'is_active' => true,
        ]);
        $period = Period::current();

        $this->actingAs($panitia)->post(route('admin.pemilu.store'), [
            'period_id' => $period->id,
            'title' => 'Pemira Audit Export Test',
            'description' => 'Deskripsi uji',
            'starts_at' => now()->subHour()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ])->assertRedirect();

        $election = Election::where('title', 'Pemira Audit Export Test')->firstOrFail();

        // Cannot open election before candidates and DPT exist
        $this->actingAs($panitia)->patch(route('admin.pemilu.status', $election), [
            'status' => Election::STATUS_OPEN,
        ])->assertSessionHas('error');

        $this->actingAs($panitia)->post(route('admin.pemilu.candidates.store', $election), [
            'candidate_number' => 1,
            'ketua_name' => 'Calon Satu',
            'vision_mission' => 'Visi Misi',
        ])->assertRedirect();

        $this->actingAs($panitia)->post(route('admin.pemilu.voters.import', $election), [
            'voters_csv' => "06.2024.1.07888,Andi Pratama,andi@itats.ac.id,mahasiswa\n06.2024.1.07888,Duplicate,andi@itats.ac.id,mahasiswa\n198001012010011002,Dr. Budi,budi@itats.ac.id,dosen",
        ])->assertRedirect();

        $this->assertSame(2, $election->eligibleVoters()->count());

        $this->actingAs($panitia)->patch(route('admin.pemilu.status', $election), [
            'status' => Election::STATUS_OPEN,
        ])->assertRedirect();

        $this->assertSame(Election::STATUS_OPEN, $election->fresh()->status);

        $exportResponse = $this->actingAs($panitia)->get(route('admin.pemilu.export', $election));
        $exportResponse->assertOk();
        $csv = $exportResponse->streamedContent();
        $this->assertStringContainsString('LAPORAN AUDIT PEMILU HMIF ITATS', $csv);
        $this->assertStringContainsString('Andi Pratama', $csv);
        $this->assertStringNotContainsString('06.2024.1.07888', $csv);
    }
}
