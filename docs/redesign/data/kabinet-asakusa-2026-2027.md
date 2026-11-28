# Data Resmi Kepengurusan Kabinet Asakusa HMIF ITATS Periode 2026/2027

**Status dokumen:** Draf ekstraksi R1D-a (menunggu *proofreading* dan persetujuan `APPROVE R1D-A` dari Kahim sebelum *seeding* ke database pada fase R1D-b).

**Sumber berkas resmi (`docs/redesign/source/`, tidak dilacak Git):**
1. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - STRUKTUR KABINET ASAKUSA.pdf` (2 halaman; selanjutnya disingkat `STRUKTUR`)
2. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - BIODATA _ KELENGKAPAN KTM.pdf` (1 halaman; selanjutnya disingkat `BIODATA`)
3. `STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - PROGRAM KERJA _ RAB.pdf` (1 halaman; selanjutnya disingkat `PROKER`)

> **Batasan privasi & kerahasiaan:** Sesuai ketentuan PRD US-13 / AC-13.3 dan keputusan D2, seluruh data pribadi berupa NPM (34 pengurus mahasiswa), NIP (5 pembina/pimpinan), nomor telepon/WhatsApp pribadi (20 individu unik di `STRUKTUR`, 18 di `BIODATA`), serta seluruh nominal dan persentase Rencana Anggaran Biaya (RAB) **dikecualikan sepenuhnya** dari berkas ini dan tidak akan dimasukkan ke Git maupun database portal publik.

---

## 1. Identitas Kabinet & Status Verifikasi Dokumen

| Atribut | Nilai terekstrak dari PDF | Sumber rujukan |
|---|---|---|
| Nama organisasi | Himpunan Mahasiswa Teknik Informatika (HMIF) ITATS | `STRUKTUR, halaman 1`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Nama kabinet | Kabinet Asakusa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Periode kepengurusan | 2026/2027 | `STRUKTUR, halaman 1`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Tagline / tema resmi kabinet | Tidak dinyatakan di PDF (ketiga berkas tidak mencantumkan tagline maupun tema kabinet) | Verifikasi silang `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1`; `PROKER, halaman 1` |
| Status Sertijab dalam PDF | `UNVERIFIED: Sertijab status` — Tidak ada halaman pada ketiga PDF yang menyatakan Serah Terima Jabatan (Sertijab) telah terlaksana; `STRUKTUR` hanya mencatat `Mandat Musyawarah Mahasiswa` pada BPH Inti dan status onboarding `Anggota Baru (Oprec 2026) - Menunggu Unggah` | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1`; `PROKER, halaman 1` |

---

## 2. Kontak Resmi (untuk Verifikasi Owner)

Bagian ini dipisahkan khusus untuk memverifikasi data kontak pada *footer* dan halaman `/kontak` (tindak lanjut F4). **Hasil pemeriksaan ketiga PDF resmi:**

| Kanal kontak resmi organisasi | Tercantum di PDF? | Keterangan / temuan sumber |
|---|---|---|
| Email resmi organisasi | Tidak tercantum | Ketiga PDF tidak memuat alamat email apa pun |
| Nomor telepon / WhatsApp resmi sekretariat | Tidak tercantum | PDF hanya memuat nomor telepon/WhatsApp pribadi milik 2 pembina/pimpinan dan 18 pengurus mahasiswa eksisting (`20` individu unik di `STRUKTUR, halaman 1-2`; `18` di `BIODATA, halaman 1`; `16` anggota baru bertanda `-`) — **seluruhnya dikecualikan dan tidak ditayangkan** |
| Alamat sekretariat resmi | Tidak tercantum | Ketiga PDF tidak memuat alamat sekretariat maupun kode pos |
| Akun media sosial resmi | Tidak tercantum | Ketiga PDF tidak memuat tautan Instagram, GitHub, LinkedIn, maupun YouTube |

---

## 3. Ringkasan Jumlah Resmi Kabinet Asakusa 2026/2027

| Kategori | Jumlah resmi PDF | Rincian | Sumber rujukan |
|---|---|---|---|
| Pembina & Pimpinan Organisasi | 5 | 1 Pelindung, 3 Penasihat, 1 Dosen Penanggung Jawab | `STRUKTUR, halaman 1` |
| Badan Pengurus Harian (BPH Inti) | 4 | 4 pengurus eksisting (Mandat Musyawarah Mahasiswa) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Divisi fungsional resmi | 4 | PSDM, Litbang, Media Digital & HUMAS, Pengembangan Dana Usaha & Minat Bakat | `STRUKTUR, halaman 1` (tabel I no. 2–5) |
| Pengurus Divisi PSDM | 8 | 1 Koordinator Divisi + 7 Anggota (2 eksisting, 6 baru Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Pengurus Divisi Litbang | 7 | 1 Koordinator Divisi + 6 Anggota (5 eksisting, 2 baru Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Pengurus Divisi Media Digital & HUMAS | 8 | 1 Koordinator Divisi + 7 Anggota (4 eksisting, 4 baru Oprec 2026) | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1` |
| Pengurus Divisi Pengembangan Dana Usaha & Minat Bakat | 7 | 1 Koordinator Divisi + 6 Anggota (3 eksisting, 4 baru Oprec 2026) | `STRUKTUR, halaman 1-2`; `BIODATA, halaman 1` |
| Total Pengurus Mahasiswa Aktif (BPH Inti + 4 Divisi) | 34 | 18 pengurus eksisting + 16 anggota baru (Oprec 2026) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| Total Seluruh Personil (Pembina/Pimpinan + Mahasiswa Aktif) | 39 | 5 pembina/pimpinan + 4 BPH Inti + 30 pengurus divisi | `STRUKTUR, halaman 1-2` |
| Program Kerja Strategis | 12 | Matriks proker periode 2026/2027 (tanpa nominal RAB) | `PROKER, halaman 1` |

