<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Election;
use App\Models\Period;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Tests\TestCase;

class DatabaseSeederSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        $this->setSeedEnv(null, null);
        parent::tearDown();
    }

    public function test_seeder_aborts_in_production_when_admin_email_is_missing(): void
    {
        $this->setSeedEnv('', 'StrongUniquePassword!2026');
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_in_production_when_admin_password_is_missing(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', '');
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_when_admin_password_is_shorter_than_12_characters(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', 'short12345');
        $this->forceEnvironment('local');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('at least 12 characters');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_in_production_when_deprecated_default_password_is_used(): void
    {
        $legacyPassword = implode('-', ['HMIF', 'Admin', 'ChangeMe!2026']);
        $this->setSeedEnv('kahim@hmif-itats.site', $legacyPassword);
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('deprecated default admin password');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_prints_generated_password_once_in_local_when_empty(): void
    {
        $this->setSeedEnv('dev@hmif-itats.local', '');
        $this->forceEnvironment('local');

        $this->artisan('db:seed', ['--force' => true])
            ->expectsOutputToContain('Generated local admin seed credentials: dev@hmif-itats.local /')
            ->assertSuccessful();
    }

    public function test_seeder_succeeds_in_production_without_seeding_demo_data(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', 'UniqueProductionSecret#9988');
        $this->forceEnvironment('production');

        $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

        $admin = User::query()->where('email', 'kahim@hmif-itats.site')->first();
        $this->assertNotNull($admin);
        $this->assertSame(User::ROLE_SUPER_ADMIN, $admin->role);
        $this->assertTrue(Hash::check('UniqueProductionSecret#9988', $admin->password));

        // Verify demo content is strictly skipped in production.
        $this->assertSame(0, Period::count());
        $this->assertSame(0, Activity::count());
        $this->assertSame(0, Announcement::count());
        $this->assertSame(0, Election::count());
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

    private function forceEnvironment(string $environment): void
    {
        $this->app->detectEnvironment(fn () => $environment);
    }
}
