<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\WorkProgram;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_all_public_pages_render_successfully_with_unique_seo_titles(): void
    {
        $routes = [
            route('home'),
            route('about'),
            route('struktur'),
            route('struktur', ['periode' => '2025/2026']),
            route('divisi.index'),
            route('divisi.show', 'sistem-digital'),
            route('proker.index'),
            route('kegiatan.index'),
            route('kegiatan.show', Activity::firstOrFail()->slug),
            route('pengumuman.index'),
            route('pengumuman.show', Announcement::firstOrFail()->slug),
            route('kontak'),
            route('pemilu.index'),
        ];

        $titles = [];
        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);

            preg_match('/<title>(.*?)<\/title>/s', $response->getContent(), $matches);
            $titles[] = trim($matches[1] ?? '');
        }

        $this->assertGreaterThanOrEqual(10, count(array_unique($titles)));
        $this->get(route('sitemap'))->assertStatus(200)->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function test_legacy_routes_redirect_cleanly(): void
    {
        $this->get('/home')->assertRedirect(route('home'));
        $this->get('/program')->assertRedirect(route('proker.index'));
        $this->get('/login-guest')->assertRedirect(route('login'));
    }

    public function test_public_pages_do_not_expose_personal_npm_or_stale_branding(): void
    {
        foreach ([route('about'), route('struktur'), route('struktur', ['periode' => '2025/2026'])] as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $response->assertDontSee('06.2023');
            $response->assertDontSee('06.2024');
            $response->assertDontSee('hmti@itats.ac.id');
            $response->assertDontSee('UI berbasis design tokens');
        }
    }

    public function test_homepage_stats_reflect_actual_database_counts(): void
    {
        $expectedPrograms = WorkProgram::count();
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee((string) $expectedPrograms);
        $response->assertDontSee('300+');
    }

    public function test_contact_form_stores_valid_message_and_blocks_honeypot_spam(): void
    {
        $this->post(route('kontak.store'), [
            'name' => 'Bot Spam',
            'email' => 'bot@example.com',
            'subject' => 'Spam Subject',
            'message' => 'This should be silently ignored by honeypot.',
            'website' => 'https://spam.example',
        ])->assertRedirect(route('kontak'));

        $this->assertSame(0, ContactMessage::count());

        $this->post(route('kontak.store'), [
            'name' => 'Mahasiswa Informatika',
            'email' => 'mahasiswa@itats.ac.id',
            'subject' => 'Pendaftaran Divisi 6',
            'message' => 'Saya berminat bergabung menjadi maintainer portal HMIF.',
        ])->assertRedirect(route('kontak'));

        $this->assertSame(1, ContactMessage::count());
    }
}
