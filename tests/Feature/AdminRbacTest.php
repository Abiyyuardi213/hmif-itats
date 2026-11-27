<?php

namespace Tests\Feature;

use App\Models\Period;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_guest_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.periods.index'))->assertRedirect(route('login'));
        $this->get(route('admin.pemilu.index'))->assertRedirect(route('login'));
    }

    public function test_kominfo_role_is_restricted_to_content_modules(): void
    {
        $kominfo = User::factory()->create([
            'role' => User::ROLE_KOMINFO,
            'is_active' => true,
        ]);

        $this->actingAs($kominfo)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($kominfo)->get(route('admin.kegiatan.index'))->assertOk();
        $this->actingAs($kominfo)->get(route('admin.pengumuman.index'))->assertOk();

        $this->actingAs($kominfo)->get(route('admin.periods.index'))->assertForbidden();
        $this->actingAs($kominfo)->get(route('admin.pemilu.index'))->assertForbidden();
        $this->actingAs($kominfo)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($kominfo)->get(route('admin.settings.edit'))->assertForbidden();
    }

    public function test_panitia_pemilu_can_access_elections_but_not_org_or_users(): void
    {
        $panitia = User::factory()->create([
            'role' => User::ROLE_PANITIA_PEMILU,
            'is_active' => true,
        ]);

        $this->actingAs($panitia)->get(route('admin.pemilu.index'))->assertOk();
        $this->actingAs($panitia)->get(route('admin.proker.index'))->assertForbidden();
        $this->actingAs($panitia)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_super_admin_validates_activity_dates_against_out_of_range_typos(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->firstOrFail();
        $period = Period::current();

        $response = $this->actingAs($admin)->post(route('admin.kegiatan.store'), [
            'period_id' => $period->id,
            'title' => 'Kegiatan Tanggal Salah',
            'category' => 'Akademik',
            'event_date' => '2040-08-01',
            'summary' => 'Ringkasan kegiatan.',
            'content' => 'Konten kegiatan yang cukup panjang.',
        ]);

        $response->assertSessionHasErrors('event_date');
    }

    public function test_inactive_user_cannot_login(): void
    {
        $inactive = User::factory()->create([
            'role' => User::ROLE_KOMINFO,
            'is_active' => false,
        ]);

        $this->post(route('login.attempt'), [
            'email' => $inactive->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
