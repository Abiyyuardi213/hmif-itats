# PRD — Redesain Tampilan Website HMIF ITATS

> Versi 1.2 · 28 November 2026 (v1.1: keputusan D1–D5 · v1.2: arsip, seeder resmi vs demo, avatar) · Pemilik produk: Kahim HMIF ITATS · Pelaksana: agen coding (Antigravity) di bawah pengawasan Kahim.
> Dokumen pendamping: `DESIGN.md` (visual) dan `ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md` (eksekusi bertahap).

---

## 1. Masalah

Website HMIF ITATS adalah etalase utama organisasi, tetapi hari ini ia gagal menjawab pertanyaan paling dasar pengunjung: *lagi ada kegiatan apa?* Beranda live menampilkan "Belum ada kegiatan", pengumuman terbaru berumur dua bulan, menu pemilu yang sudah ditutup, dan angka yang saling bertentangan (beranda bilang 10+ program, halaman Program Kerja bilang 0). Tampilan juga tidak mewakili identitas ITATS dan tidak setara dengan himpunan kampus lain yang sudah memakai tampilan modern. Mayoritas pengunjung datang dari HP lewat tautan di bio Instagram (@hmif_itats), sehingga kesan pertama ditentukan dalam beberapa detik di layar kecil.

Redesain ini **hanya** menyentuh lapisan tampilan dan cara data yang sudah ada ditampilkan. Ia bukan proyek fitur baru.

## 2. Pengguna

| Persona | Konteks | Yang dibutuhkan |
|---|---|---|
| **Maba 2026** (utama) | 18–19 tahun, membuka dari HP lewat link bio IG, belum kenal HMIF | Tahu HMIF itu apa, kegiatan terdekat, cara gabung/oprec, dalam ≤ 10 detik |
| **Mahasiswa aktif / anggota** | Cek jadwal, pengumuman, struktur, ikut pemilu | Informasi terkini yang konsisten dengan Instagram |
| **Dosen, alumni, calon mitra** (sekunder) | Menilai kredibilitas organisasi dari laptop | Struktur resmi, rekam jejak kegiatan, kontak resmi |

Pengurus yang mengelola konten lewat panel admin yang sudah ada **bukan** target redesain ini (lihat bagian 6).

## 3. Prasyarat dan keputusan terbuka

Redesain berjalan di repo lokal dan **tidak di-deploy** sebelum prasyarat tata kelola selesai. Pekerjaan tampilan aman dikerjakan paralel karena ia portabel (Blade + Tailwind) terhadap baseline mana pun yang akhirnya dipilih.

| # | Prasyarat / keputusan | Status | Pemilik |
|---|---|---|---|
| P1 | Kepemilikan repo dipindah ke GitHub Organization HMIF; serah terima domain, hosting, database, email | Belum | Kahim |
| P2 | Snapshot kode + database `portal.hmif-itats.site` yang live diambil dan diarsipkan, termasuk log pemilu | Belum | Kahim + Divisi 6 |
| P3 | Ganti kredensial admin seeder bawaan (lihat R0 di master prompt) | Belum | Agen, diverifikasi Kahim |
| D1 | **Nama kabinet 2026/2027:** Kabinet Asakusa (portal lama menulis "Kabinet Pacul", itu keliru) | **Selesai** | Kahim |
| D2 | **Menayangkan nama pengurus 2026/2027:** sumbernya PDF resmi yang diserahkan Kahim. Kahim wajib mengonfirmasi bahwa Sertijab sudah sah **sebelum deploy** | Data diterima; konfirmasi Sertijab ditunggu sebelum deploy | Kahim |
| D3 | **Halaman Merchandise:** disetujui dalam versi statis berbasis `config/merchandise.php`. Selama data belum diserahkan, rute memberi 404, tanpa menu, tanpa sitemap | Menunggu data item (nama, harga, foto, tautan pesan resmi) | Kahim + Divisi Dana dan Usaha |
| D4 | **Aset resmi:** logo HMIF dan logo Kabinet Asakusa (JPG) sudah ada. Belum ada: SVG/PNG transparan, foto grup kabinet | Sebagian | Divisi Media |
| D5 | **Palet:** diputuskan mengikuti logo resmi: navy + emas (Asakusa) + cerulean (HMIF). Magenta dibuang karena tidak ada di logo mana pun | **Selesai** | Kahim |

