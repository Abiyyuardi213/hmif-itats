# Data Resmi Kepengurusan Kabinet Asakusa HMIF ITATS Periode 2026/2027

**Status dokumen:** Disetujui (`APPROVE R1D-A`) untuk ingest **R1D-b** ke `OfficialDataSeeder`. Memuat data resmi dari 3 PDF di `docs/redesign/source/` serta kelengkapan teks yang disetujui Kahim (tagline & deskripsi kabinet, nama & deskripsi 4 divisi, pemetaan divisi pengampu utama untuk 7 program lintas/BPH, serta email dan alamat resmi sekretariat).

**Sumber berkas resmi (`docs/redesign/source/`, tidak dilacak Git):**
1. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - STRUKTUR KABINET ASAKUSA.pdf` (2 halaman; selanjutnya disingkat `STRUKTUR`)
2. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - BIODATA _ KELENGKAPAN KTM.pdf` (1 halaman; selanjutnya disingkat `BIODATA`)
3. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - PROGRAM KERJA _ RAB.pdf` (1 halaman; selanjutnya disingkat `PROKER`)

> **Batasan privasi & kerahasiaan:** Sesuai PRD US-13 / AC-13.3 dan *Hard Constraints*, seluruh NPM (34 pengurus mahasiswa), NIP (5 pembina/pimpinan), nomor telepon/WhatsApp pribadi (20 individu unik pada PDF serta nomor WhatsApp CP perorangan mantan kahim yang diajukan terpisah), dan seluruh nominal/persentase RAB **dikecualikan sepenuhnya** dari berkas ini, seeder, Git, dan halaman publik.

---

## 1. Identitas Kabinet & Keputusan Owner (`APPROVE R1D-A`)

| Atribut | Nilai resmi | Sumber rujukan |
|---|---|---|
| Nama organisasi | Himpunan Mahasiswa Teknik Informatika (HMIF) ITATS | `STRUKTUR, halaman 1`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Nama kabinet | Kabinet Asakusa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Periode kepengurusan | 2026/2027 (Aktif; belum ada periode arsip sampai snapshot situs live tersedia) | `STRUKTUR, halaman 1`; PRD AC-4.3 & AC-13.2 |
| Tagline resmi kabinet | `CONNECT. INNOVATE. EMPOWER.` | Ketetapan Kahim pada `APPROVE R1D-A` (tidak tertulis di PDF) |
| Deskripsi / Visi kabinet | Kabinet Asakusa merupakan kepengurusan Himpunan Mahasiswa Teknik Informatika ITATS Periode 2026/2027 yang berkomitmen membangun lingkungan organisasi yang kolaboratif, inovatif, dan berorientasi pada pengembangan potensi mahasiswa. Melalui empat divisi, Kabinet Asakusa berupaya menjadi wadah pengembangan kompetensi, kreativitas, komunikasi, serta kontribusi nyata bagi mahasiswa Teknik Informatika. | Ketetapan Kahim pada `APPROVE R1D-A` |
| Tiga pilar / Misi kabinet | 1. **CONNECT:** Membangun konektivitas, komunikasi, dan kolaborasi antaranggota serta mahasiswa Teknik Informatika. 2. **INNOVATE:** Mendorong kreativitas, eksplorasi ide, dan inovasi untuk menghasilkan solusi serta karya yang bermanfaat. 3. **EMPOWER:** Mengembangkan potensi dan kompetensi mahasiswa agar mampu bertumbuh, mandiri, dan memberikan kontribusi nyata. | Ketetapan Kahim pada `APPROVE R1D-A` |
| Status Sertijab dalam PDF | `UNVERIFIED: Sertijab status` di berkas PDF (`STRUKTUR` hanya mencatat `Mandat Musyawarah Mahasiswa` dan transisi berkas Oprec); Kahim mengonfirmasi secara lisan MUSHIM & Sertijab sudah terlaksana sebelum R0 | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1`; konfirmasi Kahim |

---

## 2. Kontak Resmi (Terverifikasi Owner untuk `OrganizationSetting`)

| Kanal kontak resmi | Nilai resmi yang disimpan di `OfficialDataSeeder` | Status & keterangan |
|---|---|---|
| Email resmi organisasi | `hmifitats1991@gmail.com` | Disetujui Kahim untuk organisasi HMIF ITATS (bukan dari PDF; pengecualian resmi pola `@...`) |
| Alamat sekretariat resmi | `Gedung A Kampus ITATS, Arief Rahman Hakim No.100, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117` | Disetujui Kahim (alamat kampus & gedung sekretariat) |
| Nomor telepon / WA sekretariat | Kosong (`''`) di `OfficialDataSeeder` | Nomor WA pribadi PDF (20 individu unik) dan nomor WhatsApp CP perorangan mantan kahim ditahan agar tidak melanggar larangan nomor WA pribadi / AC-13.3 di Git dan HTML publik |
| Akun media sosial resmi | `https://www.instagram.com/hmif_itats/` | Akun resmi Instagram HMIF ITATS |