---

## 4. Jajaran Pelindung, Penasihat & Pembina Organisasi (5 Personil)

Sesuai ketentuan R1D-a, hanya nama dan jabatan/keterangan peran institusi yang diambil (tanpa NIP maupun nomor telepon/WhatsApp). Penulisan nama dan tanda baca gelar disalin persis sebagaimana tertulis di PDF sumber:

| No | Kelompok / Kategori | Jabatan | Nama Lengkap | Keterangan Peran | Sumber |
|---|---|---|---|---|---|
| 1 | Pelindung | Pelindung | Dr. Mat Syai'in, S.T ., M.T ., Ph.D | Pimpinan Institusi — Rektor ITATS | `STRUKTUR, halaman 1` |
| 2 | Penasihat | Penasihat 1 | Ahmad Yusuf Ismail, ST ., M.Sc., Ph.D | Pimpinan Institusi — Plt. Wakil Rektor 1 Bidang Kemahasiswaan ITATS | `STRUKTUR, halaman 1` |
| 3 | Penasihat | Penasihat 2 | Fahmi Firdaus Alrizal, S.T ., M.T . | Pimpinan Institusi — Ka. Penalaran Bakat dan Minat ITATS | `STRUKTUR, halaman 1` |
| 4 | Penasihat | Penasihat 3 | Dr. Rahmi Rizkiana Putri, S.ST ., M.Kom. | Pimpinan Prodi — Kepala Program Studi Teknik Informatika ITATS | `STRUKTUR, halaman 1` |
| 5 | Dosen Penanggung Jawab | Dosen Penanggung Jawab | Muchamad Kurniawan, S.Kom., M.Kom | Dosen Pembina — Dosen Pembina HMIF ITATS | `STRUKTUR, halaman 1` |

---

## 5. Badan Pengurus Harian — BPH Inti (4 Pengurus)

| No | Nama Lengkap | Jabatan (`STRUKTUR` II & `BIODATA`) | Singkatan Tabel I (`STRUKTUR`) | Status Pengurus | Keterangan / Mandat | Sumber |
|---|---|---|---|---|---|---|
| 1 | Ahmad Rizqi Mubarok | Ketua Umum | Ketua Umum | BPH Inti (Eksisting) | Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 2 | Gansa Alega Putra Utomo | Wakil Ketua Umum | Waketum | BPH Inti (Eksisting) | Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 3 | Ridho Pangestu | Sekretaris Umum | Sekum | BPH Inti (Eksisting) | Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 4 | Nur Layli Ramadhani Sufyan | Bendahara Umum | Bendum | BPH Inti (Eksisting) | Mandat Musyawarah Mahasiswa | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

