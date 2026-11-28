# DESIGN.md — Redesign Website HMIF ITATS

> Versi 1.2 · 28 November 2026 (v1.1: palet logo asli · v1.2: perbaikan setelah review R1: avatar, token pita, kontras terukur) · Stack target: Laravel 12 + Blade + Tailwind CSS v4 + Vite (sudah ada di repo).
> Dokumen ini adalah **sumber kebenaran visual**. Kalau ada konflik dengan view yang sudah ada, dokumen ini menang. Kalau ada konflik dengan `PRD.md`, PRD menang untuk *apa yang dibangun*, dokumen ini menang untuk *bagaimana tampilannya*.

---

## 1. Arah desain dalam satu paragraf

HMIF ITATS adalah himpunan mahasiswa informatika yang audiens utamanya membuka website dari **HP, lewat link di bio Instagram**. Jadi desainnya harus mobile-first, cepat, dan langsung menjawab tiga pertanyaan: *ini organisasi apa, lagi ada apa sekarang, dan gue bisa ikut apa.* Tampilan diambil dari tiga referensi dengan peran yang jelas, bukan ditempel semua: **struktur hero editorial** dari HMTC ITS, **kartu jendela (window-chrome) dan nuansa "anak informatika"** dari HMIF ITB, **navigasi pil melayang, toggle tema, dan ticker** dari HMIF UNEJ. Semua dibungkus identitas ITATS yang diambil dari logo resmi: cerulean dari logo HMIF, navy dan emas dari logo Kabinet Asakusa.

**Satu hal yang harus diingat orang:** hero dengan tiga baris judul besar + tumpukan kartu jendela berisi foto dokumentasi asli. Elemen lain sengaja tenang.

---

## 2. Sintesis tiga referensi (apa yang diambil, apa yang dibuang)

| Referensi | Diambil | Sengaja tidak diambil | Alasan |
|---|---|---|---|
| **hmifunej.id** (gelap, teal, maskot 3D) | Navbar pil melayang · toggle terang/gelap di pojok · ticker teks berjalan · kartu "navigasi cepat" | Maskot 3D · warna teal · tombol "Card" tanpa fungsi jelas | HMIF ITATS belum punya aset maskot; jangan bikin karakter asal. Teal bukan identitas ITATS. |
| **hmif.dev** (HMIF ITB, terang pastel) | Kartu jendela dengan 3 titik + nama file mono · kartu "Now at HMIF" · latar langit-biru pucat di mode terang · bintang dekoratif (maks 3) · tombol pil emas | Awan/gelembung dekoratif · bahasa Inggris · foto stok | Konsep "nama file" cocok dengan budaya informatika. Dekorasi berlebih menurunkan keterbacaan. |
| **hmtc-its.com** (gelap, editorial, serif) | Judul display raksasa · nama kabinet + periode sebagai blok tipografi · strip statistik menempel di dasar hero · teks vertikal di tepi · foto lebar penuh di halaman Struktur | Huruf kapital semua untuk label kecil · hero foto gelap penuh di beranda · teks "Kabinet Niat Baik" | Foto gelap penuh butuh overlay berat dan menyulitkan kontras. Dipakai hanya di halaman Struktur. |

---

## 3. Prinsip (urutan = prioritas saat konflik)

1. **Aksesibilitas dulu.** Kontras 4,5:1 untuk teks biasa, 3:1 untuk teks besar dan komponen UI, dicek **per tema**. Fokus keyboard selalu terlihat. Gerakan menghormati `prefers-reduced-motion`.
2. **Konten asli, bukan dekorasi.** Foto dokumentasi HMIF sendiri. Angka dari database. Tidak ada angka karangan, tidak ada foto stok, tidak ada ilustrasi AI.
3. **Mobile dulu.** Desain dimulai dari 360px. Desktop adalah perluasan, bukan kebalikannya.
4. **Boros di satu tempat.** Hero. Sisanya tenang dan disiplin.
5. **Token dulu, komponen kemudian.** Tidak ada nilai warna mentah di file komponen.

---

## 4. Token (3 tingkat)

Wajib mengikuti arsitektur tiga tingkat: **Primitif** (nilai mentah, tidak pernah dipakai langsung) → **Semantik** (berganti per tema) → **Komponen** (hanya mengonsumsi semantik). File tunggal: `resources/css/tokens.css`, diimpor dari `resources/css/app.css`.