---

## 3. Ringkasan Jumlah Resmi Kabinet Asakusa 2026/2027 (Target Hitungan Database)

| Kategori | Jumlah resmi | Rincian | Sumber rujukan |
|---|---|---|---|
| Periode aktif | **1** | `2026/2027` (`Kabinet Asakusa`, tanpa periode arsip) | `STRUKTUR, halaman 1`; AC-13.2 |
| Pelindung, Penasihat & Pembina (`board_members`, `is_core=false`, `division_id=null`) | **5** | 1 Pelindung, 3 Penasihat, 1 Dosen Penanggung Jawab | `STRUKTUR, halaman 1` |
| Badan Pengurus Harian (`board_members`, `is_core=true`, `division_id=null`) | **4** | Ketua Umum, Wakil Ketua Umum, Sekretaris Umum, Bendahara Umum | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Divisi fungsional resmi (`divisions`) | **4** | `psdm`, `litbang`, `media-humas`, `danus` | `STRUKTUR, halaman 1`; ketetapan Kahim `APPROVE R1D-A` |
| Pengurus Divisi PSDM | **8** | 1 Koordinator Divisi + 7 Anggota | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Pengurus Divisi Litbang | **7** | 1 Koordinator Divisi + 6 Anggota | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Pengurus Divisi Media HUMAS | **8** | 1 Koordinator Divisi + 7 Anggota | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1` |
| Pengurus Divisi Danus | **7** | 1 Koordinator Divisi + 6 Anggota | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1` |
| Total Pengurus Divisi (`division_id != null`) | **30** | `8 + 7 + 8 + 7` | `STRUKTUR, halaman 1-2` |
| Total Pengurus Mahasiswa Aktif (`BPH + Divisi`) | **34** | `4 + 30` (`18` eksisting + `16` Oprec 2026) | `STRUKTUR, hal. 1`; `BIODATA, hal. 1` |
| Total Baris `board_members` | **39** | `5` pembina/pimpinan + `4` BPH + `30` divisi | `STRUKTUR, halaman 1-2` |
| Program Kerja Strategis (`work_programs`) | **12** | `6` dipetakan ke PSDM, `2` Litbang, `3` Media HUMAS, `1` Danus | `PROKER, halaman 1`; keputusan Opsi A `APPROVE R1D-A` |

---

## 4. Jajaran Pelindung, Penasihat & Pembina Organisasi (5 Personil)

| No | Jabatan / Peran yang Disimpan | Nama Lengkap | Sumber |
|---|---|---|---|
| 1 | `Pelindung — Rektor ITATS` | `Dr. Mat Syai'in, S.T ., M.T ., Ph.D` | `STRUKTUR, halaman 1` |
| 2 | `Penasihat 1 — Plt. Wakil Rektor 1 Bidang Kemahasiswaan ITATS` | `Ahmad Yusuf Ismail, ST ., M.Sc., Ph.D` | `STRUKTUR, halaman 1` |
| 3 | `Penasihat 2 — Ka. Penalaran Bakat dan Minat ITATS` | `Fahmi Firdaus Alrizal, S.T ., M.T .` | `STRUKTUR, halaman 1` |
| 4 | `Penasihat 3 — Kepala Program Studi Teknik Informatika ITATS` | `Dr. Rahmi Rizkiana Putri, S.ST ., M.Kom.` | `STRUKTUR, halaman 1` |
| 5 | `Dosen Penanggung Jawab — Dosen Pembina HMIF ITATS` | `Muchamad Kurniawan, S.Kom., M.Kom` | `STRUKTUR, halaman 1` |

---

## 5. Badan Pengurus Harian — BPH Inti (4 Pengurus)

| No | Nama Lengkap | Jabatan | Status PDF | Sumber |
|---|---|---|---|---|
| 1 | `Ahmad Rizqi Mubarok` | `Ketua Umum` | BPH Inti (Eksisting) — Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 2 | `Gansa Alega Putra Utomo` | `Wakil Ketua Umum` | BPH Inti (Eksisting) — Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 3 | `Ridho Pangestu` | `Sekretaris Umum` | BPH Inti (Eksisting) — Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 4 | `Nur Layli Ramadhani Sufyan` | `Bendahara Umum` | BPH Inti (Eksisting) — Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

## 6. Divisi Fungsional & Daftar Anggota (4 Divisi, 30 Pengurus Divisi)