## 6. Divisi Fungsional & Daftar Anggota (4 Divisi, 30 Pengurus Divisi)

### 6.1 Divisi Pengembangan Sumber Daya Manusia (PSDM) — 8 Orang

- **Varian nama di PDF:** `Divisi Pengembangan Sumber Daya Manusia (PSDM)` (`STRUKTUR, halaman 1` bagian I); `Pengembangan Sumber Daya Manusia` (`STRUKTUR, halaman 1` bagian II; `BIODATA, halaman 1`); `PSDM` (`PROKER, halaman 1`).
- **Deskripsi divisi di PDF:** Tidak dinyatakan di PDF (catatan kuota tabel I: `1 Koordinator + 7 Anggota`, `Penambahan Anggota Baru Revisi 1 (Vincent Lee Kurniawan)`).
- **Koordinator Divisi:** Aryo Syarif Kamal Akbar (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`).

| No Urut `STRUKTUR` | Nama Lengkap | Jabatan (`STRUKTUR`) | Jabatan (`BIODATA`) | Status Pengurus | Catatan PDF | Sumber |
|---|---|---|---|---|---|---|
| 10 | Aryo Syarif Kamal Akbar | Koordinator Divisi | Koordinator Divisi | Pengurus Eksisting (2025) | Koordinator / PJ Divisi PSDM | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 11 | Moch Syahril Akbar | Anggota 1 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting PSDM | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 12 | Surya Andi Pranata | Anggota 2 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #12 (Minat PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 13 | Bagus Choirul Anam | Anggota 3 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #4 (Minat PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 14 | Zidane Ishomuddin Dzaki | Anggota 4 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #9 (Minat PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 15 | Arik Al Fikri | Anggota 5 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #2 (Minat PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 16 | Naufal Muthi Haqqi | Anggota 6 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #7 (Minat PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 17 | Vincent Lee Kurniawan | Anggota 7 | Anggota | Anggota Baru (Oprec 2026) | Penambahan Anggota Baru Revisi 1 (PSDM) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

### 6.2 Divisi Penelitian dan Pengembangan (Litbang) — 7 Orang

- **Varian nama di PDF:** `Divisi Penelitian dan Pengembangan (Litbang)` (`STRUKTUR, halaman 1` bagian I); `Penelitian dan Pengembangan` (`STRUKTUR, halaman 1` bagian II; `BIODATA, halaman 1`); `Litbang` (`PROKER, halaman 1`).
- **Deskripsi divisi di PDF:** Tidak dinyatakan di PDF (catatan kuota tabel I: `1 Koordinator + 6 Anggota`, `Formasi Ideal Litbang (5 Eksisting + 2 Baru)`).
- **Koordinator Divisi:** Wahyu Aditia Putra (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`).

