```text
PHASE REPORT R1D-a
```

## Rule C — Verifikasi Keutuhan Berkas Spesifikasi (Read-Only)

Perintah dan keluaran mentah (`Get-FileHash`):

```powershell
> Get-FileHash docs/redesign/PRD.md, docs/redesign/DESIGN.md, docs/redesign/ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md -Algorithm SHA256 | Format-List

Algorithm : SHA256
Hash      : B3C62559105F450AA709DB24AE34CCDB4A0013F08C51B360972AE7BA8796163D
Path      : D:\MY CODE\website-hmif-itats\hmif-itats\docs\redesign\PRD.md

Algorithm : SHA256
Hash      : 1C0D693A8838621FB88CA9C4CFCA4637DB1550EE3F754CAF92554FE726F6DF59
Path      : D:\MY CODE\website-hmif-itats\hmif-itats\docs\redesign\DESIGN.md

Algorithm : SHA256
Hash      : E8E6AD47FB0BACF8EADA28748F2E5BC310041C00EF1F4F45A39968670206C94B
Path      : D:\MY CODE\website-hmif-itats\hmif-itats\docs\redesign\ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md
```

Ketiga berkas spesifikasi **100% cocok** dengan hash SHA-256 v1.2 resmi milik owner tanpa modifikasi ataupun perbedaan CRLF/LF.

---

## CLAIM

Seluruh 3 berkas PDF resmi Kabinet Asakusa 2026/2027 di `docs/redesign/source/` telah diekstrak secara lokal memakai `pypdf` tanpa menambah dependensi proyek, lalu disusun menjadi berkas terstruktur `docs/redesign/data/kabinet-asakusa-2026-2027.md` yang mencantumkan sitasi `nama berkas, halaman` pada setiap baris, mengecualikan 100% NPM, NIP, nomor telepon/WhatsApp pribadi, email, dan nominal RAB, memisahkan bagian **"Kontak resmi (untuk verifikasi owner)"**, melaporkan selisih jumlah divisi resmi (**4 divisi** vs **6 divisi** di `DemoContentSeeder.php`), melaporkan ketidakadaan tagline/tema resmi serta status Sertijab yang **`UNVERIFIED`** di dokumen PDF, mencatat 11 ketidakkonsistenan tanpa menyelesaikannya diam-diam, dan membuktikan **0** kecocokan untuk seluruh 5 pola data terlarang pada berkas data hasil ekstraksi. Pengerjaan **berhenti** di gerbang **R1D-a** menunggu **`APPROVE R1D-A`** sebelum membuat `OfficialDataSeeder` atau menyentuh database/UI.

---

## EVIDENCE

### 1. Berkas Data Resmi yang Dihasilkan