> Palet v1.1 diturunkan dari **hasil sampling logo di R0** (`icon-hmif.jpg`, `hima.png`, `Logo-Icon-Kabinet-Asakusa-Potrait.jpg`): cincin orbit HMIF = cerulean `#028ADE`; Kabinet Asakusa = emas `#D4A340`, navy `#111F3F`/`#0F1C38`, panah biru elektrik `#157BFD`. **Magenta dibuang**: ia tidak muncul di logo mana pun, hanya berasal dari templat feed Instagram. Kontras di bawah dihitung dengan skrip (lihat 4.6); agent wajib menghitung ulang sendiri dan menempel skrip beserta hasilnya.

### 4.1 Tingkat 1 — Primitif

```css
:root {
  /* Ink: navy dari logo Asakusa. Dasar mode gelap. Bukan hitam murni. */
  --p-ink-950: #0A1429;
  --p-ink-900: #0F1C38;   /* ≈ navy logo */
  --p-ink-800: #16264D;
  --p-ink-700: #20336B;

  /* Paper / sky: dasar mode terang */
  --p-paper-50: #F5F7FC;
  --p-sky-100:  #E3EEFB;

  /* Emas Asakusa: warna utama untuk TOMBOL dan penanda. Bukan warna teks di tema terang. */
  --p-gold-300: #E5BE6A;
  --p-gold-400: #D4A340;  /* = emas logo */
  --p-gold-500: #B98A26;

  /* Orbit: cerulean cincin logo HMIF */
  --p-orbit-400: #4DB3F0;
  --p-orbit-500: #028ADE; /* = cerulean logo; dekoratif, bukan teks di tema terang */
  --p-orbit-700: #0369A1; /* tautan di tema terang */

  /* Electric: panah logo Asakusa, untuk cincin fokus */
  --p-electric-400: #5B9DFF;
  --p-electric-500: #157BFD;

  /* Teks */
  --p-text-light:  #0F1C38;
  --p-muted-light: #4A5878;
  --p-text-dark:   #F3F6FC;
  --p-muted-dark:  #AEB9D3;

  /* Status */
  --p-green-600: #15803D;  --p-green-400: #4ADE80;
  --p-red-600:   #DC2626;  --p-red-400:   #F87171;
}
```

### 4.2 Tingkat 2 — Semantik (terang = default, gelap = redesain, bukan inversi)

```css
:root, [data-theme="light"] {
  color-scheme: light;
  --bg:            var(--p-paper-50);
  --bg-soft:       var(--p-sky-100);        /* ujung gradien hero */
  --surface:       #FFFFFF;
  --surface-raised:#FFFFFF;
  --border:        rgba(15, 28, 56, 0.14);  /* pemisah dekoratif */
  --border-input:  var(--p-muted-light);    /* batas kolom formulir, wajib ≥ 3:1 */
  --text:          var(--p-text-light);
  --text-muted:    var(--p-muted-light);
  --primary:       var(--p-gold-400);       /* isi tombol utama */
  --primary-hover: var(--p-gold-500);
  --on-primary:    var(--p-ink-950);
  --link:          var(--p-orbit-700);
  --accent:        var(--p-orbit-500);      /* dekoratif saja */
  --focus-ring:    var(--p-electric-500);
  --band:          var(--p-ink-900);        /* pita ticker / footer / blok penegas */
  --on-band:       var(--p-gold-300);
  --border-on-band:rgba(255, 255, 255, 0.45); /* batas tombol/garis DI DALAM pita (≥4:1 di atas navy) */
  --success:       var(--p-green-600);
  --danger:        var(--p-red-600);
  --scrim:         rgba(10, 20, 41, 0.55);
  --shadow-card:   0 12px 32px -14px rgba(15, 28, 56, 0.28);
}

[data-theme="dark"] {
  color-scheme: dark;
  --bg:            var(--p-ink-950);
  --bg-soft:       var(--p-ink-900);
  --surface:       var(--p-ink-900);
  --surface-raised:var(--p-ink-800);        /* elevasi = permukaan lebih terang, bukan bayangan */
  --border:        rgba(255, 255, 255, 0.12);
  --border-input:  var(--p-muted-dark);
  --text:          var(--p-text-dark);
  --text-muted:    var(--p-muted-dark);
  --primary:       var(--p-gold-400);
  --primary-hover: var(--p-gold-300);
  --on-primary:    var(--p-ink-950);
  --link:          var(--p-orbit-400);
  --accent:        var(--p-orbit-500);
  --focus-ring:    var(--p-electric-400);
  --band:          var(--p-ink-800);
  --on-band:       var(--p-gold-300);
  --border-on-band:rgba(255, 255, 255, 0.45);
  --success:       var(--p-green-400);
  --danger:        var(--p-red-400);
  --scrim:         rgba(0, 0, 0, 0.6);
  --shadow-card:   none;                    /* gelap: pakai border + permukaan, bukan bayangan */
}
```