### 6.1 `DIV-01` — Pengembangan Sumber Daya Mahasiswa (PSDM) (`slug: psdm`, 8 Orang)

- **Deskripsi ringkas (`short_description`):** Pembinaan, kaderisasi, kepemimpinan, dan pengembangan kapasitas mahasiswa. *(Ketetapan Kahim `APPROVE R1D-A`)*
- **Deskripsi lengkap (`description`):** Divisi yang berfokus pada pengembangan kualitas sumber daya mahasiswa melalui pembinaan, kaderisasi, peningkatan kapasitas, serta penguatan karakter dan kepemimpinan. PSDM berperan dalam menciptakan lingkungan organisasi yang mendorong setiap anggota untuk berkembang secara personal maupun profesional. (Tagline: `DEVELOP PEOPLE, BUILD LEADERS.`) *(Ketetapan Kahim `APPROVE R1D-A`)*

| Urut | Nama Lengkap | Jabatan | Status PDF | Sumber |
|---|---|---|---|---|
| 10 | `Aryo Syarif Kamal Akbar` | `Koordinator Divisi` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 11 | `Moch Syahril Akbar` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 12 | `Surya Andi Pranata` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 13 | `Bagus Choirul Anam` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 14 | `Zidane Ishomuddin Dzaki` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 15 | `Arik Al Fikri` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 16 | `Naufal Muthi Haqqi` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 17 | `Vincent Lee Kurniawan` | `Anggota` | Anggota Baru (Oprec 2026) — Penambahan Revisi 1 | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

### 6.2 `DIV-02` — Penelitian dan Pengembangan (Litbang) (`slug: litbang`, 7 Orang)

- **Deskripsi ringkas (`short_description`):** Penelitian, eksplorasi teknologi, inovasi, dan pengembangan wawasan. *(Ketetapan Kahim `APPROVE R1D-A`)*
- **Deskripsi lengkap (`description`):** Divisi yang berfokus pada pengembangan wawasan, pengetahuan, dan kemampuan intelektual mahasiswa melalui penelitian, eksplorasi teknologi, serta pengembangan inovasi. Litbang menjadi wadah untuk mendorong budaya berpikir kritis, analitis, kreatif, dan solutif dalam menghadapi perkembangan teknologi informasi. (Tagline: `EXPLORE IDEAS, CREATE INNOVATION.`) *(Ketetapan Kahim `APPROVE R1D-A`)*

| Urut | Nama Lengkap | Jabatan | Status PDF | Sumber |
|---|---|---|---|---|
| 18 | `Wahyu Aditia Putra` | `Koordinator Divisi` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 19 | `Achmad Ali Fatahillah` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 20 | `Radith Ramzy Razzan Alasfyi` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 21 | `Rizki Okta Lesmana` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 22 | `Andika Dyan Syahputra` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 23 | `Dafa Putra Fitrianto` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 24 | `Trionaldy Junyan Pradewa` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

### 6.3 `DIV-03` — Media Digital dan Hubungan Masyarakat (Media HUMAS) (`slug: media-humas`, 8 Orang)

- **Deskripsi ringkas (`short_description`):** Publikasi, komunikasi, dokumentasi, dan citra organisasi. *(Ketetapan Kahim `APPROVE R1D-A`)*
- **Deskripsi lengkap (`description`):** Divisi yang bertanggung jawab dalam mengelola komunikasi, informasi, publikasi, dan citra organisasi. Media HUMAS menjadi penghubung antara HMIF ITATS dengan mahasiswa serta pihak eksternal melalui pengelolaan media digital, produksi konten kreatif, dokumentasi, dan penyebaran informasi organisasi. (Tagline: `CONNECT PEOPLE, SHARE INFORMATION.`) *(Ketetapan Kahim `APPROVE R1D-A`)*

| Urut | Nama Lengkap | Jabatan | Status PDF | Sumber |
|---|---|---|---|---|
| 25 | `M. Farhan Magribi` | `Koordinator Divisi` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 26 | `Abdiel Rozi Syahputra` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 27 | `Rivan Pramudya Erlangga` | `Anggota` | Pengurus Eksisting (2025) — Tetap di HUMAS | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 28 | `Aditya Maulana Zidqy` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 29 | `Rafi Satrya Rahmansyah` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 30 | `Drajat Febrio Ardi` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 31 | `Ady Setiawan` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 32 | `Ari Irawan` | `Anggota` | Anggota Baru (Oprec 2026) — Penambahan Revisi 2 | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |

---

### 6.4 `DIV-04` — Pengembangan Dana Usaha dan Minat Bakat (Danus) (`slug: danus`, 7 Orang)