- Path berkas data: [kabinet-asakusa-2026-2027.md](file:///d:/MY%20CODE/website-hmif-itats/hmif-itats/docs/redesign/data/kabinet-asakusa-2026-2027.md)

### 2. Tabel Hitungan Resmi (PDF vs `DemoContentSeeder.php` Saat Ini)

| Kategori | Hitungan PDF Resmi | Rincian & Sumber PDF | Hitungan di `DemoContentSeeder.php` | Selisih / Status |
|---|---|---|---|---|
| Pelindung, Penasihat & Pembina Organisasi | **5** | 1 Pelindung, 3 Penasihat, 1 Dosen Penanggung Jawab (`STRUKTUR KABINET ASAKUSA.pdf, halaman 1`) | **0** | `+5` di PDF; seeder tidak memuat pembina/pimpinan |
| Badan Pengurus Harian (BPH Inti) | **4** | Ketua Umum, Wakil Ketua Umum, Sekretaris Umum, Bendahara Umum (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`) | **4** | Sama jumlah (`4`), isi seeder berupa teks placeholder generic |
| **Divisi fungsional resmi (2026/2027)** | **4** | PSDM, Litbang, Media Digital & HUMAS, Pengembangan Dana Usaha & Minat Bakat (`STRUKTUR, halaman 1` bagian I no. 2–5) | **6** | **Selisih 2 divisi** (`DemoContentSeeder` memiliki 6 divisi placeholder vs 4 divisi fungsional pada PDF resmi; bila BPH Inti dihitung sbg unit tabel I PDF totalnya 5 baris, tetap bukan 6) |
| Pengurus Divisi PSDM | **8** | 1 Koordinator + 7 Anggota (`2` eksisting, `6` baru Oprec 2026) (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`) | **1** placeholder | `+7` anggota divisi |
| Pengurus Divisi Litbang | **7** | 1 Koordinator + 6 Anggota (`5` eksisting, `2` baru Oprec 2026) (`STRUKTUR, halaman 1`; `BIODATA, halaman 1`) | — | Nama/struktur divisi berbeda di seeder |
| Pengurus Divisi Media Digital & HUMAS | **8** | 1 Koordinator + 7 Anggota (`4` eksisting, `4` baru Oprec 2026) (`STRUKTUR, halaman 1-2`; `BIODATA, halaman 1`) | — | Di seeder dipecah menjadi *Kominfo* dan *Humas & Kemitraan* |
| Pengurus Divisi Pengembangan Dana Usaha & Minat Bakat | **7** | 1 Koordinator + 6 Anggota (`3` eksisting, `4` baru Oprec 2026) (`STRUKTUR, halaman 1-2`; `BIODATA, halaman 1`) | — | Di seeder bernama *Sosmas & Minat Bakat* |
| **Total Pengurus Divisi** | **30** | `8 + 7 + 8 + 7 = 30` (`STRUKTUR, halaman 1` bagian I) | **6** placeholder | `+24` pengurus divisi |
| **Total Pengurus Mahasiswa Aktif** | **34** | `4` BPH Inti + `30` pengurus divisi (`18` eksisting + `16` Oprec 2026) (`STRUKTUR, hal. 1`; `BIODATA, hal. 1`) | **10** placeholder | `+24` pengurus aktif |
| **Total Seluruh Personil Organisasi** | **39** | `5` pembina/pimpinan + `34` mahasiswa aktif (`STRUKTUR, hal. 1-2`) | **10** placeholder | `+29` total personil |
| **Program Kerja Strategis** | **12** | Matriks No. 1–12 (`PROGRAM KERJA _ RAB.pdf, halaman 1`; RAB dikecualikan) | **6** rekaan | `+6` proker; seeder memakai proker fiktif |
| Kontak resmi organisasi di PDF | **0** | Email organisasi (`0`), telepon sekretariat (`0`), alamat (`0`), medsos (`0`) | Instagram terisi; email/phone/address dikosongkan di F4 | `0` kanal tercantum di PDF |
| Nomor telepon/WA pribadi yg disaring | **20** (unik) | `2` pimpinan/pembina (`STRUKTUR, hal. 1`) + `18` pengurus eksisting (`STRUKTUR, hal. 1-2`; `BIODATA, hal. 1`), `16` Oprec 2026 bertanda `-` | **0** | 100% dikecualikan |

---

### 3. Pemeriksaan Tagline/Tema Resmi & Status Sertijab

- **Tagline / Tema Kabinet (`hero headline` tidak diubah):** **Tidak dinyatakan di ketiga PDF.** Tagline `"Connect. Innovate. Empower."` yang saat ini berada di `DemoContentSeeder.php:73` tidak bersumber dari PDF mana pun.
- **Status Sertijab (`UNVERIFIED: Sertijab status`):**
  `UNVERIFIED: Sertijab status` — Setelah membaca seluruh halaman ketiga berkas PDF (`STRUKTUR KABINET ASAKUSA.pdf, halaman 1-2`; `BIODATA _ KELENGKAPAN KTM.pdf, halaman 1`; `PROGRAM KERJA _ RAB.pdf, halaman 1`), **tidak ada satu pun halaman yang menyatakan Serah Terima Jabatan (Sertijab) telah dilaksanakan.** Bukti tertulis yang tertera di PDF adalah:
  1. `STRUKTUR, halaman 1`: kolom keterangan keempat BPH Inti hanya mencantumkan `"Mandat Musyawarah Mahasiswa"`.
  2. `STRUKTUR, halaman 1-2` dan `BIODATA, halaman 1`: `16` dari `34` mahasiswa berstatus `"Anggota Baru (Oprec 2026) - Menunggu Unggah"` (termasuk catatan `"Penambahan Anggota Baru Revisi 1"` dan `"Revisi 2"`, serta `"Menunggu Pengumpulan Berkas Onboarding"`).
  Owner telah menyampaikan secara lisan di percakapan bahwa MUSHIM & Sertijab telah selesai, namun konfirmasi akhir keabsahan tetap di tangan owner sebelum *deploy* sesuai D2/P1.

---

### 4. Kontak Resmi (untuk Verifikasi Owner — Tindak Lanjut F4)

Sebagaimana didokumentasikan pada Bagian 2 berkas `docs/redesign/data/kabinet-asakusa-2026-2027.md`:
- Ketiga PDF **tidak mencantumkan** email organisasi, nomor telepon/WhatsApp sekretariat resmi, alamat sekretariat, ataupun akun media sosial resmi.
- Seluruh **20 nomor telepon/WhatsApp pribadi** (`2` pembina/pimpinan + `18` pengurus mahasiswa eksisting; `16` anggota baru bertanda `-`) **dikecualikan** dan tidak boleh ditampilkan.

---

### 5. Daftar Ketidakkonsistenan & Ambiguitas (Tidak Diselesaikan Diam-Diam)

1. **Jumlah dan struktur divisi (`4` di PDF vs `6` di `DemoContentSeeder.php`):** PDF menetapkan 4 divisi fungsional (`PSDM`, `Litbang`, `Media Digital dan HUMAS`, `Pengembangan Dana Usaha dan Minat Bakat`), sedangkan `DemoContentSeeder.php` mendefinisikan 6 divisi placeholder (*PSDM*, *Riset, Keilmuan & Teknologi*, *Kominfo*, *Humas & Kemitraan*, *Sosmas & Minat Bakat*, *Pengembangan & Sistem Digital*).
2. **Variasi penulisan nama divisi antar-PDF & antar-tabel:**
   - PSDM: `"Divisi Pengembangan Sumber Daya Manusia (PSDM)"` (`STRUKTUR` I) vs `"Pengembangan Sumber Daya Manusia"` (`STRUKTUR` II & `BIODATA`) vs `"PSDM"` (`PROKER`).
   - Litbang: `"Divisi Penelitian dan Pengembangan (Litbang)"` (`STRUKTUR` I) vs `"Penelitian dan Pengembangan"` (`STRUKTUR` II & `BIODATA`) vs `"Litbang"` (`PROKER`).
   - HUMAS: `"Divisi Media Digital dan Hubungan Masyarakat (HUMAS)"` (`STRUKTUR` I) vs `"Media Digital dan HUMAS"` (`STRUKTUR` II & `BIODATA`) vs `"HUMAS"` (`PROKER`).
   - Danus & Minat Bakat: `"Divisi Pengembangan Dana Usaha dan Minat Bakat"` (`STRUKTUR` I & judul F) vs `"Pengembangan Dana Usaha & Minat Bakat"` (`STRUKTUR` II & `BIODATA`) vs `"Danus & Minat Bakat"` (`PROKER`).
3. **7 dari 12 Program Kerja menyebut penanggung jawab gabungan/lintas divisi atau BPH (`PROKER, halaman 1`):**
   - No. 1 (`Musyawarah Himpunan`): `"BPH Inti & PSDM"`
   - No. 4 (`HMIF Competency Mapping`): `"PSDM & Litbang"`
   - No. 7 (`Penyambutan Wisudawan Ke-75`): `"Seluruh Divisi"`
   - No. 8 (`Bakti Sosial & Technology for Community`): `"HUMAS & Litbang"`
   - No. 9 (`Penyambutan Wisudawan Ke-76`): `"Seluruh Divisi"`
   - No. 10 (`Debat Calon Ketua HMIF & Pemilu Raya 2027/2028`): `"PSDM & BPH"`
   - No. 11 (`Musyawarah Himpunan Periode 2027/2028`): `"BPH Inti"`
   Sementara tabel `work_programs` di skema database hanya memiliki satu kolom relasi `division_id` (nullable). Pemetaan `division_id` untuk ke-7 proker tersebut membutuhkan persetujuan owner pada `APPROVE R1D-A` sebelum R1D-b.
4. **Variasi nama jabatan BPH Inti:** `STRUKTUR` tabel II & `BIODATA` menulis `"Ketua Umum"`, `"Wakil Ketua Umum"`, `"Sekretaris Umum"`, `"Bendahara Umum"`; `STRUKTUR` tabel I menyingkat `"Waketum"`, `"Sekum"`, `"Bendum"`; sedangkan konvensi situs lama & `PROKER` #10 menyebut `"Ketua HMIF"` / `"Ketua Himpunan"`.
5. **Variasi jabatan anggota divisi:** `STRUKTUR` memberi nomor urut per divisi (`"Anggota 1"`..`"Anggota 7"`), sedangkan `BIODATA` menulis seluruh anggota non-koordinator seragam sebagai `"Anggota"`.
6. **Cakupan personil berbeda antara 2 PDF:** `STRUKTUR` memuat **39 personil** (`5` Pembina/Pimpinan + `34` mahasiswa aktif), sedangkan `BIODATA` hanya memuat **34 mahasiswa aktif** tanpa 5 Pembina/Pimpinan.
7. **Keterangan anggota eksisting tercampur catatan Oprec/pemerataan kuota di `STRUKTUR`:** 3 anggota eksisting Litbang (`Radith Ramzy Razzan Alasfyi`, `Rizki Okta Lesmana`, `Andika Dyan Syahputra`) dan 1 anggota eksisting HUMAS (`Rivan Pramudya Erlangga`) berstatus `"Pengurus Eksisting (2025)"` tetapi tercatat `"Terdaftar Oprec #..."` (`Rivan` juga berlabel `"Tetap di HUMAS"` pada `BIODATA`). Di Danus & Minat Bakat, 3 anggota baru tercatat `"Pemerataan Kuota"` / `"Pemerataan Acak Terukur Pool HUMAS"`.
8. **Variasi spasi & tanda baca gelar pada Pembina/Pimpinan (`STRUKTUR, hal. 1`):** tertulis spasi sebelum titik dan inkonsistensi titik akhir (`"Dr. Mat Syai'in, S.T ., M.T ., Ph.D"`, `"Ahmad Yusuf Ismail, ST ., M.Sc., Ph.D"`, `"Fahmi Firdaus Alrizal, S.T ., M.T ."`, `"Dr. Rahmi Rizkiana Putri, S.ST ., M.Kom."`, `"Muchamad Kurniawan, S.Kom., M.Kom"`). Disalin persis dari PDF untuk diverifikasi owner saat proofreading.
9. **Deskripsi tertulis per divisi tidak tersedia di PDF:** R1D-a meminta deskripsi divisi jika dinyatakan, namun ketiga PDF hanya mencantumkan nama divisi, komposisi kuota, dan anggota tanpa paragraf deskripsi (dicatat eksplisit `"Tidak dinyatakan di PDF"` agar tidak mengarang teks).
10. **Rentang tanggal & status program kerja di `PROKER, hal. 1`:** hanya menyebut nama bulan (`Oktober 2026` hingga `Oktober 2027`) tanpa tanggal spesifik dan tanpa kolom status pelaksanaan; proker #11 berjudul `"Musyawarah Himpunan Periode 2027/2028"` bertarget `"Oktober 2027"`, melewati akhir kalender Agustus yang ada di seeder contoh.
11. **`DemoContentSeeder.php` saat ini tidak selaras dengan aturan R1D-b:** masih memuat periode arsip `"2025/2026"` (*Kabinet Akselerasi*), 6 divisi placeholder, BPH/koordinator fiktif, proker rekaan, serta judul kegiatan/pengumuman tanpa awalan `[CONTOH]`. Baru akan dirombak di fase R1D-b setelah `APPROVE R1D-A`.

---

### 6. Verifikasi 5 Pola Terlarang (`Select-String` atas Berkas Data & Seeder)

Perintah & output mentah (ditambahkan pula pola nomor telepon bergaris hubung `08xx-...`):

```powershell
> $targets = @('docs\redesign\data\kabinet-asakusa-2026-2027.md') + (Get-ChildItem database\seeders\*.php | ForEach-Object { $_.FullName })
> foreach ($pat in @('06\.20\d\d\.1\.\d{5}', '\b\d{18}\b', '(\+62|\b08)\d{8,12}', '(\+62|\b08)[0-9-]{8,14}', 'Rp\s?\d', '@[A-Za-z0-9.-]+\.[a-z]{2,}')) {
    Write-Output "=== PATTERN: $pat ==="
    Select-String -Path $targets -Pattern $pat | ForEach-Object { "$($_.Path.Replace((Get-Location).Path + '\','')):$($_.LineNumber): $($_.Line.Trim())" }
}

=== PATTERN: 06\.20\d\d\.1\.\d{5} ===
=== PATTERN: \b\d{18}\b ===
=== PATTERN: (\+62|\b08)\d{8,12} ===
=== PATTERN: (\+62|\b08)[0-9-]{8,14} ===
=== PATTERN: Rp\s?\d ===
=== PATTERN: @[A-Za-z0-9.-]+\.[a-z]{2,} ===
database\seeders\DatabaseSeeder.php:39: $adminEmail = $adminEmail !== '' ? $adminEmail : 'admin@hmif-itats.local';
```

Hasil:
- **`docs/redesign/data/kabinet-asakusa-2026-2027.md`:** **0** kecocokan pada seluruh pola terlarang (NPM, NIP 18 digit, telepon/WA, nominal `Rp`, dan email).
- **`database/seeders/*.php`:** **0** kecocokan untuk NPM, NIP, telepon/WA, dan nominal `Rp`; terdapat **1** kecocokan pola `@...` pada `DatabaseSeeder.php:39` berupa fallback akun admin lokal non-production `'admin@hmif-itats.local'` (bukan email pribadi pengurus maupun akun produksi).

---

## LADDER CHECK

- **Berkas ditambahkan di R1D-a:** `docs/redesign/data/kabinet-asakusa-2026-2027.md` dan `docs/redesign/reports/R1D-a-report.md`.
- **Perubahan kode / UI / database / dependensi:** 0 (ekstraksi PDF dilakukan via `python -c` dengan modul lokal `pypdf`, tanpa mengubah `package.json`, `composer.json`, seeder, migrasi, atau view).

---

## ACCEPTANCE

| ID | Verified by | Status |
|---|---|---|
| AC-13.1 | Ekstraksi & tabel hitungan selesai di `kabinet-asakusa-2026-2027.md`; `OfficialDataSeeder` + uji DB baru dikerjakan di R1D-b setelah `APPROVE R1D-A` | **UNVERIFIED** (tahap R1D-a baru sampai berkas data; seeder menunggu R1D-b) |
| AC-13.2 | Data periode 2026/2027 tercatat di markdown; penghapusan arsip tanpa snapshot live menunggu R1D-b | **UNVERIFIED** (menunggu R1D-b setelah `APPROVE R1D-A`) |
| AC-13.3 | `Select-String` 5 pola terlarang = **0** pada `kabinet-asakusa-2026-2027.md`; `git log`/`git rev-list` bersih dari PDF; HTML semua rute pasca-seeding menunggu R1D-b | **PARTIAL** (berkas data & riwayat Git terverifikasi bersih; HTML publik pasca-R1D-b menunggu R1D-b) |
| AC-13.4 | `git ls-files docs/redesign/source` = kosong & `.gitignore` memuat `docs/redesign/source/` serta `docs/redesign/reference/` | **VERIFIED** |
| AC-13.5 | Seluruh baris `kabinet-asakusa-2026-2027.md` disalin dari 3 PDF dengan sitasi per baris, tanpa data karangan; seeding ke DB menunggu R1D-b | **PARTIAL** (berkas data terverifikasi; verifikasi DB menunggu R1D-b) |
| AC-13.6 | Pembaruan `DemoContentSeeder` ke judul `[CONTOH]` & pemisahan `OfficialDataSeeder` dijadwalkan di R1D-b setelah `APPROVE R1D-A` | **UNVERIFIED** (menunggu R1D-b) |

---

## NOT VERIFIED

- `UNVERIFIED: Sertijab status` dalam berkas PDF (tidak dinyatakan selesai pada halaman mana pun di ketiga PDF; menunggu konfirmasi akhir Kahim).
- `UNVERIFIED: Seeding database & uji kesesuaian DB vs berkas data` (sengaja ditahan pada gerbang R1D-a sampai Kahim melakukan proofreading dan membalas `APPROVE R1D-A`).

---

## RISKS / QUESTIONS

Mohon konfirmasi owner sebelum membalas **`APPROVE R1D-A`** agar implementasi **R1D-b** akurat:

1. **Proofreading Nama, Ejaan, & Gelar (39 Personil):** Mohon periksa seluruh daftar nama, gelar akademik (`S.T .` vs `S.T.`, `S.ST .`, `Ph.D`), jabatan (`Ketua Umum` vs `Ketua HMIF`), dan daftar 12 program kerja pada `docs/redesign/data/kabinet-asakusa-2026-2027.md`.
2. **Pemetaan `division_id` untuk 7 Program Lintas Divisi / BPH (`PROKER, halaman 1`):** Skema tabel `work_programs` menghubungkan setiap proker ke satu `division_id` (atau `null` bila lintas/tingkat BPH). Untuk 7 program berikut pada saat seeding R1D-b, apakah dipetakan ke `null` (umum/lintas) dengan keterangan divisi kolaborator, atau diarahkan ke salah satu divisi penanggung jawab utama?
   - `Musyawarah Himpunan (MUSHIM) HMIF ITATS 2026` (`BPH Inti & PSDM`)
   - `HMIF Competency Mapping` (`PSDM & Litbang`)
   - `Penyambutan Wisudawan Ke-75` (`Seluruh Divisi`)
   - `Bakti Sosial & Technology for Community` (`HUMAS & Litbang`)
   - `Penyambutan Wisudawan Ke-76` (`Seluruh Divisi`)
   - `Debat Calon Ketua HMIF & Pemilu Raya 2027/2028` (`PSDM & BPH`)
   - `Musyawarah Himpunan Periode 2027/2028` (`BPH Inti`)
3. **Deskripsi Singkat 4 Divisi Resmi & Tagline Kabinet Asakusa:** Karena ketiga PDF tidak memuat deskripsi tertulis per divisi maupun tagline resmi kabinet, apakah kolom deskripsi divisi dibiarkan kosong terlebih dahulu sampai owner mengisinya, atau owner ingin menyertakan draf kalimat singkat per divisi saat membalas `APPROVE R1D-A`?
4. **Kontak Resmi Organisasi (F4):** Mohon kirimkan (atau konfirmasi apakah ingin dikosongkan) **email resmi organisasi**, **nomor telepon/WA resmi sekretariat (bukan nomor pribadi)**, dan **alamat resmi sekretariat** untuk ditampilkan di footer dan `/kontak`.

Silakan periksa kedua laporan (**R1.1** dan **R1D-a**) beserta berkas [kabinet-asakusa-2026-2027.md](file:///d:/MY%20CODE/website-hmif-itats/hmif-itats/docs/redesign/data/kabinet-asakusa-2026-2027.md). Pekerjaan **dihentikan** di titik ini menunggu balasan **`APPROVE R1D-A`** (dan konfirmasi poin 1–4 di atas).