Aturan tema gelap yang tidak boleh dilanggar: tidak ada `#000`/`#fff` murni untuk latar atau teks utama; border dekoratif gelap `rgba(255,255,255,.12)`; warna interaktif bergeser lebih terang, bukan di-invert.

Token teks di dalam pita (`--band-text`, `--band-muted`) dan `--border-on-band` dipakai oleh **semua** elemen di atas `--band` (footer, ticker, blok penegas). Nama persisnya mengikuti `tokens.css`; bila berbeda dari yang tertulis di sini, agent melaporkannya. Pita bernuansa navy di **kedua** tema, jadi elemen di dalamnya **tidak boleh** memakai `--border`/`--text` tema terang (bug R1: tombol ghost Instagram di footer kehilangan batas di tema terang karena memakai `--border` 14% navy di atas navy).

Aturan pemakaian warna (hasil hitung kontras, bukan selera):
- **Emas (`--primary`) hanya sebagai isi tombol/penanda dengan teks `--on-primary` di atasnya.** Emas sebagai teks di tema terang hanya 2,15:1 → dilarang.
- **Cerulean `#028ADE` bukan warna teks di tema terang** (3,44:1). Tautan terang memakai `--p-orbit-700`.
- **Penanda halaman aktif di navbar memakai garis bawah warna `--text`**, bukan emas (emas di atas latar terang gagal 3:1).
- **Batas kolom formulir memakai `--border-input`**, bukan `--border` (12% putih di atas navy hanya ±1,5:1 dan hanya cocok sebagai pemisah dekoratif).

### 4.3 Tingkat 3 — Komponen (contoh)

```css
:root {
  --nav-bg: var(--surface);
  --nav-border: var(--border);
  --card-bg: var(--surface-raised);
  --card-shadow: var(--shadow-card);
  --window-bar-bg: var(--surface);
  --window-title-font: var(--font-mono);
  --stat-strip-bg: var(--surface);
  --ticker-bg: var(--band);
  --ticker-fg: var(--on-band);
}
```

Komponen hanya boleh mengonsumsi tingkat 2/3. Alias lama untuk panel admin (`--color-ink-*`, `--color-brand-*`, `--color-cyan-*`, `--color-surface`, `--color-line`) boleh dipertahankan **sementara** sebagai alias ke token semantik baru di bagian "legacy aliases" pada `tokens.css`, diberi komentar `delete when admin is restyled`, supaya panel admin tidak rusak. Tidak boleh dipakai di view publik.

### 4.4 Pemetaan ke Tailwind v4

Di `app.css`: `@import "tailwindcss";` lalu `@custom-variant dark (&:where([data-theme="dark"], [data-theme="dark"] *));` lalu blok `@theme inline { --color-bg: var(--bg); --color-surface: var(--surface); --color-primary: var(--primary); ... }` agar utilitas seperti `bg-bg`, `text-text`, `bg-primary` mengikuti tema otomatis. **Dilarang** memakai utilitas warna bawaan Tailwind (`bg-pink-500`, `text-slate-700`, dst.) di view.

### 4.5 Mekanisme tema

- Default mengikuti `prefers-color-scheme`. Toggle manual menimpa dan disimpan ke `localStorage` (`theme`).
- Skrip inline kecil di `<head>`, **sebelum** stylesheet, mengatur `data-theme` agar tidak ada kedipan tema salah.
- Toggle = ganti atribut, **bukan** reload halaman. Tombol punya `aria-pressed` dan label teks "Mode gelap" / "Mode terang" (ikon saja tidak cukup).

### 4.6 Kontras terhitung (referensi untuk verifikasi agent)

Dihitung dengan rumus WCAG 2.x. Agent harus menghasilkan tabel sendiri dari skrip yang ditempel; selisih dari tabel ini (di luar pembulatan) harus dijelaskan.

