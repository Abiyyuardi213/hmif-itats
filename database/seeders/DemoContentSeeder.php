<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\Period;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    /**
     * Seed non-production example activities, announcements, and a closed sample election.
     * Official period, divisions, board members, and work programs are managed by OfficialDataSeeder.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            return;
        }

        $period = Period::query()->where('name', '2026/2027')->firstOrFail();

        $programsBySlug = $period->workPrograms()
            ->pluck('id', 'slug')
            ->all();

        $activities = [
            [
                'program_slug' => 'pengembangan-manajemen-organisasi-pmo-hmif-itats-2026',
                'title' => '[CONTOH] Pelatihan Manajemen Organisasi (PMO) 2026',
                'slug' => 'pmo-2026',
                'category' => 'Kaderisasi',
                'event_date' => '2026-09-22',
                'location' => 'Aula Gedung A ITATS',
                'summary' => 'Pembekalan dasar organisasi dan kolaborasi tim bagi calon kader dan pengurus baru HMIF ITATS.',
                'content' => "Contoh kegiatan Pelatihan Manajemen Organisasi (PMO) untuk pengujian tampilan portal.\n\nMateri mencakup tata kelola surat-menyurat, manajemen waktu proyek kepanitiaan, komunikasi publik, serta pengenalan divisi aktif di bawah HMIF ITATS.",
                'cover_image' => 'image/hmif-pmo.jpg',
                'is_published' => true,
            ],
            [
                'program_slug' => 'hmif-academy-hard-skill-soft-skill-development',
                'title' => '[CONTOH] Webinar & Workshop Arsitektur Web Modern',
                'slug' => 'webinar-arsitektur-web-2026',
                'category' => 'Akademik',
                'event_date' => '2026-10-18',
                'location' => 'Lab Rekayasa Perangkat Lunak ITATS',
                'summary' => 'Workshop praktik pengembangan aplikasi Laravel yang aman, terstruktur, dan siap produksi.',
                'content' => "Contoh agenda lokakarya akademik untuk pengujian tata letak portal.\n\nMembahas pemodelan database relasional, validasi input, proteksi privasi pengguna, serta alur pengujian otomatis.",
                'cover_image' => 'image/hmif-webinar.jpg',
                'is_published' => true,
            ],
            [
                'program_slug' => 'bakti-sosial-technology-for-community',
                'title' => '[CONTOH] Bakti Sosial & Berbagi HMIF ITATS',
                'slug' => 'bakti-sosial-hmif-2026',
                'category' => 'Sosial',
                'event_date' => '2026-11-08',
                'location' => 'Surabaya Timur',
                'summary' => 'Penyaluran paket kebutuhan pokok dan edukasi literasi digital aman bagi masyarakat sekitar kampus.',
                'content' => "Contoh laporan kegiatan sosial masyarakat untuk verifikasi tampilan berita kegiatan.\n\nPendampingan literasi keamanan akun digital bagi warga dan pelajar sekitar kampus ITATS.",
                'cover_image' => 'image/hmif-baksos.jpg',
                'is_published' => true,
            ],
            [
                'program_slug' => null,
                'title' => '[CONTOH] Turnamen Futsal Informatika Cup',
                'slug' => 'futsal-informatika-cup-2026',
                'category' => 'Minat & Bakat',
                'event_date' => '2026-10-04',
                'location' => 'Lapangan Olahraga Kampus ITATS',
                'summary' => 'Ajang sportivitas antar-angkatan Teknik Informatika untuk mempererat solidaritas mahasiswa.',
                'content' => "Contoh kegiatan minat dan bakat olahraga untuk verifikasi kartu kegiatan.\n\nKompetisi persahabatan antarkelas Program Studi Teknik Informatika ITATS.",
                'cover_image' => 'image/hmif-gemini-futsal.jpg',
                'is_published' => true,
            ],
            [
                'program_slug' => 'penyambutan-wisudawan-ke-75',
                'title' => '[CONTOH] Apresiasi Wisudawan Teknik Informatika',
                'slug' => 'apresiasi-wisudawan-informatika',
                'category' => 'Kemahasiswaan',
                'event_date' => '2026-08-30',
                'location' => 'Kampus ITATS Surabaya',
                'summary' => 'Momen pelepasan dan apresiasi bagi lulusan Program Studi Teknik Informatika ITATS.',
                'content' => 'Contoh agenda pelepasan wisudawan untuk verifikasi dokumentasi kegiatan di lingkungan lokal.',
                'cover_image' => 'image/hmif-wisuda72.jpg',
                'is_published' => true,
            ],
        ];

        foreach ($activities as $activityData) {
            $programSlug = $activityData['program_slug'];
            unset($activityData['program_slug']);

            Activity::query()->updateOrCreate(
                ['slug' => $activityData['slug']],
                array_merge($activityData, [
                    'period_id' => $period->id,
                    'work_program_id' => $programSlug ? ($programsBySlug[$programSlug] ?? null) : null,
                ])
            );
        }

        $announcements = [
            [
                'title' => '[CONTOH] Informasi Layanan Portal HMIF ITATS Periode 2026/2027',
                'slug' => 'rekrutmen-pengurus-hmif-2026',
                'category' => 'Tata Kelola',
                'published_at' => '2026-11-24 09:00:00',
                'excerpt' => 'Pengumuman contoh untuk memverifikasi tata letak kartu dan detail pengumuman pada environment lokal.',
                'content' => "Contoh pengumuman resmi untuk pengujian antarmuka portal HMIF ITATS Kabinet Asakusa.\n\nSeluruh konten bertanda [CONTOH] hanya muncul pada environment non-production.",
                'is_pinned' => true,
                'is_published' => true,
            ],
            [
                'title' => '[CONTOH] Kebijakan Privasi Portal & Penghapusan NPM Publik',
                'slug' => 'kebijakan-privasi-portal-hmif-2026',
                'category' => 'Tata Kelola',
                'published_at' => '2026-11-20 14:00:00',
                'excerpt' => 'Contoh pengumuman kebijakan perlindungan data pribadi tanpa penayangan NPM maupun kontak pribadi pengurus.',
                'content' => "Contoh pengumuman privasi untuk lingkungan pengembangan lokal.\n\nHalaman kepengurusan hanya menayangkan nama, jabatan, divisi, dan periode bakti.",
                'is_pinned' => false,
                'is_published' => true,
            ],
            [
                'title' => '[CONTOH] Arsip Informasi Pemilu Raya HMIF ITATS',
                'slug' => 'arsip-hasil-pemilu-2026-2027',
                'category' => 'Pemilu',
                'published_at' => '2026-11-10 17:00:00',
                'excerpt' => 'Contoh arsip pemberitahuan status penutupan simulasi pemungutan suara pada portal.',
                'content' => 'Contoh catatan arsip pemilu untuk verifikasi halaman daftar dan detail pengumuman di environment lokal.',
                'is_pinned' => false,
                'is_published' => true,
            ],
        ];

        foreach ($announcements as $announcementData) {
            Announcement::query()->updateOrCreate(
                ['slug' => $announcementData['slug']],
                array_merge($announcementData, ['period_id' => $period->id])
            );
        }

        // Closed example election linked to the active official period (non-production only).
        $election = Election::query()->updateOrCreate(
            ['slug' => 'pemira-hmif-2026-2027'],
            [
                'period_id' => $period->id,
                'title' => '[CONTOH] Simulasi Pemilu Raya HMIF ITATS 2026/2027',
                'description' => 'Data simulasi pemilihan umum raya Ketua HMIF ITATS untuk pengujian status arsip pada environment lokal.',
                'status' => Election::STATUS_CLOSED,
                'starts_at' => '2026-11-01 08:00:00',
                'ends_at' => '2026-11-03 17:00:00',
            ]
        );

        ElectionCandidate::query()->updateOrCreate(
            ['election_id' => $election->id, 'candidate_number' => 1],
            [
                'ketua_name' => 'Kandidat Contoh 01 (Simulasi Lokal)',
                'wakil_name' => null,
                'tagline' => 'Transparansi & Sinergi Karya',
                'vision_mission' => "Visi:\nContoh visi kandidat untuk verifikasi halaman arsip pemilu.\n\nMisi:\n1. Contoh misi tata kelola terbuka.\n2. Contoh misi komunitas riset Informatika.",
            ]
        );

        ElectionCandidate::query()->updateOrCreate(
            ['election_id' => $election->id, 'candidate_number' => 2],
            [
                'ketua_name' => 'Kandidat Contoh 02 (Simulasi Lokal)',
                'wakil_name' => null,
                'tagline' => 'Kolaborasi Aktif Informatika',
                'vision_mission' => "Visi:\nContoh visi kandidat kedua untuk verifikasi halaman arsip pemilu.\n\nMisi:\n1. Contoh misi penguatan minat bakat.\n2. Contoh misi sinergi mahasiswa dan alumni.",
            ]
        );
    }
}
