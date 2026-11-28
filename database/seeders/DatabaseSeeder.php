<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    private const DEPRECATED_PASSWORD_SHA256 = '2f2f40a3d3e6128b69094891bb4a663836dde009cac35e3ffd1fd4ddd40eaac9';

    private const MIN_PASSWORD_LENGTH = 12;

    public function run(): void
    {
        $adminEmail = trim((string) Env::get('ADMIN_SEED_EMAIL', ''));
        $adminPassword = (string) Env::get('ADMIN_SEED_PASSWORD', '');

        $usesDeprecatedDefault = $adminPassword !== ''
            && hash_equals(self::DEPRECATED_PASSWORD_SHA256, hash('sha256', $adminPassword));

        if ($usesDeprecatedDefault) {
            throw new RuntimeException('Refusing to seed with the deprecated default admin password. Configure a unique ADMIN_SEED_PASSWORD.');
        }

        if ($adminPassword !== '' && mb_strlen($adminPassword) < self::MIN_PASSWORD_LENGTH) {
            throw new RuntimeException('ADMIN_SEED_PASSWORD must be at least 12 characters long.');
        }

        if (app()->environment('production')) {
            if ($adminEmail === '' || $adminPassword === '') {
                throw new RuntimeException('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production before running DatabaseSeeder.');
            }
        } else {
            $adminEmail = $adminEmail !== '' ? $adminEmail : 'admin@hmif-itats.local';
            if ($adminPassword === '') {
                $adminPassword = Str::random(24);
                $this->command?->warn("Generated local admin seed credentials: {$adminEmail} / {$adminPassword}");
            }
        }

        User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrator HMIF ITATS',
                'password' => Hash::make($adminPassword),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Official Kabinet Asakusa 2026/2027 data runs in every environment (production included).
        $this->call(OfficialDataSeeder::class);

        // Demo content is strictly excluded from production seeding.
        if (! app()->environment('production')) {
            $this->call(DemoContentSeeder::class);
        }
    }
}