- **Deskripsi ringkas (`short_description`):** Kewirausahaan, pengembangan dana, minat, dan bakat mahasiswa. *(Ketetapan Kahim `APPROVE R1D-A`)*
- **Deskripsi lengkap (`description`):** Divisi yang berfokus pada pengembangan potensi kewirausahaan, pengelolaan kegiatan usaha, serta penyaluran minat dan bakat mahasiswa. Danus berperan dalam mendukung kemandirian finansial organisasi sekaligus menyediakan ruang bagi mahasiswa untuk mengeksplorasi kreativitas, mengembangkan keterampilan, dan menyalurkan bakat di berbagai bidang. (Tagline: `BUILD OPPORTUNITIES, UNLEASH POTENTIAL.`) *(Ketetapan Kahim `APPROVE R1D-A`)*

| Urut | Nama Lengkap | Jabatan | Status PDF | Sumber |
|---|---|---|---|---|
| 33 | `Ardhi Fadli` | `Koordinator Divisi` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 34 | `Rafly Rizki Pratama` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 35 | `Muhammad Rifqi` | `Anggota` | Pengurus Eksisting (2025) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 36 | `Rizki Eka Maulana` | `Anggota` | Anggota Baru (Oprec 2026) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 37 | `Albertho Octaviano Rumagit Rachman` | `Anggota` | Anggota Baru (Oprec 2026) — Pemerataan Kuota | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 38 | `M. Sevencho Wijayanto Putra` | `Anggota` | Anggota Baru (Oprec 2026) — Pemerataan Kuota | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 39 | `Ahmad Shohibul Wafa` | `Anggota` | Anggota Baru (Oprec 2026) — Pool HUMAS | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |

---

## 7. Matriks 12 Program Kerja Strategis (Tanpa Nominal RAB)

Sesuai ketetapan Opsi A (skema `work_programs.division_id NOT NULL` tanpa migrasi baru), 7 proker lintas divisi/BPH dipetakan ke divisi pengampu utama dengan mempertahankan catatan penanggung jawab asli PDF di deskripsinya. PDF tidak mencantumkan tanggal hari maupun status pelaksanaan, sehingga `target_date = null` dan `status = 'planned'`.

| No | Nama Kegiatan | Slug | Divisi PDF | Divisi Pengampu (`division_slug`) | Periode & Lingkup (`PROKER, halaman 1`) |
|---|---|---|---|---|---|
| 1 | `Musyawarah Himpunan (MUSHIM) HMIF ITATS 2026` | `musyawarah-himpunan-mushim-hmif-itats-2026` | BPH Inti & PSDM | `psdm` | Oktober 2026 · Internal |
| 2 | `Open Recruitment & Member Onboarding HMIF ITATS 2026` | `open-recruitment-member-onboarding-hmif-itats-2026` | PSDM | `psdm` | Oktober - November 2026 · Internal |
| 3 | `Pengembangan Manajemen Organisasi (PMO) HMIF ITATS 2026` | `pengembangan-manajemen-organisasi-pmo-hmif-itats-2026` | PSDM | `psdm` | November - Desember 2026 · Internal |
| 4 | `HMIF Competency Mapping` | `hmif-competency-mapping` | PSDM & Litbang | `psdm` | November - Desember 2026 · Internal |
| 5 | `HMIF Community` | `hmif-community` | Litbang | `litbang` | Desember 2026 - Juli 2027 · Internal |
| 6 | `Pengadaan dan Penjualan Atribut HMIF & Teknik Informatika` | `pengadaan-dan-penjualan-atribut-hmif-teknik-informatika` | Danus & Minat Bakat | `danus` | November 2026 · Internal |
| 7 | `Penyambutan Wisudawan Ke-75` | `penyambutan-wisudawan-ke-75` | Seluruh Divisi | `media-humas` | November 2026 · Internal |
| 8 | `Bakti Sosial & Technology for Community` | `bakti-sosial-technology-for-community` | HUMAS & Litbang | `media-humas` | Februari 2027 · Internal & Eksternal |
| 9 | `Penyambutan Wisudawan Ke-76` | `penyambutan-wisudawan-ke-76` | Seluruh Divisi | `media-humas` | Mei 2027 · Internal |
| 10 | `Debat Calon Ketua HMIF & Pemilu Raya 2027/2028` | `debat-calon-ketua-hmif-pemilu-raya-2027-2028` | PSDM & BPH | `psdm` | September 2027 · Internal |
| 11 | `Musyawarah Himpunan Periode 2027/2028` | `musyawarah-himpunan-periode-2027-2028` | BPH Inti | `psdm` | Oktober 2027 · Internal |
| 12 | `HMIF Academy: Hard Skill & Soft Skill Development` | `hmif-academy-hard-skill-soft-skill-development` | Litbang | `litbang` | Januari - Juni 2027 · Internal |