## 4. Prioritas

| Kelas | Isi |
|---|---|
| **MVP-kritis** | Token + tema terang/gelap · Data resmi Kabinet Asakusa di database · Beranda · Struktur · Kegiatan (daftar + detail) · Pengumuman (daftar + detail) · Kontak · Halaman Pemilu (hanya tampilan) · SEO dasar, performa, aksesibilitas · Halaman 404/500 |
| **Ditunda** | Maskot · Merchandise yang memakai checkout atau pembayaran · Seksi Prestasi · Tema per-kabinet · Redesain panel admin · Versi bahasa Inggris · Analitik · PWA · Pencarian |

## 5. User stories dan acceptance criteria

Setiap kriteria harus bisa dijadikan satu kasus uji. Kriteria yang tidak bisa diuji dianggap tidak ada.

### US-1 — Maba menemukan kegiatan terdekat
*Sebagai maba, saya ingin langsung melihat apa yang sedang atau akan berlangsung di HMIF, agar saya tahu apa yang bisa saya ikuti.*

- **AC-1.1** Given ada pemilu berstatus `open`, When saya membuka `/`, Then `x-now-card` menampilkan pemilu tersebut dengan tautan ke `/pemilu` (prioritas tertinggi).
- **AC-1.2** Given tidak ada pemilu terbuka dan ada kegiatan terbit dengan `event_date` ≥ hari ini, When saya membuka `/`, Then `x-now-card` menampilkan kegiatan terdekat dengan tanggal dan tautan ke detailnya.
- **AC-1.3** Given tidak ada kegiatan mendatang tetapi ada pengumuman tersemat, Then kartu menampilkan pengumuman tersemat terbaru.
- **AC-1.4** Given tidak ada satu pun dari tiga kondisi di atas, Then kartu menampilkan kegiatan selesai terakhir berlabel "Terakhir" dan tautan ke `/kegiatan`; teks "Belum ada kegiatan" tidak pernah tampil sendirian.
- **AC-1.5** Dari `/`, halaman detail kegiatan terdekat bisa dicapai dalam ≤ 2 klik.

### US-2 — Pengunjung HP mendapat pengalaman cepat dan rapi
- **AC-2.1** Given viewport 360×800, When `/` dimuat, Then `document.documentElement.scrollWidth <= window.innerWidth`.
- **AC-2.2** Given viewport 360px, Then semua elemen interaktif punya area sentuh ≥ 44×44px dan jarak antar-target ≥ 8px.
- **AC-2.3** Gambar LCP di `/` berukuran ≤ 180 KB dan memiliki `fetchpriority="high"`; gambar lain di bawah lipatan `loading="lazy"`.
- **AC-2.4** CLS pada `/` < 0,1.

### US-3 — Pengunjung memilih tema terang atau gelap
- **AC-3.1** Given perangkat memakai `prefers-color-scheme: dark` dan belum ada pilihan tersimpan, When halaman dimuat, Then atribut `data-theme="dark"` sudah terpasang sebelum render pertama (tanpa kedipan terang).
- **AC-3.2** Given saya menekan toggle tema, When saya memuat ulang halaman, Then tema pilihan saya bertahan.
- **AC-3.3** Kontras dihitung terpisah untuk tema terang dan gelap; semua pasangan teks memenuhi ≥ 4,5:1 (teks besar dan komponen UI ≥ 3:1).
- **AC-3.4** Tombol toggle punya teks aksesibel ("Mode gelap"/"Mode terang") dan `aria-pressed`.

