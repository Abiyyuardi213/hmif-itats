# R0 Inventory — Baseline Codebase & Visual Assets

> Tanggal: 28 November 2026 · Repo: `hmif-itats` (commit baseline `c77925d`) · Status: Read-only audit + fix keamanan `DatabaseSeeder`.

---

## 1. Inventaris Blade Views & Components (41 berkas)

| Path | Baris |
|---|---|
| `resources/views/admin/dashboard.blade.php` | 64 |
| `resources/views/admin/divisions/edit.blade.php` | 45 |
| `resources/views/admin/divisions/index.blade.php` | 66 |
| `resources/views/admin/kegiatan/edit.blade.php` | 72 |
| `resources/views/admin/kegiatan/index.blade.php` | 102 |
| `resources/views/admin/members/edit.blade.php` | 54 |
| `resources/views/admin/members/index.blade.php` | 82 |
| `resources/views/admin/pemilu/index.blade.php` | 62 |
| `resources/views/admin/pemilu/show.blade.php` | 135 |
| `resources/views/admin/pengumuman/edit.blade.php` | 56 |
| `resources/views/admin/pengumuman/index.blade.php` | 80 |
| `resources/views/admin/periods/edit.blade.php` | 51 |
| `resources/views/admin/periods/index.blade.php` | 87 |
| `resources/views/admin/pesan/index.blade.php` | 45 |
| `resources/views/admin/proker/edit.blade.php` | 63 |
| `resources/views/admin/proker/index.blade.php` | 86 |
| `resources/views/admin/settings/edit.blade.php` | 67 |
| `resources/views/admin/users/index.blade.php` | 74 |
| `resources/views/emails/vote-token.blade.php` | 24 |
| `resources/views/layouts/admin.blade.php` | 119 |
| `resources/views/layouts/app.blade.php` | 40 |
| `resources/views/pages/about.blade.php` | 100 |
| `resources/views/pages/auth/login.blade.php` | 44 |
| `resources/views/pages/divisi/index.blade.php` | 43 |
| `resources/views/pages/divisi/show.blade.php` | 67 |
| `resources/views/pages/home.blade.php` | 229 |
| `resources/views/pages/kegiatan/index.blade.php` | 73 |
| `resources/views/pages/kegiatan/show.blade.php` | 77 |
| `resources/views/pages/kontak.blade.php` | 93 |
| `resources/views/pages/pemilu/ballot.blade.php` | 58 |
| `resources/views/pages/pemilu/index.blade.php` | 134 |
| `resources/views/pages/pemilu/receipt.blade.php` | 31 |
| `resources/views/pages/pengumuman/index.blade.php` | 70 |
| `resources/views/pages/pengumuman/show.blade.php` | 32 |
| `resources/views/pages/proker.blade.php` | 103 |
| `resources/views/pages/struktur.blade.php` | 106 |
| `resources/views/partials/flash.blade.php` | 28 |
| `resources/views/partials/footer.blade.php` | 90 |
| `resources/views/partials/logout-modal.blade.php` | 20 |
| `resources/views/partials/navbar.blade.php` | 118 |
| `resources/views/sitemap.blade.php` | 10 |

- **Components (`resources/views/components/`):** Belum ada (0 berkas).

---

## 2. Inventaris Aset Gambar (`public/image/`)

| Nama Berkas | Ukuran (KB) | Catatan |
|---|---|---|
| `default-avatar.svg` | 0.26 KB | Avatar fallback pengurus |
| `favicon.png` | 3.92 KB | Ikon tab 64×64 |
| `hima.png` | 159.63 KB | Logo HMIF ITATS (478×291) |
| `hmif-baksos.jpg` | 298.56 KB | Foto kegiatan bakti sosial |
| `hmif-gemini-futsal.jpg` | 368.24 KB | Foto kegiatan futsal |
| `hmif-pmo.jpg` | 221.4 KB | Foto kegiatan PMO |
| `hmif-webinar.jpg` | 221.76 KB | Foto kegiatan webinar |
| `hmif-wisuda72.jpg` | 146.06 KB | Foto penyambutan wisuda |
| `icon-hmif.jpg` | 24.51 KB | Ikon HMIF persegi (512×512) |
| `itats-biru.png` | 69.54 KB | Logo institusi ITATS |
| `Logo-Icon-Kabinet-Asakusa.jpg` | 2047.98 KB | Lembar sistem logo Kabinet Asakusa (perlu optimasi jika dipakai di web) |
| `Logo-Icon-Kabinet-Asakusa-Potrait.jpg` | 147.16 KB | Ikon potret Kabinet Asakusa (1350×1119) |

---

## 3. Literal Warna (`#hex`, `rgb()`, `hsl()`) di `resources/`

Hasil pemindaian `Get-ChildItem resources -Recurse -Include *.blade.php,*.css,*.js | Select-String -Pattern '#[0-9a-fA-F]{3,8}\b|rgb\(|hsl\('`:

- `resources/css/app.css:13` — `--color-ink-950: #0b1933;`
- `resources/css/app.css:14` — `--color-ink-900: #132547;`
- `resources/css/app.css:15` — `--color-ink-700: #334155;`
- `resources/css/app.css:16` — `--color-ink-500: #64748b;`
- `resources/css/app.css:17` — `--color-brand-700: #1e40af;`
- `resources/css/app.css:18` — `--color-brand-600: #1d4ed8;`
- `resources/css/app.css:19` — `--color-brand-500: #2563eb;`
- `resources/css/app.css:20` — `--color-brand-100: #dbeafe;`
- `resources/css/app.css:21` — `--color-brand-50: #eff6ff;`
- `resources/css/app.css:22` — `--color-cyan-600: #0284c7;`
- `resources/css/app.css:23` — `--color-cyan-500: #0ea5e9;`
- `resources/css/app.css:24` — `--color-surface: #f8fafc;`
- `resources/css/app.css:25` — `--color-line: #e2e8f0;`
- `resources/views/emails/vote-token.blade.php:7` — `color: #0b1933;` *(inline email HTML)*
- `resources/views/emails/vote-token.blade.php:16` — `background: #1d4ed8; color: #ffffff;` *(inline email HTML)*
- `resources/views/emails/vote-token.blade.php:20` — `color: #475569;` *(inline email HTML)*
- *(Catatan: hasil `#10003` dan `#8599` pada regex berasal dari HTML entity `&#10003;` dan `&#8599;`, bukan warna CSS.)*

---

## 4. Referensi Bootstrap di `resources/`

Hasil `Select-String -Path resources -Pattern 'bootstrap'`:
- `resources/js/app.js:1: import './bootstrap';` — Ini merujuk pada modul Laravel bawaan `resources/js/bootstrap.js` (konfigurasi `axios`), **bukan** framework CSS Bootstrap. Tidak ada referensi CDN Bootstrap CSS/JS.

---

## 5. Sampling Warna Dominan Logo & Perbandingan dengan `DESIGN.md`

### Hasil Sampling PHP GD (mengecualikan latar putih `> 242,242,242`)

1. **`public/image/icon-hmif.jpg` (512×512, 6.931 sampel non-putih):**
   - `#1E1B14` (`rgb(30,27,20)`): 7,3% — tinta/garis logo
   - `#EAFFFF` (`rgb(234,255,255)`): 2,6% — tepi anti-aliasing biru muda
   - `#0489DE` (`rgb(4,137,222)`): 2,3% — **cincin orbit biru HMIF**
   - `#7F7F7B` / `#747370` / `#676764`: abu-abu shading bola

2. **`public/image/hima.png` (478×291, 15.065 sampel non-putih):**
   - `#1E1B14` (`rgb(30,27,20)`): 9,2% — tinta/garis logo
   - `#028ADE` (`rgb(2,138,222)`): 6,0% — **cincin orbit biru HMIF**
   - `#028BE7` (`rgb(2,139,231)`): 2,6% — cincin orbit biru HMIF
   - `#0488D3` (`rgb(4,136,211)`): 2,0% — cincin orbit biru HMIF

3. **`public/image/Logo-Icon-Kabinet-Asakusa-Potrait.jpg` (1350×1119, 6.526 sampel non-putih):**
   - `#D4A340` (`rgb(212,163,64)`): 33,8% — **emas / amber utama huruf A & jaringan**
   - `#111F3F` (`rgb(17,31,63)`): 25,9% — **navy gelap sisi kiri huruf A & teks**
   - `#0F1C38` (`rgb(15,28,56)`): 13,0% — **navy gelap**
   - `#157BFD` (`rgb(21,123,253)`): 1,2% — **ujung panah biru elektrik**

### Perbandingan dengan Palet `DESIGN.md` Bagian 4

| Token di `DESIGN.md` | Proposal `DESIGN.md` | Hasil Sampling Logo Asli | Selisih / Catatan untuk R1 |
|---|---|---|---|
| `--p-ink-950` / `--p-ink-900` | `#0A0F1F` / `#101730` | `#0F1C38` / `#111F3F` (Logo Asakusa) | Sangat dekat; `#101730` hampir identik dengan `#111F3F`. |
| `--p-orbit-600` | `#2563EB` | `#028ADE` / `#0489DE` (cincin HMIF) & `#157BFD` (panah Asakusa) | Cincin HMIF asli lebih mengarah ke *cerulean* (`#028ADE`), panah Asakusa ke biru elektrik (`#157BFD`). |
| `--p-amber-400` / `500` | `#FBBF24` / `#F59E0B` | `#D4A340` / `#D3A239` (Logo Asakusa) | Emas Asakusa lebih hangat & muted (`#D4A340`) dibanding `#FBBF24`. |
| `--p-magenta-600` | `#C026D3` | Tidak muncul pada file logo; berasal dari feed IG & tombol portal live | Magenta mewakili visual feed Instagram `@hmif_itats`; butuh keputusan pemilik di R1 apakah primary tetap Magenta Asakusa atau bergeser ke Navy/Gold/Orbit dari logo baru. |