| Pasangan | Rasio | Target | Hasil |
|---|---|---|---|
| Terang: teks / bg | 15,76 | 4,5 | lulus |
| Terang: teks muted / bg | 6,62 | 4,5 | lulus |
| Terang: tautan `orbit-700` / bg | 5,54 | 4,5 | lulus |
| Terang: `on-primary` / emas 400 | 7,96 | 4,5 | lulus |
| Terang: `on-primary` / emas 500 (hover) | 5,87 | 4,5 | lulus |
| Terang: cincin fokus `electric-500` / bg | 3,71 | 3 | lulus |
| Terang: `on-band` emas 300 / navy 900 | 9,57 | 4,5 | lulus |
| Terang: cerulean 500 sebagai teks / bg | 3,44 | 4,5 | **gagal → dilarang** |
| Terang: emas 400 sebagai teks / bg | 2,15 | 4,5 | **gagal → dilarang** |
| Gelap: teks / bg | 16,94 | 4,5 | lulus |
| Gelap: teks / surface (navy 900) | 15,60 | 4,5 | lulus |
| Gelap: teks / raised (navy 800) | 13,68 | 4,5 | lulus |
| Gelap: teks muted / bg | 9,33 | 4,5 | lulus |
| Gelap: teks muted / raised | 7,53 | 4,5 | lulus |
| Gelap: tautan `orbit-400` / bg | 7,88 | 4,5 | lulus |
| Gelap: tautan `orbit-400` / raised | 6,36 | 4,5 | lulus |
| Gelap: `on-primary` / emas 400 | 7,96 | 4,5 | lulus |
| Gelap: `on-primary` / emas 300 (hover) | 10,40 | 4,5 | lulus |
| Gelap: cincin fokus `electric-400` / bg | 6,74 | 3 | lulus |
| Gelap: border dekoratif 12% putih / bg | 1,39 (dihitung agent di R1; estimasi awal 1,53 dikoreksi) | — | hanya pemisah dekoratif; **bukan** batas kolom formulir |
| Pita: `--border-on-band` (45% putih) / navy 900 dan navy 800 | 4,38 / 4,17 | 3 | lulus |
| Pita: teks 70% putih / navy 900 dan navy 800 | 8,77 / 7,95 | 4,5 | lulus |

Tabel lengkap dari skrip agent (`docs/redesign/reports/R1-report.md`, termasuk permukaan status) adalah acuan hidup. Pasangan baru yang dipakai di desain (misalnya teks di atas foto dengan overlay) wajib ditambahkan.

---

## 5. Tipografi

| Peran | Keluarga | Dipakai untuk | Catatan |
|---|---|---|---|
| Display | **Bricolage Grotesque** (variabel, bobot 600–800) | Judul hero, H1–H3 | Tracking rapat. Karakter modern yang tegas tanpa jadi generik. |
| Teks | **Instrument Sans** (variabel, 400–600) | Isi, UI, formulir | Terbaca di 16px, jelas berbeda dari display. |
| Editorial | **Fraunces** (italic, satu bobot) | **Hanya** nama kabinet + periode dan satu kutipan | Mengambil rasa editorial HMTC tanpa menjadikan seluruh situs serif. |
| Mono | tumpukan sistem: `ui-monospace, "Cascadia Code", "SF Mono", Menlo, monospace` | Nama file di kartu jendela, kode | Tanpa webfont (hemat bobot). |

Semua font **di-host sendiri** lewat paket `@fontsource-variable/*` yang dibundel Vite. **Dilarang** memuat Google Fonts dari CDN (ketergantungan jaringan saat build/runtime). Anggaran total font ≤ 150 KB woff2. `font-display: swap`, dan preload hanya untuk font display.

Skala (fluid, `clamp`):

| Token | Ukuran | Bobot | Line-height | Tracking |
|---|---|---|---|---|
| `display-xl` | `clamp(2.75rem, 1rem + 8vw, 6.5rem)` | 800 | 0.95 | -0.03em |
| `h1` | `clamp(2.25rem, 1rem + 4.5vw, 4rem)` | 700 | 1.05 | -0.025em |
| `h2` | `clamp(1.75rem, 1.1rem + 2.6vw, 2.75rem)` | 700 | 1.15 | -0.02em |
| `h3` | `1.375rem` | 600 | 1.3 | -0.01em |
| `body` | `1rem` | 400 | 1.6 | 0 |
| `small` | `0.875rem` | 400 | 1.5 | 0 |
| `caption` | `0.8125rem` | 500 | 1.4 | 0 |
| `editorial` | `clamp(1.25rem, 1rem + 1.2vw, 1.75rem)` | 400 italic | 1.3 | 0 |