| No Urut `STRUKTUR` | Nama Lengkap | Jabatan (`STRUKTUR`) | Jabatan (`BIODATA`) | Status Pengurus | Catatan PDF | Sumber |
|---|---|---|---|---|---|---|
| 18 | Wahyu Aditia Putra | Koordinator Divisi | Koordinator Divisi | Pengurus Eksisting (2025) | Koordinator / PJ Divisi Litbang | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 19 | Achmad Ali Fatahillah | Anggota 1 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting Litbang | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 20 | Radith Ramzy Razzan Alasfyi | Anggota 2 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting (Terdaftar Oprec #15) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 21 | Rizki Okta Lesmana | Anggota 3 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting (Terdaftar Oprec #13) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 22 | Andika Dyan Syahputra | Anggota 4 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting (Terdaftar Oprec #14) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 23 | Dafa Putra Fitrianto | Anggota 5 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #18 (Minat Litbang) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 24 | Trionaldy Junyan Pradewa | Anggota 6 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #8 (Minat Litbang) | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |

---

### 6.3 Divisi Media Digital dan Hubungan Masyarakat (HUMAS) — 8 Orang

- **Varian nama di PDF:** `Divisi Media Digital dan Hubungan Masyarakat (HUMAS)` (`STRUKTUR, halaman 1` bagian I); `Media Digital dan HUMAS` (`STRUKTUR, halaman 1-2` bagian II; `BIODATA, halaman 1`); `HUMAS` (`PROKER, halaman 1`).
- **Deskripsi divisi di PDF:** Tidak dinyatakan di PDF (catatan kuota tabel I: `1 Koordinator + 7 Anggota`, `Penambahan Revisi 2 (Ari Irawan) & Rivan Tetap di HUMAS`).
- **Koordinator Divisi:** M. Farhan Magribi (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`).

| No Urut `STRUKTUR` | Nama Lengkap | Jabatan (`STRUKTUR`) | Jabatan (`BIODATA`) | Status Pengurus | Catatan PDF | Sumber |
|---|---|---|---|---|---|---|
| 25 | M. Farhan Magribi | Koordinator Divisi | Koordinator Divisi | Pengurus Eksisting (2025) | Koordinator / PJ Divisi Media Digital & HUMAS | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 26 | Abdiel Rozi Syahputra | Anggota 1 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting HUMAS | `STRUKTUR, halaman 1`; `BIODATA, halaman 1` |
| 27 | Rivan Pramudya Erlangga | Anggota 2 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting HUMAS (Terdaftar Oprec #10; `BIODATA`: Tetap di HUMAS) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 28 | Aditya Maulana Zidqy | Anggota 3 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting HUMAS | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 29 | Rafi Satrya Rahmansyah | Anggota 4 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #5 (Minat HUMAS) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 30 | Drajat Febrio Ardi | Anggota 5 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #6 (Minat HUMAS) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 31 | Ady Setiawan | Anggota 6 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #11 (Minat HUMAS) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 32 | Ari Irawan | Anggota 7 | Anggota | Anggota Baru (Oprec 2026) | Penambahan Anggota Baru Revisi 2 (Minat Media Digital & HUMAS) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |

---

### 6.4 Divisi Pengembangan Dana Usaha dan Minat Bakat — 7 Orang

- **Varian nama di PDF:** `Divisi Pengembangan Dana Usaha dan Minat Bakat` (`STRUKTUR, halaman 1` bagian I & judul seksi F); `Pengembangan Dana Usaha & Minat Bakat` (`STRUKTUR, halaman 2` tabel II; `BIODATA, halaman 1`); `Danus & Minat Bakat` (`PROKER, halaman 1`).
- **Deskripsi divisi di PDF:** Tidak dinyatakan di PDF (catatan kuota tabel I: `1 Koordinator + 6 Anggota`, `Formasi Ideal Danus & Minat Bakat (Pemerataan Opsi 2)`).
- **Koordinator Divisi:** Ardhi Fadli (`STRUKTUR, halaman 2`; `BIODATA, halaman 1`).

| No Urut `STRUKTUR` | Nama Lengkap | Jabatan (`STRUKTUR`) | Jabatan (`BIODATA`) | Status Pengurus | Catatan PDF | Sumber |
|---|---|---|---|---|---|---|
| 33 | Ardhi Fadli | Koordinator Divisi | Koordinator Divisi | Pengurus Eksisting (2025) | Koordinator / PJ Divisi Danus & Minat Bakat | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 34 | Rafly Rizki Pratama | Anggota 1 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting Danus & Minat Bakat | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 35 | Muhammad Rifqi | Anggota 2 | Anggota | Pengurus Eksisting (2025) | Anggota Eksisting Danus & Minat Bakat | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 36 | Rizki Eka Maulana | Anggota 3 | Anggota | Anggota Baru (Oprec 2026) | Lolos Oprec #16 (Minat Danus & Minat Bakat) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 37 | Albertho Octaviano Rumagit Rachman | Anggota 4 | Anggota | Anggota Baru (Oprec 2026) | Pemerataan Kuota (Opsi 2 Catatan Panitia: Danus) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 38 | M. Sevencho Wijayanto Putra | Anggota 5 | Anggota | Anggota Baru (Oprec 2026) | Pemerataan Kuota (Opsi 2 Catatan Panitia: Danus) | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |
| 39 | Ahmad Shohibul Wafa | Anggota 6 | Anggota | Anggota Baru (Oprec 2026) | Pemerataan Acak Terukur Pool HUMAS | `STRUKTUR, halaman 2`; `BIODATA, halaman 1` |

---

## 7. Matriks Program Kerja Strategis Kabinet Asakusa 2026/2027 (12 Program)

Seluruh nominal dan persentase RAB pada kolom Rencana Anggaran Biaya **dikecualikan sepenuhnya**. PDF hanya menyatakan **Bulan Pelaksanaan** (tidak menyebut tanggal hari spesifik) dan **tidak mencantumkan status** pelaksanaan masing-masing program.

| No | Nama Kegiatan | Tingkat Kegiatan | Divisi Penanggung Jawab (Sesuai PDF) | Deskripsi Kegiatan | Bulan Pelaksanaan (Sesuai PDF) | Status di PDF | Sumber |
|---|---|---|---|---|---|---|---|
| 1 | Musyawarah Himpunan (MUSHIM) HMIF ITATS 2026 | Internal | BPH Inti & PSDM | Pelaksanaan Musyawarah Himpunan sebagai forum evaluasi, pembahasan AD/ART & GBHO, serta pertanggungjawaban kepengurusan. | Oktober 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 2 | Open Recruitment & Member Onboarding HMIF ITATS 2026 | Internal | PSDM | Pelaksanaan penerimaan anggota baru HMIF ITATS yang dilanjutkan dengan proses onboarding dan pengenalan struktur organisasi. | Oktober - November 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 3 | Pengembangan Manajemen Organisasi (PMO) HMIF ITATS 2026 | Internal | PSDM | Kegiatan pengembangan kemampuan dasar organisasi bagi pengurus dan anggota baru HMIF ITATS meliputi tata kelola dan manajemen proyek. | November - Desember 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 4 | HMIF Competency Mapping | Internal | PSDM & Litbang | Kegiatan pemetaan minat, bakat, kemampuan dasar, serta kebutuhan pengembangan hard skill dan soft skill seluruh anggota. | November - Desember 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 5 | HMIF Community | Internal | Litbang | Pembentukan komunitas belajar (study group) berbasis minat dan kompetensi mahasiswa Teknik Informatika ITATS. | Desember 2026 - Juli 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
| 6 | Pengadaan dan Penjualan Atribut HMIF & Teknik Informatika | Internal | Danus & Minat Bakat | Pengadaan dan penjualan atribut resmi seperti baju PDH serta merchandise HMIF dan Program Studi Teknik Informatika. | November 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 7 | Penyambutan Wisudawan Ke-75 | Internal | Seluruh Divisi | Kegiatan penyambutan dan arak-arakan wisudawan ke-75 Program Studi Teknik Informatika oleh HMIF ITATS. | November 2026 | Tidak dinyatakan | `PROKER, halaman 1` |
| 8 | Bakti Sosial & Technology for Community | Internal & Eksternal | HUMAS & Litbang | Kegiatan sosial, edukasi teknologi, dan pengabdian kepada masyarakat yang melibatkan mahasiswa Teknik Informatika. | Februari 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
| 9 | Penyambutan Wisudawan Ke-76 | Internal | Seluruh Divisi | Kegiatan penyambutan wisudawan ke-76 Program Studi Teknik Informatika oleh HMIF ITATS. | Mei 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
| 10 | Debat Calon Ketua HMIF & Pemilu Raya 2027/2028 | Internal | PSDM & BPH | Pelaksanaan regenerasi Ketua Himpunan HMIF melalui sosialisasi, pendaftaran, seleksi, debat publik, dan pemungutan suara. | September 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
| 11 | Musyawarah Himpunan Periode 2027/2028 | Internal | BPH Inti | Pelaksanaan sidang pleno revisi AD/ART, GBHO, dan Laporan Pertanggungjawaban (LPJ) akhir periode HMIF ITATS. | Oktober 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
| 12 | HMIF Academy: Hard Skill & Soft Skill Development | Internal | Litbang | Program pengembangan kompetensi mahasiswa melalui rangkaian workshop, sharing session, mentoring, dan praktik proyek. | Januari - Juni 2027 | Tidak dinyatakan | `PROKER, halaman 1` |
