<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\BoardMember;
use App\Models\Division;
use App\Models\Election;
use App\Models\ElectionCandidate;
use App\Models\OrganizationSetting;
use App\Models\Period;
use App\Models\User;
use App\Models\WorkProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@hmif-itats.site'],
            [
                'name' => 'Administrator HMIF ITATS',
                'password' => Hash::make('HMIF-Admin-ChangeMe!2026'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        OrganizationSetting::setMany([
            'org_name' => 'Himpunan Mahasiswa Teknik Informatika',
            'org_short_name' => 'HMIF ITATS',
            'campus_name' => 'Institut Teknologi Adhi Tama Surabaya',
            'email' => 'hmif@itats.ac.id',
            'phone' => '+62 31 5991101',
            'address' => 'Jl. Arief Rachman Hakim No. 100, Klampis Ngasem, Sukolilo, Surabaya 60117',
            'instagram_url' => 'https://www.instagram.com/hmif_itats/',
            'github_url' => '',
            'linkedin_url' => '',
            'youtube_url' => '',
            'hero_headline' => 'Wadah Kolaborasi & Rekayasa Teknologi Mahasiswa Informatika ITATS',
            'hero_subtitle' => 'Portal resmi program kerja, informasi kegiatan, arsip kepengurusan, dan layanan digital HMIF Institut Teknologi Adhi Tama Surabaya.',
        ]);

        // Archived previous period (2025/2026) — preserved cleanly without exposing personal NPMs.
        $prevPeriod = Period::query()->updateOrCreate(
            ['name' => '2025/2026'],
            [
                'cabinet_name' => 'Kabinet Akselerasi',
                'tagline' => 'Aktif, Adaptif, dan Profesional',
                'vision' => 'Mewujudkan HMIF ITATS sebagai wadah yang aktif, adaptif, dan profesional dalam mengembangkan SDM Teknik Informatika.',
                'mission' => [
                    'Mengembangkan kapasitas soft-skill dan hard-skill anggota melalui pelatihan berkelanjutan.',
                    'Membentuk budaya profesionalisme, tanggung jawab, dan etika organisasi.',
                    'Menjalin kolaborasi strategis dengan alumni, industri, dan komunitas IT.',
                    'Mengelola program kerja secara terukur dan berdampak nyata.',
                ],
                'is_active' => false,
                'starts_at' => '2025-09-01',
                'ends_at' => '2026-08-31',
            ]
        );

        $prevCore = [
            ['name' => 'R. Abiyyu Ardi Lian Permadi', 'position' => 'Ketua HMIF', 'sort_order' => 1],
            ['name' => 'Nur Layli Ramadhani Sufyan', 'position' => 'Wakil Ketua HMIF', 'sort_order' => 2],
            ['name' => 'Ridho Pangestu', 'position' => 'Sekretaris HMIF', 'sort_order' => 3],
            ['name' => 'Rizka Amalia', 'position' => 'Bendahara HMIF', 'sort_order' => 4],
        ];

        foreach ($prevCore as $member) {
            BoardMember::query()->updateOrCreate(
                ['period_id' => $prevPeriod->id, 'name' => $member['name'], 'position' => $member['position']],
                ['division_id' => null, 'is_core' => true, 'sort_order' => $member['sort_order']]
            );
        }

        // Active period (2026/2027) — ready for the incoming Kahim & cabinet via Admin CMS.
        $activePeriod = Period::query()->updateOrCreate(
            ['name' => '2026/2027'],
            [
                'cabinet_name' => 'Kabinet Inovasi Terbuka',
                'tagline' => 'Transparan dalam Tata Kelola, Unggul dalam Karya Digital',
                'vision' => 'Menjadikan HMIF ITATS sebagai ekosistem kolaborasi mahasiswa Teknik Informatika yang transparan, berdampak akademik, dan adaptif terhadap rekayasa teknologi modern.',
                'mission' => [
                    'Menghadirkan tata kelola organisasi berbasis data terbuka dan dokumentasi program kerja yang akuntabel.',
                    'Meningkatkan kompetensi riset, rekayasa perangkat lunak, dan prestasi kompetisi mahasiswa Informatika ITATS.',
                    'Memperkuat jejaring kemitraan bersama alumni, industri teknologi, serta komunitas pengembang.',
                    'Menyediakan layanan digital himpunan yang aman, cepat, dan mudah diakses seluruh mahasiswa.',
                ],
                'is_active' => true,
                'starts_at' => '2026-09-01',
                'ends_at' => '2027-08-31',
            ]
        );

        $divisionsData = [
            [
                'code' => 'DIV-01',
                'name' => 'Pengembangan Sumber Daya Mahasiswa (PSDM)',
                'slug' => 'psdm',
                'short_description' => 'Kaderisasi, mentoring mahasiswa baru, dan peningkatan kapasitas kepemimpinan.',
                'description' => 'Bertanggung jawab atas proses kaderisasi, pelatihan manajemen organisasi, serta pembinaan karakter mahasiswa Teknik Informatika ITATS.',
                'sort_order' => 1,
                'lead' => 'Koordinator PSDM (Segera Diperbarui)',
            ],
            [
                'code' => 'DIV-02',
                'name' => 'Riset, Keilmuan & Teknologi',
                'slug' => 'riset-keilmuan',
                'short_description' => 'Study club, workshop teknis, persiapan PKM, dan pendampingan lomba IT.',
                'description' => 'Mengelola kelompok belajar pemrograman, AI, keamanan siber, serta fasilitasi riset dan kompetisi teknologi.',
                'sort_order' => 2,
                'lead' => 'Koordinator Riset & Keilmuan (Segera Diperbarui)',
            ],
            [
                'code' => 'DIV-03',
                'name' => 'Komunikasi & Informasi (Kominfo)',
                'slug' => 'kominfo',
                'short_description' => 'Publikasi media, dokumentasi acara, desain visual, dan manajemen kanal resmi.',
                'description' => 'Menjadi garda depan informasi HMIF ITATS melalui media sosial, portal berita, serta dokumentasi seluruh agenda himpunan.',
                'sort_order' => 3,
                'lead' => 'Koordinator Kominfo (Segera Diperbarui)',
            ],
            [
                'code' => 'DIV-04',
                'name' => 'Hubungan Masyarakat & Kemitraan',
                'slug' => 'humas-kemitraan',
                'short_description' => 'Relasi eksternal, kolaborasi alumni, mitra industri, dan antar-ormawa.',
                'description' => 'Menjembatani komunikasi HMIF dengan jurusan, alumni, komunitas IT Surabaya, dan mitra sponsor atau industri.',
                'sort_order' => 4,
                'lead' => 'Koordinator Humas & Kemitraan (Segera Diperbarui)',
            ],
            [
                'code' => 'DIV-05',
                'name' => 'Sosial Masyarakat & Minat Bakat',
                'slug' => 'sosmas-minat-bakat',
                'short_description' => 'Pengabdian masyarakat, bakti sosial, olahraga, dan solidaritas mahasiswa.',
                'description' => 'Menggerakkan kegiatan pengabdian masyarakat berbasis kepedulian sosial serta menyalurkan minat bakat non-akademik mahasiswa.',
                'sort_order' => 5,
                'lead' => 'Koordinator Sosmas & Minat Bakat (Segera Diperbarui)',
            ],
            [
                'code' => 'DIV-06',
                'name' => 'Pengembangan & Sistem Digital',
                'slug' => 'sistem-digital',
                'short_description' => 'Pemeliharaan portal web, otomasi layanan mahasiswa, dan tata kelola repositori.',
                'description' => 'Tim teknis internal himpunan yang mengembangkan, mengaudit keamanan, dan memelihara portal HMIF ITATS secara berkelanjutan.',
                'sort_order' => 6,
                'lead' => 'Koordinator Sistem Digital (Segera Diperbarui)',
            ],
        ];

        $divisionsBySlug = [];
        foreach ($divisionsData as $item) {
            $leadName = $item['lead'];
            unset($item['lead']);

            $division = Division::query()->updateOrCreate(
                ['period_id' => $activePeriod->id, 'slug' => $item['slug']],
                $item
            );
            $divisionsBySlug[$item['slug']] = $division;

            BoardMember::query()->updateOrCreate(
                ['period_id' => $activePeriod->id, 'division_id' => $division->id, 'position' => 'Koordinator Divisi'],
                [
                    'name' => $leadName,
                    'is_core' => false,
                    'sort_order' => $item['sort_order'] * 10,
                ]
            );
        }

        $activeCore = [
            ['name' => 'Ketua Himpunan Terpilih 2026/2027', 'position' => 'Ketua HMIF', 'sort_order' => 1],
            ['name' => 'Wakil Ketua Himpunan 2026/2027', 'position' => 'Wakil Ketua HMIF', 'sort_order' => 2],
            ['name' => 'Sekretaris Umum 2026/2027', 'position' => 'Sekretaris Umum', 'sort_order' => 3],
            ['name' => 'Bendahara Umum 2026/2027', 'position' => 'Bendahara Umum', 'sort_order' => 4],
        ];

        foreach ($activeCore as $member) {
            BoardMember::query()->updateOrCreate(
                ['period_id' => $activePeriod->id, 'position' => $member['position'], 'is_core' => true],
                ['name' => $member['name'], 'division_id' => null, 'sort_order' => $member['sort_order']]
            );
        }

        $programs = [
            [
                'division' => 'psdm',
                'title' => 'Pelatihan Manajemen Organisasi (PMO) Informatika',
                'slug' => 'pmo-informatika',
                'description' => 'Pembekalan kepemimpinan, administrasi kegiatan, dan kolaborasi tim bagi mahasiswa baru Teknik Informatika.',
                'status' => 'completed',
                'target_date' => '2026-09-20',
                'realized_at' => '2026-09-22',
                'target_participants' => 140,
            ],
            [
                'division' => 'riset-keilmuan',
                'title' => 'ITATS DevWorkshop: Modern Web & Cloud Architecture',
                'slug' => 'devworkshop-modern-web',
                'description' => 'Seri lokakarya praktik membangun API aman, pengelolaan database relasional, dan deployment aplikasi modern.',
                'status' => 'completed',
                'target_date' => '2026-10-18',
                'realized_at' => '2026-10-18',
                'target_participants' => 95,
            ],
            [
                'division' => 'sosmas-minat-bakat',
                'title' => 'HMIF Peduli & Bakti Sosial Surabaya Timur',
                'slug' => 'hmif-baksos-surabaya',
                'description' => 'Aksi penggalangan donasi, literasi digital dasar, dan santunan sosial bersama mahasiswa Informatika.',
                'status' => 'completed',
                'target_date' => '2026-11-08',
                'realized_at' => '2026-11-08',
                'target_participants' => 70,
            ],
            [
                'division' => 'sistem-digital',
                'title' => 'Modernisasi Portal HMIF & Tata Kelola Data Terbuka',
                'slug' => 'modernisasi-portal-hmif',
                'description' => 'Audit keamanan, penghapusan eksposur NPM publik, sentralisasi CMS proker/kegiatan, serta penyusunan standar maintainer Divisi 6.',
                'status' => 'in_progress',
                'target_date' => '2026-12-15',
                'realized_at' => null,
                'target_participants' => 300,
            ],
            [
                'division' => 'humas-kemitraan',
                'title' => 'Alumni Tech Talk & Persiapan Magang Industri',
                'slug' => 'alumni-tech-talk',
                'description' => 'Sesi berbagi pengalaman alumni Teknik Informatika ITATS mengenai portofolio engineering, wawancara teknis, dan jalur magang.',
                'status' => 'planned',
                'target_date' => '2027-02-14',
                'realized_at' => null,
                'target_participants' => 150,
            ],
            [
                'division' => 'kominfo',
                'title' => 'Buletin & Arsip Digital Prestasi Mahasiswa',
                'slug' => 'arsip-digital-prestasi',
                'description' => 'Publikasi berkala capaian kompetisi, riset, dan karya perangkat lunak mahasiswa Teknik Informatika ITATS.',
                'status' => 'in_progress',
                'target_date' => '2027-03-01',
                'realized_at' => null,
                'target_participants' => 250,
            ],
        ];

        $programsBySlug = [];
        foreach ($programs as $programData) {
            $division = $divisionsBySlug[$programData['division']];
            unset($programData['division']);

            $program = WorkProgram::query()->updateOrCreate(
                ['period_id' => $activePeriod->id, 'slug' => $programData['slug']],
                array_merge($programData, [
                    'period_id' => $activePeriod->id,
                    'division_id' => $division->id,
                ])
            );
            $programsBySlug[$program->slug] = $program;
        }

        $activities = [
            [
                'program' => 'pmo-informatika',
                'title' => 'Pelatihan Manajemen Organisasi (PMO) 2026',
                'slug' => 'pmo-2026',
                'category' => 'Kaderisasi',
                'event_date' => '2026-09-22',
                'location' => 'Aula Gedung A ITATS',
                'summary' => 'Pembekalan dasar organisasi dan kolaborasi tim bagi calon kader dan pengurus baru HMIF ITATS.',
                'content' => "Pelatihan Manajemen Organisasi (PMO) 2026 diikuti oleh mahasiswa baru dan calon pengurus Teknik Informatika ITATS.\n\nMateri mencakup tata kelola surat-menyurat, manajemen waktu proyek kepanitiaan, komunikasi publik, serta pengenalan enam divisi aktif di bawah HMIF ITATS.",
                'cover_image' => 'image/hmif-pmo.jpg',
                'is_published' => true,
            ],
            [
                'program' => 'devworkshop-modern-web',
                'title' => 'Webinar & Workshop Arsitektur Web Modern',
                'slug' => 'webinar-arsitektur-web-2026',
                'category' => 'Akademik',
                'event_date' => '2026-10-18',
                'location' => 'Lab Rekayasa Perangkat Lunak ITATS',
                'summary' => 'Workshop praktik pengembangan aplikasi Laravel yang aman, terstruktur, dan siap produksi.',
                'content' => "Kegiatan ini membahas praktik terbaik rekayasa perangkat lunak modern, mulai dari pemodelan database relasional, validasi input, proteksi privasi pengguna, hingga pengujian otomatis.\n\nPeserta juga mempraktikkan alur kolaborasi Git berbasis Pull Request agar terbiasa bekerja dalam tim engineering.",
                'cover_image' => 'image/hmif-webinar.jpg',
                'is_published' => true,
            ],
            [
                'program' => 'hmif-baksos-surabaya',
                'title' => 'Bakti Sosial & Berbagi HMIF ITATS',
                'slug' => 'bakti-sosial-hmif-2026',
                'category' => 'Sosial',
                'event_date' => '2026-11-08',
                'location' => 'Surabaya Timur',
                'summary' => 'Penyaluran paket kebutuhan pokok dan edukasi literasi digital aman bagi masyarakat sekitar kampus.',
                'content' => "Divisi Sosial Masyarakat bersama relawan mahasiswa Informatika menyelenggarakan bakti sosial tahunan di wilayah Surabaya Timur.\n\nSelain penyaluran bantuan logistik, tim mahasiswa juga memberikan pendampingan literasi keamanan akun digital bagi warga dan pelajar.",
                'cover_image' => 'image/hmif-baksos.jpg',
                'is_published' => true,
            ],
            [
                'program' => null,
                'title' => 'Turnamen Futsal Informatika Cup',
                'slug' => 'futsal-informatika-cup-2026',
                'category' => 'Minat & Bakat',
                'event_date' => '2026-10-04',
                'location' => 'Lapangan Olahraga Kampus ITATS',
                'summary' => 'Ajang sportivitas antar-angkatan Teknik Informatika untuk mempererat solidaritas mahasiswa dan alumni.',
                'content' => "Kompetisi futsal antar-angkatan ini mempertemukan tim mahasiswa aktif dari berbagai angkatan Teknik Informatika ITATS.\n\nAcara berlangsung tertib dan menjadi ruang silaturahmi lintas angkatan di luar kegiatan perkuliahan.",
                'cover_image' => 'image/hmif-gemini-futsal.jpg',
                'is_published' => true,
            ],
            [
                'program' => null,
                'title' => 'Apresiasi Wisudawan Teknik Informatika',
                'slug' => 'apresiasi-wisudawan-informatika',
                'category' => 'Kemahasiswaan',
                'event_date' => '2026-08-30',
                'location' => 'Kampus ITATS Surabaya',
                'summary' => 'Momen pelepasan dan apresiasi bagi lulusan Program Studi Teknik Informatika ITATS.',
                'content' => "HMIF ITATS memberikan penghargaan simbolis kepada para wisudawan Teknik Informatika yang telah menyelesaikan studi dan berkontribusi dalam kegiatan kemahasiswaan.\n\nHarapannya jejaring alumni tetap terhubung aktif untuk membimbing adik tingkat di dunia industri maupun riset.",
                'cover_image' => 'image/hmif-wisuda72.jpg',
                'is_published' => true,
            ],
        ];

        foreach ($activities as $activityData) {
            $programSlug = $activityData['program'];
            unset($activityData['program']);

            Activity::query()->updateOrCreate(
                ['slug' => $activityData['slug']],
                array_merge($activityData, [
                    'period_id' => $activePeriod->id,
                    'work_program_id' => $programSlug ? ($programsBySlug[$programSlug]->id ?? null) : null,
                ])
            );
        }

        $announcements = [
            [
                'title' => 'Pembukaan Rekrutmen Maintainer Divisi 6 (Pengembangan & Sistem Digital)',
                'slug' => 'rekrutmen-maintainer-divisi-6-2026',
                'category' => 'Rekrutmen',
                'published_at' => '2026-11-24 09:00:00',
                'excerpt' => 'Terbuka kesempatan bagi mahasiswa Teknik Informatika ITATS untuk bergabung mengelola portal resmi dan infrastruktur digital HMIF.',
                'content' => "HMIF ITATS membuka rekrutmen kontributor teknis pada Divisi 6 (Pengembangan & Sistem Digital) untuk periode 2026/2027.\n\nFokus tim mencakup pengembangan Laravel, frontend Tailwind CSS, pengujian otomatis, serta audit keamanan sistem layanan mahasiswa. Silakan hubungi pengurus melalui halaman Kontak untuk jadwal wawancara teknis.",
                'is_pinned' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Pembaruan Kebijakan Privasi Portal & Penghapusan NPM Publik',
                'slug' => 'kebijakan-privasi-portal-hmif-2026',
                'category' => 'Tata Kelola',
                'published_at' => '2026-11-20 14:00:00',
                'excerpt' => 'Sebagai bentuk perlindungan data pribadi mahasiswa, portal HMIF ITATS tidak lagi menampilkan NPM pengurus pada halaman publik.',
                'content' => "Dalam rangka penyelarasan tata kelola digital dan prinsip perlindungan data pribadi, seluruh halaman profil kepengurusan HMIF ITATS hanya menampilkan nama, jabatan, divisi, dan periode bakti.\n\nData identifikasi akademik hanya diproses di lingkungan terbatas untuk verifikasi internal yang sah.",
                'is_pinned' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Arsip Hasil Pemilu Raya Kahim HMIF ITATS Periode 2026/2027',
                'slug' => 'arsip-hasil-pemilu-2026-2027',
                'category' => 'Pemilu',
                'published_at' => '2026-11-10 17:00:00',
                'excerpt' => 'Sesi pemungutan suara Pemilu Raya HMIF ITATS telah resmi ditutup dan memasuki masa transisi kepengurusan.',
                'content' => "Pemungutan suara untuk pemilihan Ketua HMIF ITATS Periode 2026/2027 telah ditutup sesuai jadwal.\n\nPengurus terpilih tengah menyiapkan susunan kabinet, sinkronisasi program kerja enam divisi, serta pembaruan sistem E-Voting berbasis token terverifikasi untuk penyelenggaraan pemilu mendatang.",
                'is_pinned' => false,
                'is_published' => true,
            ],
        ];

        foreach ($announcements as $announcementData) {
            Announcement::query()->updateOrCreate(
                ['slug' => $announcementData['slug']],
                array_merge($announcementData, ['period_id' => $activePeriod->id])
            );
        }

        // Closed reference election so /pemilu shows clean closed status by default (never an unprotected open ballot).
        $election = Election::query()->updateOrCreate(
            ['slug' => 'pemira-hmif-2026-2027'],
            [
                'period_id' => $activePeriod->id,
                'title' => 'Pemilu Raya Ketua HMIF ITATS 2026/2027',
                'description' => 'Pemilihan umum raya Ketua Himpunan Mahasiswa Teknik Informatika ITATS menggunakan verifikasi DPT dan token surat suara sekali pakai.',
                'status' => Election::STATUS_CLOSED,
                'starts_at' => '2026-11-01 08:00:00',
                'ends_at' => '2026-11-03 17:00:00',
            ]
        );

        ElectionCandidate::query()->updateOrCreate(
            ['election_id' => $election->id, 'candidate_number' => 1],
            [
                'ketua_name' => 'Pasangan Calon 01 (Arsip Pemilu 2026/2027)',
                'wakil_name' => null,
                'tagline' => 'Transparansi & Sinergi Karya',
                'vision_mission' => "Visi:\nMewujudkan himpunan yang inklusif, transparan, dan berdaya saing teknologi.\n\nMisi:\n1. Digitalisasi administrasi program kerja.\n2. Penguatan komunitas riset dan kompetisi Informatika.",
            ]
        );

        ElectionCandidate::query()->updateOrCreate(
            ['election_id' => $election->id, 'candidate_number' => 2],
            [
                'ketua_name' => 'Pasangan Calon 02 (Arsip Pemilu 2026/2027)',
                'wakil_name' => null,
                'tagline' => 'Kolaborasi Aktif Informatika',
                'vision_mission' => "Visi:\nMembangun kolaborasi mahasiswa dan alumni untuk ekosistem karier IT.\n\nMisi:\n1. Pelatihan teknis rutin berbasis kebutuhan industri.\n2. Sinergi solidaritas antar-angkatan.",
            ]
        );
    }
}