Aturan: panjang baris isi maks 68 karakter (`max-width: 68ch`). Kalimat biasa (sentence case). **Dilarang**: label kecil huruf kapital semua dengan tracking lebar di atas setiap judul; menebalkan/mewarnai satu kata saja di tengah judul; panah "→" otomatis di setiap tautan.

---

## 6. Layout, spasi, bentuk

- **Grid:** kontainer maks 1200px, gutter 16 / 24 / 32px (mobile / tablet / desktop). Breakpoint: 360 (minimum), 640, 768, 1024, 1280.
- **Ritme spasi:** 4, 8, 12, 16, 24, 32, 48, 64, 96. Jarak antar-seksi: 64 (mobile) / 96 (desktop).
- **Radius bertingkat (bukan satu radius untuk semua):** pil `9999px` untuk navbar, tombol, chip · `20px` untuk kartu jendela dan foto · `12px` untuk input · `0` untuk strip statistik (dibatasi garis, bukan kotak).
- **Elevasi:** terang = bayangan `--shadow-card` bertinta navy halus; gelap = permukaan lebih terang + border. Jangan menyalin bayangan terang ke gelap.
- **Ikon:** SVG inline gaya Lucide (stroke 1.75px, ukuran 20/24), disimpan di `resources/svg/`, dipanggil lewat komponen `<x-icon name="...">`. Maksimal ±14 ikon. **Dilarang emoji sebagai ikon.** Tanpa paket ikon tambahan.
- **Area sentuh:** minimal 44×44px, jarak antar-target minimal 8px.

---

## 7. Komponen

Semua berupa **Blade anonymous component** di `resources/views/components/`. Tidak ada library komponen baru.

| Komponen | Spesifikasi |
|---|---|
| `x-navbar` | Pil melayang (sticky, `top: 12px + safe-area`), permukaan solid + border (tanpa blur berat). Kiri: logo + "HMIF ITATS". Tengah (≥1024px): 6 tautan. Kanan: toggle tema + tombol "Kontak HMIF". Mobile: tombol menu membuka panel penuh dengan fokus terkunci, tombol tutup, dan `Esc` menutup. Tautan aktif memakai `aria-current="page"` **dan** garis bawah (bukan warna saja). |
| `x-button` | Varian `primary` (isi `--primary`), `secondary` (border), `ghost`. Tinggi min 44px, pil. Status loading menonaktifkan tombol. |
| `x-window-card` | Kartu foto bergaya jendela: bilah atas 36px dengan 3 titik (emas/cerulean/electric, dekoratif `aria-hidden`) + **nama file mono** (slug + `.jpg`) + tanggal asli. Foto `aspect-ratio` tetap (cegah CLS). Miring statis ±1,5° hanya di ≥768px; hover meluruskan (gerak karena aksi pengguna). |
| `x-stat-strip` | Strip 2×2 (mobile) / 1×4 (desktop) menempel di dasar hero. Angka besar (`h2`) + label kecil sentence case. Dibatasi garis vertikal 1px. **Statistik bernilai 0 disembunyikan**, bukan ditampilkan "0". |
| `x-ticker` | Teks berjalan CSS murni (tanpa JS animasi). Isi: slogan + judul 5 pengumuman terbaru. Berhenti saat hover/fokus. **Tombol jeda wajib** (WCAG 2.2.2). Dengan `prefers-reduced-motion` menjadi daftar statis. |
| `x-now-card` | Kartu "Sedang berlangsung". Prioritas isi: (1) pemilu berstatus dibuka → (2) kegiatan/oprec yang akan datang atau sedang berjalan terdekat → (3) pengumuman tersemat terbaru → (4) kegiatan selesai terakhir berlabel "Terakhir". **Tidak pernah** tampil sebagai tulisan kosong "Belum ada kegiatan". |
| `x-bento-nav` | Navigasi cepat asimetris: 1 blok besar (Kegiatan) + 3 blok kecil (Struktur, Program kerja, Pengumuman). Bukan empat kartu identik. |
| `x-section-header` | Judul seksi + tautan "Lihat semua" opsional. Tanpa label kecil di atas judul. |
| `x-member-card` | Foto (rasio 4:5), nama, jabatan. **Tanpa NPM.** Avatar bawaan adalah **SVG inline yang sadar tema** (latar `--surface-raised`, siluet `--text-muted`, tanpa hex, siluet berada di dalam area aman sehingga tidak terpotong bingkai) dan **bukan** berkas statis berwarna terang di `public/` (bug R1: lingkaran abu terang menyilaukan di tema gelap dan terpotong di tepi kartu). |
| `x-division-item` | Baris daftar dua kolom (nama divisi + deskripsi singkat), dibatasi garis tipis. Bukan kartu. |
| `x-status-badge` | Selesai / Berjalan / Akan datang. Selalu **ikon + teks**, bukan warna saja. |
| `x-empty-state` | Satu kalimat penjelasan + satu aksi. Contoh: "Anggota divisi ini belum ditambahkan." |
| `x-form-field` | Label terlihat (bukan placeholder saja), pesan galat tepat di bawah kolom, teks bantu. |

