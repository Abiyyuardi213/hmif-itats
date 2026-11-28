<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\BoardMember;
use App\Models\Division;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\OrganizationSetting;
use App\Models\Period;
use App\Models\WorkProgram;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\OfficialDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficialDataSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        $this->setSeedEnv(null, null);
        parent::tearDown();
    }

    public function test_official_data_seeder_matches_approved_data_file_counts_and_is_idempotent(): void
    {
        $this->seed(OfficialDataSeeder::class);
        $this->seed(OfficialDataSeeder::class);

        $dataFile = file_get_contents(base_path('docs/redesign/data/kabinet-asakusa-2026-2027.md'));
        $this->assertIsString($dataFile);

        $this->assertSame(1, Period::count());
        $this->assertSame(0, Period::where('is_active', false)->count());

        $period = Period::current();
        $this->assertNotNull($period);
        $this->assertSame('2026/2027', $period->name);
        $this->assertSame('Kabinet Asakusa', $period->cabinet_name);
        $this->assertSame('CONNECT. INNOVATE. EMPOWER.', $period->tagline);

        $this->assertSame(['psdm', 'litbang', 'media-humas', 'danus'], Division::orderBy('sort_order')->pluck('slug')->all());
        $this->assertSame(4, BoardMember::where('is_core', true)->whereNull('division_id')->count());
        $this->assertSame(5, BoardMember::where('is_core', false)->whereNull('division_id')->count());

        $divisionMemberCounts = Division::withCount('members')->orderBy('sort_order')->pluck('members_count', 'slug')->all();
        $this->assertSame([
            'psdm' => 8,
            'litbang' => 7,
            'media-humas' => 8,
            'danus' => 7,
        ], $divisionMemberCounts);

        $this->assertSame(39, BoardMember::count());
        $this->assertSame(12, WorkProgram::count());

        $programDivisionCounts = Division::withCount('workPrograms')->orderBy('sort_order')->pluck('work_programs_count', 'slug')->all();
        $this->assertSame([
            'psdm' => 6,
            'litbang' => 2,
            'media-humas' => 3,
            'danus' => 1,
        ], $programDivisionCounts);

        // Ensure every seeded board member and work program exists verbatim in the approved data file.
        foreach (BoardMember::all() as $member) {
            $this->assertStringContainsString($member->name, $dataFile);
        }

        foreach (WorkProgram::all() as $program) {
            $this->assertStringContainsString($program->title, $dataFile);
        }

        // Official organization email & address match approved settings while personal phone remains blank.
        $this->assertSame('hmifitats1991@gmail.com', OrganizationSetting::getValue('email'));
        $this->assertSame('', OrganizationSetting::getValue('phone'));
    }

    public function test_production_seeding_creates_official_data_and_zero_demo_rows(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', 'UniqueProductionSecret#2026');
        $this->app->detectEnvironment(fn () => 'production');

        $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

        $this->assertSame(1, Period::count());
        $this->assertSame(4, Division::count());
        $this->assertSame(39, BoardMember::count());
        $this->assertSame(12, WorkProgram::count());

        $programDivisionCounts = Division::withCount('workPrograms')->orderBy('sort_order')->pluck('work_programs_count', 'slug')->all();
        $this->assertSame([
            'psdm' => 6,
            'litbang' => 2,
            'media-humas' => 3,
            'danus' => 1,
        ], $programDivisionCounts);

        $this->assertSame(0, Activity::count());
        $this->assertSame(0, Announcement::count());
        $this->assertSame(0, Election::count());
    }

    public function test_non_production_demo_titles_start_with_contoh_prefix_without_real_names(): void
    {
        $this->setSeedEnv('dev@hmif-itats.local', 'LocalDevPassword#2026');
        $this->app->detectEnvironment(fn () => 'local');

        $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

        $this->assertSame(1, Period::count());
        $this->assertSame(4, Division::count());
        $this->assertSame(39, BoardMember::count());
        $this->assertSame(12, WorkProgram::count());

        $programDivisionCounts = Division::withCount('workPrograms')->orderBy('sort_order')->pluck('work_programs_count', 'slug')->all();
        $this->assertSame([
            'psdm' => 6,
            'litbang' => 2,
            'media-humas' => 3,
            'danus' => 1,
        ], $programDivisionCounts);

        $this->assertGreaterThan(0, Activity::count());
        $this->assertGreaterThan(0, Announcement::count());
        $this->assertGreaterThan(0, Election::count());

        foreach (Activity::all() as $activity) {
            $this->assertStringStartsWith('[CONTOH] ', $activity->title);
        }

        foreach (Announcement::all() as $announcement) {
            $this->assertStringStartsWith('[CONTOH] ', $announcement->title);
        }

        foreach (Election::all() as $election) {
            $this->assertStringStartsWith('[CONTOH] ', $election->title);
        }

        foreach (ElectionCandidate::all() as $candidate) {
            $this->assertStringContainsString('Contoh', $candidate->ketua_name);
        }
    }

    public function test_rendered_public_routes_never_expose_npm_nip_phone_or_rab_patterns(): void
    {
        $this->setSeedEnv('dev@hmif-itats.local', 'LocalDevPassword#2026');
        $this->app->detectEnvironment(fn () => 'local');
        $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

        $routes = [
            route('home'),
            route('about'),
            route('struktur'),
            route('divisi.index'),
            route('divisi.show', 'psdm'),
            route('divisi.show', 'litbang'),
            route('divisi.show', 'media-humas'),
            route('divisi.show', 'danus'),
            route('proker.index'),
            route('kegiatan.index'),
            route('kegiatan.show', Activity::firstOrFail()->slug),
            route('pengumuman.index'),
            route('pengumuman.show', Announcement::firstOrFail()->slug),
            route('kontak'),
            route('pemilu.index'),
            route('sitemap'),
        ];

        $forbiddenPatterns = [
            'NPM' => '/06\.20\d{2}\.1\.\d{5}/',
            'NIP' => '/\b\d{18}\b/',
            'Phone/WA' => '/(\+62|\b08)[0-9\s-]{8,15}/',
            'RAB' => '/Rp\s?\d/i',
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $body = (string) $response->getContent();

            foreach ($forbiddenPatterns as $label => $regex) {
                $this->assertDoesNotMatchRegularExpression($regex, $body, "Public route {$url} exposed forbidden {$label} pattern.");
            }
        }
    }

    public function test_struktur_hides_archive_selector_when_no_archive_period_exists(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('struktur'));
        $response->assertOk()
            ->assertSee('Kabinet Asakusa')
            ->assertDontSee('id="periode"', false)
            ->assertDontSee('>ARSIP<', false);
    }

    private function setSeedEnv(?string $email, ?string $password): void
    {
        if ($email === null) {
            putenv('ADMIN_SEED_EMAIL');
            unset($_ENV['ADMIN_SEED_EMAIL'], $_SERVER['ADMIN_SEED_EMAIL']);
        } else {
            putenv("ADMIN_SEED_EMAIL={$email}");
            $_ENV['ADMIN_SEED_EMAIL'] = $email;
            $_SERVER['ADMIN_SEED_EMAIL'] = $email;
        }

        if ($password === null) {
            putenv('ADMIN_SEED_PASSWORD');
            unset($_ENV['ADMIN_SEED_PASSWORD'], $_SERVER['ADMIN_SEED_PASSWORD']);
        } else {
            putenv("ADMIN_SEED_PASSWORD={$password}");
            $_ENV['ADMIN_SEED_PASSWORD'] = $password;
            $_SERVER['ADMIN_SEED_PASSWORD'] = $password;
        }
    }
}