### US-4 — Pengunjung melihat struktur organisasi yang benar dan aman
- **AC-4.1** Given periode aktif, When saya membuka `/struktur`, Then pengurus inti dan anggota tiap divisi tampil sesuai database, dikelompokkan per divisi.
- **AC-4.2** Given halaman `/struktur` dirender, Then HTML sumbernya tidak mengandung pola NPM (`06.20`); ada tes `assertDontSee`.
- **AC-4.3** Given ada periode arsip dan parameter `?periode=` berisi periode itu, Then yang tampil adalah periode itu dengan penanda "Arsip". Given tidak ada periode arsip, Then tab arsip tidak tampil.
- **AC-4.4** Given sebuah divisi tanpa anggota, Then tampil `x-empty-state` "Anggota divisi ini belum ditambahkan." tanpa mengosongkan seksi.
- **AC-4.5** Given foto anggota tidak ada, Then avatar bawaan sadar-tema tampil utuh (tidak terpotong, tidak menyilaukan di tema gelap) dan tidak ada permintaan gambar 404.

### US-5 — Pengunjung menjelajahi kegiatan
- **AC-5.1** Given kegiatan terbit, When saya membuka `/kegiatan`, Then daftar berurut `event_date` menurun dan tanggal tampil format Indonesia ("28 November 2025") dari kolom database.
- **AC-5.2** Setiap item memakai `x-window-card` dengan nama file mono dari slug dan `x-status-badge` berisi ikon + teks.
- **AC-5.3** Given saya membuka `/kegiatan/{slug}`, Then halaman menampilkan foto utama, judul `h1`, tanggal, lokasi, isi, dan tombol pendaftaran hanya jika `registration_url` terisi.
- **AC-5.4** Given slug tidak ada, Then respons 404 dengan halaman 404 bertema.

### US-6 — Pengunjung membaca pengumuman
- **AC-6.1** Daftar `/pengumuman` urut `published_at` menurun, item tersemat di atas.
- **AC-6.2** Detail `/pengumuman/{slug}` punya lebar baca ≤ 68ch dan metadata tanggal.
- **AC-6.3** Given pengumuman tidak terbit (`is_published = false`), Then respons 404.

### US-7 — Pengunjung mengirim pesan
- **AC-7.1** Given formulir `/kontak` valid, When dikirim, Then pesan tersimpan, pesan sukses tampil, dan nama aksi konsisten ("Kirim pesan" → "Pesan terkirim").
- **AC-7.2** Given isian tidak valid, Then galat tampil tepat di bawah kolom terkait dan fokus pindah ke galat pertama.
- **AC-7.3** Rate limit yang sudah ada tetap berlaku (tes yang ada tidak berubah).

### US-8 — Pemilih memakai halaman pemilu dengan tampilan baru, logika tetap
- **AC-8.1** Given semua tes di `EVotingSecurityTest` dan `AdminElectionWorkflowTest` sebelum redesain, When redesain selesai, Then semua tes itu lulus **tanpa diubah** (diff pada file tes = 0 baris).
- **AC-8.2** Given pemilu `closed`, When saya membuka `/pemilu`, Then tampil status ditutup/arsip dan tidak ada formulir.
- **AC-8.3** Diff pada `ElectionController`, `Services/VoterIdentifier`, model `Vote`/`EligibleVoter`/`VoterToken`, dan migrasi pemilu = 0 baris.

### US-9 — Berbagi tautan terlihat baik
- **AC-9.1** Setiap halaman publik punya `<title>` unik ≤ 60 karakter dan `meta description` unik ≤ 160 karakter (tes mengumpulkan semua dan memastikan tidak ada duplikat).
- **AC-9.2** Setiap halaman punya `og:title`, `og:description`, `og:image` (1200×630), `canonical`.
- **AC-9.3** `/sitemap.xml` valid dan memuat semua rute publik.