Halaman galeri komponen `/_styleguide` **hanya terdaftar saat `APP_ENV=local`** (dan ada tes yang memastikan rute ini 404 di environment lain). Tujuannya sebagai alat verifikasi dua tema.

---

## 8. Wireframe

### 8.1 Beranda (desktop ≥1024px)

```
┌────────────────────────────────────────────────────────────────────────┐
│  ╭──────────────────────────────────────────────────────────────────╮  │
│  │ (logo) HMIF ITATS   Beranda Tentang Struktur Proker Kegiatan ... ◐ [Kontak HMIF] │ ← pil melayang
│  ╰──────────────────────────────────────────────────────────────────╯  │
│                                                                        │
│  Bertumbuh.                                ┌─ wisuda-ke-73.jpg  ● ● ● ┐ │
│  Berjejaring.                              │        [foto asli]       │ │
│  Berkarya.                                 └──────────────────────────┘ │
│                                                 ┌─ icc-2026.jpg ● ● ● ┐ │
│  Kabinet Asakusa · 2026/2027  (serif italic)    │     [foto asli]     │ │
│  [Lihat kegiatan]  [Gabung HMIF]                └─────────────────────┘ │
│                                                              Teknik     │
│                                                              Informatika│ ← teks vertikal
├───────────────┬──────────────┬─────────────────────┬──────────────────┤
│ 4 Divisi      │ 34 Pengurus  │ 3 Kegiatan selesai  │ 2026/2027        │ ← stat strip (angka contoh)
└───────────────┴──────────────┴─────────────────────┴──────────────────┘
▶ ‖ Informatika • Kolaboratif • Progresif  ✦  <judul pengumuman 1>  ✦ ...    ← ticker (+ tombol jeda)

┌──────────────────────────┐  ┌───────────────┬───────────────┐
│ Sedang berlangsung       │  │ Kegiatan      │ Struktur      │
│ <judul + tanggal + CTA>  │  │ (blok besar)  ├───────────────┤
│                          │  │               │ Program kerja │
└──────────────────────────┘  └───────────────┴───────────────┘

Kegiatan terbaru                                         Lihat semua
┌─ nama-file.jpg ●●● ┐ ┌─ nama-file.jpg ●●● ┐ ┌─ nama-file.jpg ●●● ┐

Divisi
Penelitian dan Pengembangan ──────── deskripsi singkat
Pengembangan Sumber Daya Mahasiswa ─ deskripsi singkat
...

[ Band ajakan: "Gabung HMIF" jika oprec aktif, selain itu "Ikuti kabar terbaru" → Instagram ]
Footer
```

### 8.2 Beranda (mobile 360px)

```
╭──────────────────────────╮
│ (logo) HMIF ITATS  ◐  ☰  │
╰──────────────────────────╯
Bertumbuh.
Berjejaring.
Berkarya.
Kabinet Asakusa · 2026/2027
[Lihat kegiatan] [Gabung HMIF]
┌─ wisuda-ke-73.jpg ●●● ┐   ← satu kartu jendela, tanpa miring
├──────────┬────────────┤
│ 4 Divisi │ 34 Pengurus│   ← stat 2×2 (angka contoh)
├──────────┼────────────┤
│ 3 Keg.   │ 2026/2027  │
└──────────┴────────────┘
▶ ‖ ticker
[Sedang berlangsung]
[Kegiatan][Struktur]
[Proker][Pengumuman]
Kegiatan terbaru (2 kartu + "Lihat semua")
Divisi (daftar 1 kolom)
Footer
```

