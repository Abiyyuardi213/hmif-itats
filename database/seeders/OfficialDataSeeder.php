<?php

namespace Database\Seeders;

use App\Models\BoardMember;
use App\Models\Division;
use App\Models\OrganizationSetting;
use App\Models\Period;
use App\Models\WorkProgram;
use Illuminate\Database\Seeder;

class OfficialDataSeeder extends Seeder
{
    /**
     * Seed official Kabinet Asakusa 2026/2027 data approved in R1D-a across every environment.
     */
    public function run(): void
    {
        OrganizationSetting::setMany([
            'org_name' => 'Himpunan Mahasiswa Teknik Informatika',
            'org_short_name' => 'HMIF ITATS',
            'campus_name' => 'Institut Teknologi Adhi Tama Surabaya',
            'email' => 'hmifitats1991@gmail.com',
            'phone' => '',
            'address' => 'Gedung A Kampus ITATS, Arief Rahman Hakim No.100, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117',
            'instagram_url' => 'https://www.instagram.com/hmif_itats/',
            'github_url' => '',
            'linkedin_url' => '',
            'youtube_url' => '',
            'hero_headline' => 'Bertumbuh. Berjejaring. Berkarya.',
            'hero_subtitle' => 'Portal resmi program kerja, informasi kegiatan, arsip kepengurusan, dan layanan digital HMIF Institut Teknologi Adhi Tama Surabaya.',
        ]);

        Period::query()
            ->where('name', '!=', '2026/2027')
            ->update(['is_active' => false]);

        $period = Period::query()->updateOrCreate(
            ['name' => '2026/2027'],
            [
                'cabinet_name' => 'Kabinet Asakusa',
                'tagline' => 'CONNECT. INNOVATE. EMPOWER.',
                'vision' => 'Kabinet Asakusa merupakan kepengurusan Himpunan Mahasiswa Teknik Informatika ITATS Periode 2026/2027 yang berkomitmen membangun lingkungan organisasi yang kolaboratif, inovatif, dan berorientasi pada pengembangan potensi mahasiswa. Melalui empat divisi, Kabinet Asakusa berupaya menjadi wadah pengembangan kompetensi, kreativitas, komunikasi, serta kontribusi nyata bagi mahasiswa Teknik Informatika.',
                'mission' => [
                    'CONNECT: Membangun konektivitas, komunikasi, dan kolaborasi antaranggota serta mahasiswa Teknik Informatika.',
                    'INNOVATE: Mendorong kreativitas, eksplorasi ide, dan inovasi untuk menghasilkan solusi serta karya yang bermanfaat.',
                    'EMPOWER: Mengembangkan potensi dan kompetensi mahasiswa agar mampu bertumbuh, mandiri, dan memberikan kontribusi nyata.',
                ],
                'is_active' => true,
                'starts_at' => null,
                'ends_at' => null,
            ]
        );

        $divisionsSpec = [
            [
                'code' => 'DIV-01',
                'slug' => 'psdm',
                'name' => 'Pengembangan Sumber Daya Mahasiswa (PSDM)',
                'short_description' => 'Pembinaan, kaderisasi, kepemimpinan, dan pengembangan kapasitas mahasiswa.',
                'description' => 'Divisi yang berfokus pada pengembangan kualitas sumber daya mahasiswa melalui pembinaan, kaderisasi, peningkatan kapasitas, serta penguatan karakter dan kepemimpinan. PSDM berperan dalam menciptakan lingkungan organisasi yang mendorong setiap anggota untuk berkembang secara personal maupun profesional. (Tagline: DEVELOP PEOPLE, BUILD LEADERS.)',
                'sort_order' => 1,
                'members' => [
                    ['name' => 'Aryo Syarif Kamal Akbar', 'position' => 'Koordinator Divisi'],
                    ['name' => 'Moch Syahril Akbar', 'position' => 'Anggota'],
                    ['name' => 'Surya Andi Pranata', 'position' => 'Anggota'],
                    ['name' => 'Bagus Choirul Anam', 'position' => 'Anggota'],
                    ['name' => 'Zidane Ishomuddin Dzaki', 'position' => 'Anggota'],
                    ['name' => 'Arik Al Fikri', 'position' => 'Anggota'],
                    ['name' => 'Naufal Muthi Haqqi', 'position' => 'Anggota'],
                    ['name' => 'Vincent Lee Kurniawan', 'position' => 'Anggota'],
                ],
            ],
            [
                'code' => 'DIV-02',
                'slug' => 'litbang',
                'name' => 'Penelitian dan Pengembangan (Litbang)',
                'short_description' => 'Penelitian, eksplorasi teknologi, inovasi, dan pengembangan wawasan.',
                'description' => 'Divisi yang berfokus pada pengembangan wawasan, pengetahuan, dan kemampuan intelektual mahasiswa melalui penelitian, eksplorasi teknologi, serta pengembangan inovasi. Litbang menjadi wadah untuk mendorong budaya berpikir kritis, analitis, kreatif, dan solutif dalam menghadapi perkembangan teknologi informasi. (Tagline: EXPLORE IDEAS, CREATE INNOVATION.)',
                'sort_order' => 2,
                'members' => [
                    ['name' => 'Wahyu Aditia Putra', 'position' => 'Koordinator Divisi'],
                    ['name' => 'Achmad Ali Fatahillah', 'position' => 'Anggota'],
                    ['name' => 'Radith Ramzy Razzan Alasfyi', 'position' => 'Anggota'],
                    ['name' => 'Rizki Okta Lesmana', 'position' => 'Anggota'],
                    ['name' => 'Andika Dyan Syahputra', 'position' => 'Anggota'],
                    ['name' => 'Dafa Putra Fitrianto', 'position' => 'Anggota'],
                    ['name' => 'Trionaldy Junyan Pradewa', 'position' => 'Anggota'],
                ],
            ],
            [
                'code' => 'DIV-03',
                'slug' => 'media-humas',
                'name' => 'Media Digital dan Hubungan Masyarakat (Media HUMAS)',
                'short_description' => 'Publikasi, komunikasi, dokumentasi, dan citra organisasi.',
                'description' => 'Divisi yang bertanggung jawab dalam mengelola komunikasi, informasi, publikasi, dan citra organisasi. Media HUMAS menjadi penghubung antara HMIF ITATS dengan mahasiswa serta pihak eksternal melalui pengelolaan media digital, produksi konten kreatif, dokumentasi, dan penyebaran informasi organisasi. (Tagline: CONNECT PEOPLE, SHARE INFORMATION.)',
                'sort_order' => 3,
                'members' => [
                    ['name' => 'M. Farhan Magribi', 'position' => 'Koordinator Divisi'],
                    ['name' => 'Abdiel Rozi Syahputra', 'position' => 'Anggota'],
                    ['name' => 'Rivan Pramudya Erlangga', 'position' => 'Anggota'],
                    ['name' => 'Aditya Maulana Zidqy', 'position' => 'Anggota'],
                    ['name' => 'Rafi Satrya Rahmansyah', 'position' => 'Anggota'],
                    ['name' => 'Drajat Febrio Ardi', 'position' => 'Anggota'],
                    ['name' => 'Ady Setiawan', 'position' => 'Anggota'],
                    ['name' => 'Ari Irawan', 'position' => 'Anggota'],
                ],
            ],
            [
                'code' => 'DIV-04',
                'slug' => 'danus',
                'name' => 'Pengembangan Dana Usaha dan Minat Bakat (Danus)',
                'short_description' => 'Kewirausahaan, pengembangan dana, minat, dan bakat mahasiswa.',
                'description' => 'Divisi yang berfokus pada pengembangan potensi kewirausahaan, pengelolaan kegiatan usaha, serta penyaluran minat dan bakat mahasiswa. Danus berperan dalam mendukung kemandirian finansial organisasi sekaligus menyediakan ruang bagi mahasiswa untuk mengeksplorasi kreativitas, mengembangkan keterampilan, dan menyalurkan bakat di berbagai bidang. (Tagline: BUILD OPPORTUNITIES, UNLEASH POTENTIAL.)',
                'sort_order' => 4,
                'members' => [
                    ['name' => 'Ardhi Fadli', 'position' => 'Koordinator Divisi'],
                    ['name' => 'Rafly Rizki Pratama', 'position' => 'Anggota'],
                    ['name' => 'Muhammad Rifqi', 'position' => 'Anggota'],
                    ['name' => 'Rizki Eka Maulana', 'position' => 'Anggota'],
                    ['name' => 'Albertho Octaviano Rumagit Rachman', 'position' => 'Anggota'],
                    ['name' => 'M. Sevencho Wijayanto Putra', 'position' => 'Anggota'],
                    ['name' => 'Ahmad Shohibul Wafa', 'position' => 'Anggota'],
                ],
            ],
        ];

        $divisionsBySlug = [];
        foreach ($divisionsSpec as $item) {
            $members = $item['members'];
            unset($item['members']);

            $division = Division::query()->updateOrCreate(
                ['period_id' => $period->id, 'slug' => $item['slug']],
                $item
            );
            $divisionsBySlug[$division->slug] = $division;

            foreach ($members as $index => $member) {
                BoardMember::query()->updateOrCreate(
                    ['period_id' => $period->id, 'name' => $member['name']],
                    [
                        'division_id' => $division->id,
                        'position' => $member['position'],
                        'is_core' => false,
                        'sort_order' => ($division->sort_order * 10) + $index + 1,
                    ]
                );
            }
        }

        $coreBoard = [
            ['name' => 'Ahmad Rizqi Mubarok', 'position' => 'Ketua Umum', 'sort_order' => 1],
            ['name' => 'Gansa Alega Putra Utomo', 'position' => 'Wakil Ketua Umum', 'sort_order' => 2],
            ['name' => 'Ridho Pangestu', 'position' => 'Sekretaris Umum', 'sort_order' => 3],
            ['name' => 'Nur Layli Ramadhani Sufyan', 'position' => 'Bendahara Umum', 'sort_order' => 4],
        ];

        foreach ($coreBoard as $member) {
            BoardMember::query()->updateOrCreate(
                ['period_id' => $period->id, 'name' => $member['name']],
                [
                    'division_id' => null,
                    'position' => $member['position'],
                    'is_core' => true,
                    'sort_order' => $member['sort_order'],
                ]
            );
        }

        $advisors = [
            [
                'name' => "Dr. Mat Syai'in, S.T ., M.T ., Ph.D",
                'position' => 'Pelindung — Rektor ITATS',
                'sort_order' => 101,
            ],
            [
                'name' => 'Ahmad Yusuf Ismail, ST ., M.Sc., Ph.D',
                'position' => 'Penasihat 1 — Plt. Wakil Rektor 1 Bidang Kemahasiswaan ITATS',
                'sort_order' => 102,
            ],
            [
                'name' => 'Fahmi Firdaus Alrizal, S.T ., M.T .',
                'position' => 'Penasihat 2 — Ka. Penalaran Bakat dan Minat ITATS',
                'sort_order' => 103,
            ],
            [
                'name' => 'Dr. Rahmi Rizkiana Putri, S.ST ., M.Kom.',
                'position' => 'Penasihat 3 — Kepala Program Studi Teknik Informatika ITATS',
                'sort_order' => 104,
            ],
            [
                'name' => 'Muchamad Kurniawan, S.Kom., M.Kom',
                'position' => 'Dosen Penanggung Jawab — Dosen Pembina HMIF ITATS',
                'sort_order' => 105,
            ],
        ];

        foreach ($advisors as $advisor) {
            BoardMember::query()->updateOrCreate(
                ['period_id' => $period->id, 'name' => $advisor['name']],
                [
                    'division_id' => null,
                    'position' => $advisor['position'],
                    'is_core' => false,
                    'sort_order' => $advisor['sort_order'],
                ]
            );
        }

        $workPrograms = [
            [
                'division_slug' => 'psdm',
                'title' => 'Musyawarah Himpunan (MUSHIM) HMIF ITATS 2026',
                'slug' => 'musyawarah-himpunan-mushim-hmif-itats-2026',
                'description' => 'Pelaksanaan Musyawarah Himpunan sebagai forum evaluasi, pembahasan AD/ART & GBHO, serta pertanggungjawaban kepengurusan. (Pelaksanaan: Oktober 2026; Lingkup: Internal; Penanggung jawab PDF: BPH Inti & PSDM.)',
            ],
            [
                'division_slug' => 'psdm',
                'title' => 'Open Recruitment & Member Onboarding HMIF ITATS 2026',
                'slug' => 'open-recruitment-member-onboarding-hmif-itats-2026',
                'description' => 'Pelaksanaan penerimaan anggota baru HMIF ITATS yang dilanjutkan dengan proses onboarding dan pengenalan struktur organisasi. (Pelaksanaan: Oktober - November 2026; Lingkup: Internal; Penanggung jawab PDF: PSDM.)',
            ],
            [
                'division_slug' => 'psdm',
                'title' => 'Pengembangan Manajemen Organisasi (PMO) HMIF ITATS 2026',
                'slug' => 'pengembangan-manajemen-organisasi-pmo-hmif-itats-2026',
                'description' => 'Kegiatan pengembangan kemampuan dasar organisasi bagi pengurus dan anggota baru HMIF ITATS meliputi tata kelola dan manajemen proyek. (Pelaksanaan: November - Desember 2026; Lingkup: Internal; Penanggung jawab PDF: PSDM.)',
            ],
            [
                'division_slug' => 'psdm',
                'title' => 'HMIF Competency Mapping',
                'slug' => 'hmif-competency-mapping',
                'description' => 'Kegiatan pemetaan minat, bakat, kemampuan dasar, serta kebutuhan pengembangan hard skill dan soft skill seluruh anggota. (Pelaksanaan: November - Desember 2026; Lingkup: Internal; Penanggung jawab PDF: PSDM & Litbang.)',
            ],
            [
                'division_slug' => 'litbang',
                'title' => 'HMIF Community',
                'slug' => 'hmif-community',
                'description' => 'Pembentukan komunitas belajar (study group) berbasis minat dan kompetensi mahasiswa Teknik Informatika ITATS. (Pelaksanaan: Desember 2026 - Juli 2027; Lingkup: Internal; Penanggung jawab PDF: Litbang.)',
            ],
            [
                'division_slug' => 'danus',
                'title' => 'Pengadaan dan Penjualan Atribut HMIF & Teknik Informatika',
                'slug' => 'pengadaan-dan-penjualan-atribut-hmif-teknik-informatika',
                'description' => 'Pengadaan dan penjualan atribut resmi seperti baju PDH serta merchandise HMIF dan Program Studi Teknik Informatika. (Pelaksanaan: November 2026; Lingkup: Internal; Penanggung jawab PDF: Danus & Minat Bakat.)',
            ],
            [
                'division_slug' => 'media-humas',
                'title' => 'Penyambutan Wisudawan Ke-75',
                'slug' => 'penyambutan-wisudawan-ke-75',
                'description' => 'Kegiatan penyambutan dan arak-arakan wisudawan ke-75 Program Studi Teknik Informatika oleh HMIF ITATS. (Pelaksanaan: November 2026; Lingkup: Internal; Penanggung jawab PDF: Seluruh Divisi.)',
            ],
            [
                'division_slug' => 'media-humas',
                'title' => 'Bakti Sosial & Technology for Community',
                'slug' => 'bakti-sosial-technology-for-community',
                'description' => 'Kegiatan sosial, edukasi teknologi, dan pengabdian kepada masyarakat yang melibatkan mahasiswa Teknik Informatika. (Pelaksanaan: Februari 2027; Lingkup: Internal & Eksternal; Penanggung jawab PDF: HUMAS & Litbang.)',
            ],
            [
                'division_slug' => 'media-humas',
                'title' => 'Penyambutan Wisudawan Ke-76',
                'slug' => 'penyambutan-wisudawan-ke-76',
                'description' => 'Kegiatan penyambutan wisudawan ke-76 Program Studi Teknik Informatika oleh HMIF ITATS. (Pelaksanaan: Mei 2027; Lingkup: Internal; Penanggung jawab PDF: Seluruh Divisi.)',
            ],
            [
                'division_slug' => 'psdm',
                'title' => 'Debat Calon Ketua HMIF & Pemilu Raya 2027/2028',
                'slug' => 'debat-calon-ketua-hmif-pemilu-raya-2027-2028',
                'description' => 'Pelaksanaan regenerasi Ketua Himpunan HMIF melalui sosialisasi, pendaftaran, seleksi, debat publik, dan pemungutan suara. (Pelaksanaan: September 2027; Lingkup: Internal; Penanggung jawab PDF: PSDM & BPH.)',
            ],
            [
                'division_slug' => 'psdm',
                'title' => 'Musyawarah Himpunan Periode 2027/2028',
                'slug' => 'musyawarah-himpunan-periode-2027-2028',
                'description' => 'Pelaksanaan sidang pleno revisi AD/ART, GBHO, dan Laporan Pertanggungjawaban (LPJ) akhir periode HMIF ITATS. (Pelaksanaan: Oktober 2027; Lingkup: Internal; Penanggung jawab PDF: BPH Inti.)',
            ],
            [
                'division_slug' => 'litbang',
                'title' => 'HMIF Academy: Hard Skill & Soft Skill Development',
                'slug' => 'hmif-academy-hard-skill-soft-skill-development',
                'description' => 'Program pengembangan kompetensi mahasiswa melalui rangkaian workshop, sharing session, mentoring, dan praktik proyek. (Pelaksanaan: Januari - Juni 2027; Lingkup: Internal; Penanggung jawab PDF: Litbang.)',
            ],
        ];

        foreach ($workPrograms as $program) {
            $division = $divisionsBySlug[$program['division_slug']];

            WorkProgram::query()->updateOrCreate(
                ['period_id' => $period->id, 'slug' => $program['slug']],
                [
                    'division_id' => $division->id,
                    'title' => $program['title'],
                    'description' => $program['description'],
                    'status' => 'planned',
                    'target_date' => null,
                    'realized_at' => null,
                    'target_participants' => null,
                ]
            );
        }
    }
}