### US-10 — Pengunjung yang membutuhkan aksesibilitas
- **AC-10.1** Given `prefers-reduced-motion: reduce`, Then ticker statis dan animasi hero tidak berjalan.
- **AC-10.2** Given saya menavigasi dengan keyboard, Then tautan lompat ke konten adalah fokus pertama, urutan tab sesuai visual, dan setiap elemen interaktif menampilkan cincin fokus.
- **AC-10.3** Given menu mobile terbuka, Then fokus terkunci di dalamnya dan `Esc` menutupnya.
- **AC-10.4** Ticker memiliki tombol jeda yang bisa dioperasikan keyboard.
- **AC-10.5** Lighthouse mobile pada `/`, `/struktur`, `/kegiatan`, `/pengumuman`, `/kontak`: Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95; Performance ≥ 85 pada `/`. Bila tidak dapat dijalankan, statusnya UNVERIFIED.

### US-11 — Konsistensi data tanpa angka karangan
- **AC-11.1** Given statistik hero, Then setiap angka dihitung dari database; statistik bernilai 0 disembunyikan.
- **AC-11.2** Tidak ada angka, nama, atau tanggal yang ditulis keras (hardcode) di view/controller, kecuali isi seeder yang sudah ada.
- **AC-11.3** Nama organisasi di seluruh UI hanya berbentuk "HMIF ITATS" (pencarian untuk "HMTI", "HMTIF" = 0 hasil di `resources/`).

### US-12 — Pengunjung melihat merchandise (versi statis)
- **AC-12.1** Given `config/merchandise.php` berisi ≥ 1 item, When saya membuka `/merchandise`, Then daftar item tampil dengan nama, harga, foto, dan tautan pesan resmi; tautan "Merchandise" muncul di navbar dan `/sitemap.xml`.
- **AC-12.2** Given `config/merchandise.php` kosong, Then `/merchandise` memberi 404, tautan tidak muncul di navbar maupun sitemap.
- **AC-12.3** Tidak ada keranjang, checkout, pembayaran, atau tabel baru; tautan pesan hanya ke kanal resmi yang disetujui Kahim (bukan nomor pribadi pengurus).

### US-13 — Data resmi Kabinet Asakusa tampil benar dan aman
- **AC-13.1** Given berkas `docs/redesign/data/kabinet-asakusa-2026-2027.md` yang disetujui Kahim, When `OfficialDataSeeder` dijalankan (ia dipanggil `DatabaseSeeder` di **semua** environment termasuk production, bersifat idempoten), Then jumlah BPH, divisi, anggota per divisi, pimpinan/pembina, dan program kerja di database sama persis dengan berkas itu (tes membandingkan hitungan).
- **AC-13.2** Periode 2026/2027 "Kabinet Asakusa" berstatus aktif. Periode arsip hanya ada bila datanya berasal dari snapshot situs live yang disetujui (prasyarat P2); sebelum itu tidak ada periode arsip dan tidak ada data karangan sebagai pengganti.
- **AC-13.3** Tidak ada NPM, NIP, nomor telepon/WhatsApp, atau nominal RAB di berkas yang dilacak Git (`git grep` kosong), di seeder, dan di HTML semua rute publik.
- **AC-13.4** PDF sumber tidak dilacak Git: `git ls-files docs/redesign/source` kosong dan `.gitignore` memuat `docs/redesign/source/` dan `docs/redesign/reference/`.
- **AC-13.5** Tidak ada anggota, jabatan, divisi, atau program kerja yang tidak ada di PDF resmi (tidak ada data karangan).
- **AC-13.6** `DemoContentSeeder` hanya berjalan di non-production, hanya membuat kegiatan, pengumuman, dan pemilu contoh (bukan periode, divisi, pengurus, atau proker), dan **semua judulnya berawalan "[CONTOH]"**. Ada tes yang membuktikan seeding production tidak menyentuh data contoh.

## 6. Di luar cakupan (eksplisit)

Agen yang membangun lebih dari yang diminta dianggap menyimpang. Daftar ini mengikat:

1. **Tidak ada tabel, kolom, atau migrasi baru.** Semua yang dibutuhkan sudah ada di skema (`activities`, `announcements`, `elections`, `periods`, `divisions`, `board_members`, `work_programs`, `organization_settings`).
2. **Tidak mengubah logika e-voting**, autentikasi, RBAC, atau panel admin (selain memuat token CSS bila layout admin sudah memakai Tailwind).
3. **Tidak menambah framework JS** (React, Vue, Livewire, Alpine, jQuery), library animasi (GSAP, Framer Motion, three.js), atau paket ikon. Satu-satunya dependensi baru yang diizinkan: tiga paket `@fontsource-variable/*` untuk font.
4. Tidak membuat fitur baru: pendaftaran kegiatan di dalam situs, komentar, pencarian, notifikasi, akun anggota.
5. Tidak membuat maskot, ilustrasi AI, atau foto stok.
6. Tidak deploy, tidak menyentuh server produksi, tidak mengubah `.env` produksi.
7. Merchandise hanya versi statis berbasis config (US-12): tanpa keranjang, checkout, pembayaran, atau tabel baru.
8. Tidak menulis ulang atau menghapus tes yang ada agar lulus.
9. Tidak menampilkan atau menyimpan di Git: NPM, NIP, nomor telepon/WhatsApp pribadi, nominal RAB.

## 7. Metrik keberhasilan (satu angka)

**Waktu menemukan kegiatan berikutnya: ≤ 10 detik dan ≤ 2 klik dari beranda, diuji pada 5 mahasiswa (3 di antaranya maba) memakai HP mereka sendiri, tanpa bantuan.** Lulus bila 4 dari 5 berhasil. Hasil dicatat Kahim di `docs/redesign/usability-test.md`.

(Ambang teknis seperti Lighthouse dan CLS adalah gerbang rilis di acceptance criteria, bukan metrik keberhasilan.)

## 8. Daftar "terverifikasi berjalan"

Deskripsi bukan bukti. Setiap baris hanya dicentang bila ada bukti mentah di laporan fase.

| Komponen / fitur | Bukti yang diminta | Terverifikasi |
|---|---|---|
| Token 3 tingkat + tema | Hasil pencarian hex = 0 di luar `tokens.css`; screenshot dua tema | [ ] |
| Tanpa kedipan tema | Rekaman/uji muat ulang + log | [ ] |
| Beranda + `x-now-card` 4 cabang | Hasil `php artisan test` untuk 4 skenario AC-1.x | [ ] |
| Struktur tanpa NPM | Hasil tes AC-4.2 + `curl` ke rute dicari pola `06.20` | [ ] |
| Kontras per tema | Tabel hasil skrip | [ ] |
| Reduced-motion | Screenshot/DOM dengan emulasi | [ ] |
| Lighthouse | Ringkasan skor mentah | [ ] |
| Data resmi cocok dengan berkas yang disetujui | Tabel hitungan berkas vs database + hasil tes AC-13.1 | [ ] |
| Tidak ada data pribadi di Git/HTML | Hasil `git grep` + tes AC-13.3 | [ ] |
| Pemilu tidak berubah | `git diff --stat` file terlarang = kosong; tes pemilu lulus | [ ] |
| Tidak ada tabel baru | `git diff --stat database/migrations` = kosong | [ ] |

## 9. Risiko

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Baseline produksi ternyata berbeda dari repo ini | Kerja tampilan harus disesuaikan | Tampilan hanya di lapisan Blade + token; prasyarat P2 dikerjakan paralel |
| Agen mengklaim selesai tanpa bukti | Laporan palsu lolos | Gerbang bukti per fase; status default "UNVERIFIED" |
| Agen membangun berlebihan | Repo membengkak, sulit dirawat | Out of scope mengikat; tangga YAGNI; dependensi dibatasi |
| Data live belum dimigrasi ke database baru | Situs baru tampak kosong | Jangan deploy sebelum P2; seksi memakai keadaan kosong yang berguna |
| Nama/foto pengurus tayang sebelum Sertijab sah | Masalah legitimasi | Keputusan D2 |