### 8.3 Struktur Organisasi

**Banner bermerek, bukan foto grup.** Selama belum ada foto kabinet bersama, header halaman memakai gradien navy (`--band`) lebar penuh dengan logo Kabinet Asakusa di atas pelat terang (logo JPG berlatar putih tidak boleh ditaruh telanjang di atas navy), nama kabinet (Fraunces italic) dan periode. Gaya editorial HMTC dipertahankan lewat tipografi besar dan teks vertikal, bukan lewat foto. Bila foto kabinet resmi diserahkan, banner boleh diganti foto dengan overlay yang lolos kontras 4,5:1 untuk teks di atasnya (gambar OG dan LCP ikut aturan bagian 10). Di bawahnya: Pengurus inti (BPH), pimpinan/pembina bila ada di data resmi, lalu tiap divisi: judul, deskripsi, koordinator, anggota. Pemilih periode (aktif / arsip) berupa tab dengan `aria-selected`; **tab arsip hanya tampil bila ada periode arsip** (arsip berasal dari snapshot situs live yang disetujui, bukan dari PDF kabinet baru). Divisi tanpa anggota memakai `x-empty-state`. Jumlah divisi **tidak dipatok**: periode 2026/2027 dan arsip 2025/2026 punya jumlah divisi berbeda, semuanya dari database.

### 8.4 Kegiatan / Pengumuman

Daftar: `x-window-card` bergrid 1/2/3 kolom, urut `event_date` menurun, ada `x-status-badge`. Detail: foto utama, judul `h1`, metadata (tanggal asli dari database, lokasi, kategori), isi dengan lebar baca 68ch, tombol pendaftaran jika `registration_url` ada.

---

## 9. Gerak

Prinsip: gerak yang tidak dipicu pengguna dipakai **sangat sedikit**.

1. **Satu momen terorkestrasi:** saat pertama kali halaman beranda dimuat, tiga baris judul hero muncul bergantian (clip-path, selisih 80ms, durasi 400ms, sekali saja). Tidak ada animasi masuk di seksi lain.
2. **Ticker** (dengan jeda dan versi statis untuk reduced-motion).
3. **Gerak karena aksi pengguna:** hover kartu jendela meluruskan kemiringan (200ms), toggle tema menggeser warna (200ms), panel menu mobile membuka (250ms).
4. Dengan `prefers-reduced-motion: reduce`: no. 1 dihilangkan, no. 2 menjadi statis, no. 3 tanpa transform.
5. Dilarang: animasi lebar/tinggi, efek parallax, animasi muncul-saat-scroll di setiap seksi, partikel/canvas.

---

## 10. Citra

- Hero memakai foto dokumentasi **asli** dari `public/image/` (mis. wisuda, ICC, baksos, PMO). Jangan foto stok, jangan gambar buatan AI.
- Format WebP + cadangan JPEG, `srcset` 480/960/1600w, `loading="lazy"` kecuali gambar LCP (diberi `fetchpriority="high"`). Gambar LCP ≤ 180 KB.
- Setiap gambar punya `width`/`height` atau `aspect-ratio` (CLS < 0.1) dan `alt` deskriptif. Foto dekoratif memakai `alt=""`.
- Gambar OG bawaan 1200×630 (logo + nama + slogan) untuk pratinjau tautan di WhatsApp/Instagram.
- Logo: file yang ada berformat JPG berlatar putih. Di kedua tema logo ditaruh di atas **pelat terang** (radius 20px). Aset resmi yang diminta dari pengurus: SVG atau PNG transparan untuk logo HMIF dan Kabinet Asakusa. `Logo-Icon-Kabinet-Asakusa.jpg` (±2 MB, lembar sistem logo) **bukan aset web**: jangan taruh di `public/`; buat turunan ≤150 KB hanya bila dibutuhkan.
- Data pribadi: dilarang tampil di halaman publik, HTML, komentar, atau atribut `data-`: NPM, NIP, nomor telepon/WhatsApp pribadi, alamat email pribadi, dan nominal RAB.
- Maskot: **ditunda** sampai ada aset resmi dari pengurus.

---

## 11. Suara dan salinan

- Bahasa Indonesia, sentence case, kalimat aktif, hindari slogan kosong.
- Hero: judul tiga baris dari slogan yang sudah ada ("Bertumbuh. Berjejaring. Berkarya."). Dapat diubah lewat `organization_settings`.
- CTA menyebut hasilnya: "Lihat kegiatan", "Gabung HMIF", "Kirim pesan". Nama aksi konsisten sepanjang alur (tombol "Kirim pesan" → pesan sukses "Pesan terkirim").
- Galat menjelaskan apa yang salah dan cara memperbaikinya, tanpa permintaan maaf berlebihan.
- Keadaan kosong = ajakan bertindak, bukan suasana. Contoh: "Belum ada kegiatan terjadwal. Lihat kegiatan sebelumnya." + tautan.
- Dilarang: teks catatan developer di UI, "Lorem ipsum", angka karangan, nama brand salah eja (satu-satunya bentuk resmi: **HMIF ITATS**).

---

## 12. Aksesibilitas (lantai kualitas, bukan fitur tambahan)

- Tautan lompat "Loncat ke konten utama" sebagai elemen fokus pertama.
- Hierarki heading berurutan, satu `h1` per halaman.
- Cincin fokus 3px (`--focus-ring`) + offset 2px di semua elemen interaktif; **tidak boleh** `outline: none` tanpa pengganti.
- Landmark: `header`, `nav` (dengan `aria-label`), `main`, `footer`.
- Tab order sama dengan urutan visual. Menu mobile mengunci fokus dan bisa ditutup dengan `Esc`.
- Informasi tidak boleh hanya lewat warna (status, tautan aktif).
- Formulir: label terlihat, galat dekat kolom, `aria-describedby`.
- Target: Lighthouse Accessibility ≥ 95 pada semua halaman publik.

---

## 13. Daftar "jangan" (tanda desain generik yang harus dihindari)

1. Semua kartu seragam: satu radius, satu bayangan abu-abu, gradien dekoratif di mana-mana.
2. Label kecil kapital dengan tracking lebar di atas setiap judul; penanda bernomor 01/02/03 untuk konten yang bukan urutan.
3. Satu kata di judul diberi warna/italic berbeda.
4. Animasi fade-slide-up di setiap seksi dan hover-lift di setiap kartu.
5. Latar krem + serif + terakota; latar hampir hitam + satu hijau asam.
6. Tema gelap hasil membalik warna terang; hitam murni; bayangan terang disalin ke gelap.
7. Emoji sebagai ikon; nilai hex di file komponen; utilitas warna bawaan Tailwind di view.

---

## 14. Checklist verifikasi desain (bukti, bukan klaim)

Setiap butir harus punya bukti mentah di laporan fase (lihat `ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md`).

- [ ] Tidak ada hex di luar `tokens.css`, `resources/svg/`, dan berkas email. Pencarian **harus mencakup `public/` (termasuk `public/**/*.svg`)**, bukan hanya `resources/`. Hasil ditempel apa adanya.
- [ ] Tidak ada elemen yang terpotong bingkainya (avatar, foto, logo) pada 360/768/1280 px di kedua tema.
- [ ] Elemen di dalam pita (footer, ticker) memakai token pita; batas tombol terlihat di **kedua** tema.
- [ ] Kontras dihitung dengan skrip per tema (terang **dan** gelap) untuk pasangan: teks/bg, muted/bg, on-primary/primary, link/bg, teks di atas overlay foto. Tabel hasil ditempel.
- [ ] Dua tema benar-benar ditoggle dan di-screenshot di 360, 768, 1280px (6 gambar per halaman utama), bukan disimpulkan dari satu tema.
- [ ] Tidak ada kedipan tema saat muat ulang; pilihan tema bertahan setelah reload.
- [ ] Tidak ada scroll horizontal di 360px (`document.documentElement.scrollWidth <= window.innerWidth`).
- [ ] Reduced-motion: ticker statis, animasi hero hilang.
- [ ] Navigasi keyboard penuh di beranda: urutan fokus benar, menu mobile terkunci fokus, `Esc` menutup.
- [ ] Lighthouse mobile pada `/`: Performance ≥ 85, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95, CLS < 0.1. Bila Lighthouse tidak bisa dijalankan di environment agent, status = **UNVERIFIED**, bukan "lulus".
- [ ] Bobot: JS ≤ 60 KB gzip tanpa framework, CSS ≤ 60 KB gzip, font ≤ 150 KB.
