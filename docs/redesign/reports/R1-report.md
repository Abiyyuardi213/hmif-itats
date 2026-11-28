# PHASE REPORT R1

**CLAIM** — Pekerjaan susulan Phase R0 (**R1.0 butir C1–C7**) dan fondasi sistem desain **Phase R1** (3 paket font `@fontsource-variable/*` self-hosted = 114,35 KB woff2, arsitektur token 3 tingkat sesuai `DESIGN.md` v1.1 tanpa mengubah satu nilai hex primitif pun, mekanisme tema terang/gelap anti-kedipan sebelum stylesheet, utilitas semantik Tailwind v4 tanpa kelas warna bawaan di seluruh view, 14 ikon SVG inline di `resources/svg/`, 13 komponen Blade anonim plus `<x-icon>`, layout utama dan footer bersih tanpa catatan developer maupun tautan mati, serta galeri `/_styleguide` khusus environment `local`) telah selesai dibangun. Seluruh 24 pengujian (139 assertions) termasuk `StyleguideTest` (404 di production, 200 di local) dan 6 pengujian keamanan `DatabaseSeederSecurityTest` lulus, `pint --test` lulus, `npm run build` berhasil, audit Composer/NPM bersih, pencarian warna bawaan Tailwind dan sisa branding usang kosong, dan tangkapan layar serta uji DOM Chromium headless menunjukkan tema beralih tanpa reload, bertahan setelah reload tanpa kedipan, bebas overflow pada 360px/1280px, serta menjaga kontras seluruh pasangan teks/komponen memenuhi ambang WCAG (>= 4,5:1 / >= 3,0:1). Sesuai aturan gerbang kontras dan R1, dilaporkan bahwa perhitungan skrip WCAG pada border dekoratif mode gelap `rgba(255, 255, 255, 0.12)` di atas `#0A1429` menghasilkan `1,39:1` dibanding `≈1,53` di `DESIGN.md` 4.6; tidak ada primitif yang diubah tanpa persetujuan owner dan pekerjaan berhenti di gerbang R1 menunggu `APPROVE R1`.

---

## R0 CARRY-OVER (C1–C7)

### C1 — `.gitignore` & Untrack `docs/redesign/source/` dan `docs/redesign/reference/`
Status: **VERIFIED (working tree & index bersih; catatan riwayat lokal di commit `77e2309`)**

Perintah & output mentah:
```powershell
> git check-ignore -v docs/redesign/source/*.pdf docs/redesign/source/*.jpg docs/redesign/reference/*.png
.gitignore:25:docs/redesign/source/	docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - BIODATA _ KELENGKAPAN KTM.pdf
.gitignore:25:docs/redesign/source/	docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - PROGRAM KERJA _ RAB.pdf
.gitignore:25:docs/redesign/source/	docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - STRUKTUR KABINET ASAKUSA.pdf
.gitignore:25:docs/redesign/source/	docs/redesign/source/Logo-Icon-Kabinet-Asakusa.jpg
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132521.png
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132606.png
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132618.png
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132711.png
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132729.png
.gitignore:26:docs/redesign/reference/	docs/redesign/reference/Screenshot 2026-11-28 132911.png

> git ls-files docs
docs/redesign/DESIGN.md
docs/redesign/PRD.md
docs/redesign/R0-inventory.md
docs/redesign/reports/R0-report.md

> git status --short
 M .env.example
 M .gitignore
 M README.md
 M app/Providers/AppServiceProvider.php
 M database/seeders/DatabaseSeeder.php
 M docs/redesign/DESIGN.md
 M docs/redesign/PRD.md
D  "docs/redesign/reference/Screenshot 2026-11-28 132521.png"
D  "docs/redesign/reference/Screenshot 2026-11-28 132606.png"
D  "docs/redesign/reference/Screenshot 2026-11-28 132618.png"
D  "docs/redesign/reference/Screenshot 2026-11-28 132711.png"
D  "docs/redesign/reference/Screenshot 2026-11-28 132729.png"
D  "docs/redesign/reference/Screenshot 2026-11-28 132911.png"
D  "docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - BIODATA _ KELENGKAPAN KTM.pdf"
D  "docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - PROGRAM KERJA _ RAB.pdf"
D  "docs/redesign/source/STRUKTUR KEPENGURUSAN KABINET ASAKUSA HMIF ITATS 2026_2027 - STRUKTUR KABINET ASAKUSA.pdf"
 M package-lock.json
 M package.json
 D public/image/Logo-Icon-Kabinet-Asakusa.jpg
 M resources/css/app.css
 M resources/js/app.js
 M resources/views/admin/divisions/index.blade.php
 M resources/views/admin/kegiatan/index.blade.php
 M resources/views/admin/members/index.blade.php
 M resources/views/admin/pemilu/show.blade.php
 M resources/views/admin/pengumuman/index.blade.php
 M resources/views/admin/periods/index.blade.php
 M resources/views/admin/pesan/index.blade.php
 M resources/views/admin/proker/index.blade.php
 M resources/views/admin/users/index.blade.php
 M resources/views/emails/vote-token.blade.php
 M resources/views/layouts/admin.blade.php
 M resources/views/layouts/app.blade.php
 M resources/views/pages/about.blade.php
 M resources/views/pages/auth/login.blade.php
 M resources/views/pages/divisi/index.blade.php
 M resources/views/pages/divisi/show.blade.php
 M resources/views/pages/home.blade.php
 M resources/views/pages/kegiatan/index.blade.php
 M resources/views/pages/kontak.blade.php
 M resources/views/pages/pemilu/ballot.blade.php
 M resources/views/pages/pemilu/index.blade.php
 M resources/views/pages/pemilu/receipt.blade.php
 M resources/views/pages/pengumuman/index.blade.php
 M resources/views/pages/proker.blade.php
 M resources/views/pages/struktur.blade.php
 M resources/views/partials/flash.blade.php
 M resources/views/partials/footer.blade.php
 M resources/views/partials/logout-modal.blade.php
 D resources/views/partials/navbar.blade.php
 M routes/web.php
 M tests/Feature/DatabaseSeederSecurityTest.php
?? database/seeders/DemoContentSeeder.php
?? docs/redesign/ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md
?? docs/redesign/evidence/
?? public/image/logo-asakusa.webp
?? resources/css/fonts.css
?? resources/css/tokens.css
?? resources/svg/
?? resources/views/components/
?? resources/views/pages/styleguide.blade.php
?? tests/Feature/StyleguideTest.php

> git log --all --oneline -- docs/redesign/source docs/redesign/reference
77e2309 feat: add database seeder, admin credentials config, and design documentation

> git branch -r --contains 77e2309
(kosong — commit 77e2309 hanya ada di lokal dan belum pernah di-push ke remote mana pun)
```
Catatan: Berkas fisik di `docs/redesign/source/` dan `docs/redesign/reference/` tetap utuh di disk, sudah dihapus dari indeks Git (`D`), dan seluruhnya masuk `.gitignore`. Karena commit lokal `77e2309` sebelumnya sempat merekam berkas tersebut sebelum C1 dijalankan, riwayat lokal masih mencatat `77e2309` (lihat RISKS / QUESTIONS agar owner memutuskan pembersihan riwayat lokal sebelum push).

---

### C2 — Pencarian Kredensial Lama di Riwayat Git
Status: **VERIFIED — Kredensial Lama Berstatus HANGUS**

Perintah & output mentah:
```powershell
> git log --all --oneline -S "HMIF-Admin-ChangeMe"
77e2309 feat: add database seeder, admin credentials config, and design documentation
c77925d feat: initialize HMIF ITATS web application with core modules and admin panel

> git branch -r --contains c77925d
  origin/main

> git status -sb
## main...upstream/main [ahead 2]
```
Penilaian keamanan:
- Kata sandi bawaan lama yang terikat dengan commit `c77925d` **sudah ter-push ke `origin/main`**, sehingga bersifat **HANGUS / COMPROMISED** dan **dilarang keras dipakai di server mana pun** (termasuk production maupun staging).
- Riwayat tidak ditulis ulang sesuai instruksi. Silakan lihat **RISKS / QUESTIONS** mengenai apakah `admin@hmif-itats.site` atau kata sandi tersebut pernah dipakai di server nyata.

---

### C3 — Perkerasan Seeder (`DatabaseSeeder.php` & `DemoContentSeeder.php`)
Status: **VERIFIED**

Ringkasan perilaku di `production` (terverifikasi kode + pengujian otomatis):
- Di `production`, `DatabaseSeeder::run()` **hanya** memvalidasi `ADMIN_SEED_EMAIL` dan `ADMIN_SEED_PASSWORD` (wajib ada, bukan kata sandi lama yang di-hash SHA-256, minimal `12` karakter di **semua** environment) lalu menjalankan `User::query()->updateOrCreate(['email' => $adminEmail], ...)` untuk **1** akun `super_admin`.
- Konten demo (periode, divisi, pengurus, proker, kegiatan, pengumuman, pemilu contoh) dipisah ke `database/seeders/DemoContentSeeder.php` dan **tidak dipanggil** saat `app()->environment('production')`.
- Di environment non-production dengan `ADMIN_SEED_PASSWORD` kosong, `Str::random(24)` dicetak sekali ke konsol via `$this->command?->warn("Generated local admin seed credentials: {$adminEmail} / {$adminPassword}");`.
- Variabel env didokumentasikan di `.env.example` baris 67–69 (tanpa nilai asli) dan di `README.md`.

---

### C4 — Bukti Mentah R0
Status: **VERIFIED**

Perintah & output mentah berkas terlarang pemilu & migrasi:
```powershell
> git diff --stat HEAD -- app/Http/Controllers/ElectionController.php app/Http/Controllers/Admin/ElectionController.php app/Services/VoterIdentifier.php app/Models/Vote.php app/Models/EligibleVoter.php app/Models/VoterToken.php app/Models/Election.php app/Models/ElectionCandidate.php tests/Feature/EVotingSecurityTest.php tests/Feature/AdminElectionWorkflowTest.php database/migrations
(kosong — exit code 0, 0 baris berubah)
```

Diff stat seeder & dokumentasi env:
```powershell
> git diff --stat HEAD -- database/seeders .env.example README.md
 .env.example                        |   2 +-
 README.md                           |  23 +-
 database/seeders/DatabaseSeeder.php | 419 ++----------------------------------
 3 files changed, 35 insertions(+), 409 deletions(-)
```

Isi lengkap `tests/Feature/DatabaseSeederSecurityTest.php` verbatim:
```php
<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Election;
use App\Models\Period;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Tests\TestCase;

class DatabaseSeederSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        $this->setSeedEnv(null, null);
        parent::tearDown();
    }

    public function test_seeder_aborts_in_production_when_admin_email_is_missing(): void
    {
        $this->setSeedEnv('', 'StrongUniquePassword!2026');
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_in_production_when_admin_password_is_missing(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', '');
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_when_admin_password_is_shorter_than_12_characters(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', 'short12345');
        $this->forceEnvironment('local');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('at least 12 characters');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_aborts_in_production_when_deprecated_default_password_is_used(): void
    {
        $legacyPassword = implode('-', ['HMIF', 'Admin', 'ChangeMe!2026']);
        $this->setSeedEnv('kahim@hmif-itats.site', $legacyPassword);
        $this->forceEnvironment('production');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('deprecated default admin password');

        app(DatabaseSeeder::class)->setContainer($this->app)->run();
    }

    public function test_seeder_prints_generated_password_once_in_local_when_empty(): void
    {
        $this->setSeedEnv('dev@hmif-itats.local', '');
        $this->forceEnvironment('local');

        $this->artisan('db:seed', ['--force' => true])
            ->expectsOutputToContain('Generated local admin seed credentials: dev@hmif-itats.local /')
            ->assertSuccessful();
    }

    public function test_seeder_succeeds_in_production_without_seeding_demo_data(): void
    {
        $this->setSeedEnv('kahim@hmif-itats.site', 'UniqueProductionSecret#9988');
        $this->forceEnvironment('production');

        $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

        $admin = User::query()->where('email', 'kahim@hmif-itats.site')->first();
        $this->assertNotNull($admin);
        $this->assertSame(User::ROLE_SUPER_ADMIN, $admin->role);
        $this->assertTrue(Hash::check('UniqueProductionSecret#9988', $admin->password));

        // Verify demo content is strictly skipped in production.
        $this->assertSame(0, Period::count());
        $this->assertSame(0, Activity::count());
        $this->assertSame(0, Announcement::count());
        $this->assertSame(0, Election::count());
    }

    private function setSeedEnv(?string $email, ?string $password): void
    {
        if ($email === null) {
            putenv('ADMIN_SEED_EMAIL');
            unset($_ENV['ADMIN_SEED_EMAIL'], $_SERVER['ADMIN_SEED_EMAIL']);
        } else {
            putenv("ADMIN_SEED_EMAIL={$email}");
            $_ENV['ADMIN_SEED_EMAIL'] = $email;
            $_SERVER['ADMIN_SEED_EMAIL'] = $email;
        }

        if ($password === null) {
            putenv('ADMIN_SEED_PASSWORD');
            unset($_ENV['ADMIN_SEED_PASSWORD'], $_SERVER['ADMIN_SEED_PASSWORD']);
        } else {
            putenv("ADMIN_SEED_PASSWORD={$password}");
            $_ENV['ADMIN_SEED_PASSWORD'] = $password;
            $_SERVER['ADMIN_SEED_PASSWORD'] = $password;
        }
    }

    private function forceEnvironment(string $environment): void
    {
        $this->app->detectEnvironment(fn () => $environment);
    }
}
```

---

### C5 — Aset Berat `Logo-Icon-Kabinet-Asakusa.jpg` & Turunan WebP
Status: **VERIFIED**

- `public/image/Logo-Icon-Kabinet-Asakusa.jpg` (±2 MB) dipindahkan keluar dari `public/` ke `docs/redesign/source/Logo-Icon-Kabinet-Asakusa.jpg` (terabaikan `.gitignore`).
- Turunan web `public/image/logo-asakusa.webp` dibuat dari `Logo-Icon-Kabinet-Asakusa-Potrait.jpg` dengan pelat terang dipakai pada rendering logo (`bg-plate` di navbar, footer, dan panel admin).

Output mentah:
```powershell
> Get-Item public/image/logo-asakusa.webp | ForEach-Object { "{0}: {1:N2} KB" -f $_.Name, ($_.Length / 1KB) }
logo-asakusa.webp: 16.25 KB
```

---

### C6 — Alias Token Lama untuk Admin + Verifikasi `/login` & `/admin`
Status: **VERIFIED**

- Alias `--color-ink-*`, `--color-brand-*`, `--color-cyan-*`, `--color-line` (dan `--color-surface` via `@theme inline`) dipindahkan ke `resources/css/tokens.css` (dan pemetaan utilitas di `resources/css/app.css`) sebagai alias ke token semantik baru dengan komentar `Legacy aliases for admin panel — delete when admin is restyled`.
- `AdminRbacTest` seluruh 5 pengujian lulus.
- Verifikasi visual & DOM Chromium nyata untuk `/login` (tema terang + gelap) dan `/admin` (login sebagai admin seed lokal):
  - `docs/redesign/evidence/R1/login-1280-light.png`
  - `docs/redesign/evidence/R1/login-1280-dark.png` (`inputBg: "rgb(15, 28, 56)"`, `inputBorder: "rgb(174, 185, 211)"`)
  - `docs/redesign/evidence/R1/admin-1280.png` (`asideBg: "rgb(15, 28, 56)"`, `scrollWidth: 1280`, `innerWidth: 1280`)

---

### C7 — Email Token Pemilih (`resources/views/emails/vote-token.blade.php`)
Status: **VERIFIED (dikecualikan secara eksplisit dari gerbang pencarian hex)**

- `resources/views/emails/vote-token.blade.php` memakai nilai hex inline persis primitif `DESIGN.md` 4.1 (`#F5F7FC`, `#FFFFFF`, `#0F1C38`, `#D4A340`, `#0A1429`, `#4A5878`, `#0369A1`) beserta komentar Blade yang merujuk nama token primitifnya.

---

## EVIDENCE (PHASE R1)

### 1. `git diff --stat` dan `git diff package.json`

```text
 .env.example                                     |   2 +-
 .gitignore                                       |   2 +
 README.md                                        |  23 +-
 app/Providers/AppServiceProvider.php             |   2 +-
 database/seeders/DatabaseSeeder.php              | 419 +----------------------
 docs/redesign/DESIGN.md                          | 156 ++++++---
 docs/redesign/PRD.md                             |  33 +-
 package-lock.json                                |  33 ++
 package.json                                     |   3 +
 public/image/Logo-Icon-Kabinet-Asakusa.jpg       | Bin 2097135 -> 0 bytes
 resources/css/app.css                            | 169 +++++++--
 resources/js/app.js                              | 167 ++++++++-
 resources/views/admin/divisions/index.blade.php  |   2 +-
 resources/views/admin/kegiatan/index.blade.php   |   4 +-
 resources/views/admin/members/index.blade.php    |   2 +-
 resources/views/admin/pemilu/show.blade.php      |   2 +-
 resources/views/admin/pengumuman/index.blade.php |   2 +-
 resources/views/admin/periods/index.blade.php    |   6 +-
 resources/views/admin/pesan/index.blade.php      |   2 +-
 resources/views/admin/proker/index.blade.php     |   2 +-
 resources/views/admin/users/index.blade.php      |   2 +-
 resources/views/emails/vote-token.blade.php      |  39 ++-
 resources/views/layouts/admin.blade.php          |  49 ++-
 resources/views/layouts/app.blade.php            |  45 ++-
 resources/views/pages/about.blade.php            |  10 +-
 resources/views/pages/auth/login.blade.php       |  52 +--
 resources/views/pages/divisi/index.blade.php     |  10 +-
 resources/views/pages/divisi/show.blade.php      |  10 +-
 resources/views/pages/home.blade.php             |  62 ++--
 resources/views/pages/kegiatan/index.blade.php   |   6 +-
 resources/views/pages/kontak.blade.php           |   6 +-
 resources/views/pages/pemilu/ballot.blade.php    |   4 +-
 resources/views/pages/pemilu/index.blade.php     |  20 +-
 resources/views/pages/pemilu/receipt.blade.php   |   4 +-
 resources/views/pages/pengumuman/index.blade.php |   8 +-
 resources/views/pages/proker.blade.php           |  28 +-
 resources/views/pages/struktur.blade.php         |  18 +-
 resources/views/partials/flash.blade.php         |  31 +-
 resources/views/partials/footer.blade.php        | 115 ++++---
 resources/views/partials/logout-modal.blade.php  |  27 +-
 resources/views/partials/navbar.blade.php        | 118 -------
 routes/web.php                                   |   4 +
 tests/Feature/DatabaseSeederSecurityTest.php     |  42 ++-
 43 files changed, 874 insertions(+), 867 deletions(-)
```

```diff
diff --git a/package.json b/package.json
index a5707d8..18a8f5d 100644
--- a/package.json
+++ b/package.json
@@ -7,6 +7,9 @@
         "dev": "vite"
     },
     "devDependencies": {
+        "@fontsource-variable/bricolage-grotesque": "^5.3.0",
+        "@fontsource-variable/fraunces": "^5.3.0",
+        "@fontsource-variable/instrument-sans": "^5.3.0",
         "@tailwindcss/vite": "^4.0.0",
         "axios": "^1.11.0",
         "concurrently": "^9.0.1",
```

---

### 2. Pencarian Hex / `rgb(` / `hsl(`, Utilitas Warna Bawaan Tailwind, dan Sisa Lama di `resources/`

```powershell
> Get-ChildItem resources -Recurse -Include *.blade.php,*.css,*.js,*.svg | Where-Object { $_.FullName -notlike "*\resources\css\tokens.css" } | Select-String -Pattern '#[0-9a-fA-F]{3,8}\b|rgb\(|hsl\(' | ForEach-Object { "$($_.Path.Replace((Get-Location).Path + '\', '')):$($_.LineNumber): $($_.Line.Trim())" }
resources\views\emails\vote-token.blade.php:7: {{-- Email clients strip CSS custom properties; inline hex matches DESIGN.md 4.1 primitives: --p-paper-50 (#F5F7FC), --p-ink-900 (#0F1C38), --p-ink-950 (#0A1429), --p-gold-400 (#D4A340), --p-muted-light (#4A5878), --p-orbit-700 (#0369A1). --}}
resources\views\emails\vote-token.blade.php:8: <body style="font-family: sans-serif; background-color: #F5F7FC; color: #0F1C38; line-height: 1.6; max-width: 580px; margin: 0 auto; padding: 24px;">
resources\views\emails\vote-token.blade.php:9: <div style="background-color: #FFFFFF; border: 1px solid #0F1C38; border-radius: 16px; padding: 24px;">
resources\views\emails\vote-token.blade.php:10: <h2 style="margin-top: 0; margin-bottom: 8px; color: #0F1C38;">{{ $election->title }}</h2>
resources\views\emails\vote-token.blade.php:18: <a href="{{ $ballotUrl }}" style="display: inline-block; background-color: #D4A340; color: #0A1429; text-decoration: none; padding: 12px 22px; border-radius: 9999px; font-weight: bold;">
resources\views\emails\vote-token.blade.php:22: <p style="font-size: 13px; color: #4A5878;">
resources\views\emails\vote-token.blade.php:24: <a href="{{ $ballotUrl }}" style="color: #0369A1; word-break: break-all;">{{ $ballotUrl }}</a>
resources\views\emails\vote-token.blade.php:26: <p style="font-size: 13px; color: #4A5878; margin-bottom: 0;">
resources\views\pages\pemilu\receipt.blade.php:10: &#10003;
```
Catatan: Satu-satunya berkas Blade dengan warna hex adalah `resources/views/emails/vote-token.blade.php` yang memang **dikecualikan di C7**, sedangkan `&#10003;` di `pemilu/receipt.blade.php` adalah entitas HTML tanda centang (bukan warna hex). Semua 14 ikon di `resources/svg/` memakai `currentColor` sehingga nol hex.

```powershell
> Get-ChildItem resources/views -Recurse -File | Select-String -Pattern '(bg|text|border|ring|from|via|to|divide)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-\d' | ForEach-Object { "$($_.Path.Replace((Get-Location).Path + '\', '')):$($_.LineNumber): $($_.Line.Trim())" }
(kosong — 0 kemunculan)

> Get-ChildItem resources -Recurse -Include *.blade.php,*.css,*.js | Select-String -Pattern 'HMTI|HMTIF|getbootstrap|cdn\.jsdelivr|href="#"|Enam Divisi|enam divisi|design tokens' | ForEach-Object { "$($_.Path.Replace((Get-Location).Path + '\', '')):$($_.LineNumber): $($_.Line.Trim())" }
(kosong — 0 kemunculan)
```

---

### 3. Perhitungan Kontras WCAG 2.x per Tema (Skrip + Output Mentah)

Skrip PHP yang dijalankan:
```php
function srgbToLin(int $v): float {
    $c = $v / 255.0;
    return $c <= 0.04045 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
}
function hexToRgb(string $hex): array {
    $h = ltrim($hex, '#');
    return [hexdec(substr($h, 0, 2)), hexdec(substr($h, 2, 2)), hexdec(substr($h, 4, 2))];
}
function blendSrgb(array $fg, array $bg, float $alpha): array {
    return [
        (int) round($fg[0] * $alpha + $bg[0] * (1.0 - $alpha)),
        (int) round($fg[1] * $alpha + $bg[1] * (1.0 - $alpha)),
        (int) round($fg[2] * $alpha + $bg[2] * (1.0 - $alpha)),
    ];
}
function luminance(array $rgb): float {
    return 0.2126 * srgbToLin($rgb[0]) + 0.7152 * srgbToLin($rgb[1]) + 0.0722 * srgbToLin($rgb[2]);
}
function contrast(array $c1, array $c2): float {
    $l1 = luminance($c1);
    $l2 = luminance($c2);
    return (max($l1, $l2) + 0.05) / (min($l1, $l2) + 0.05);
}
$p = [
    'ink950' => hexToRgb('#0A1429'), 'ink900' => hexToRgb('#0F1C38'), 'ink800' => hexToRgb('#16264D'),
    'paper50' => hexToRgb('#F5F7FC'), 'sky100' => hexToRgb('#E3EEFB'), 'white' => hexToRgb('#FFFFFF'),
    'gold300' => hexToRgb('#E5BE6A'), 'gold400' => hexToRgb('#D4A340'), 'gold500' => hexToRgb('#B98A26'),
    'orbit400' => hexToRgb('#4DB3F0'), 'orbit500' => hexToRgb('#028ADE'), 'orbit700' => hexToRgb('#0369A1'),
    'elec400' => hexToRgb('#5B9DFF'), 'elec500' => hexToRgb('#157BFD'),
    'textL' => hexToRgb('#0F1C38'), 'mutedL' => hexToRgb('#4A5878'),
    'textD' => hexToRgb('#F3F6FC'), 'mutedD' => hexToRgb('#AEB9D3'),
    'green600' => hexToRgb('#15803D'), 'green400' => hexToRgb('#4ADE80'),
    'red600' => hexToRgb('#DC2626'), 'red400' => hexToRgb('#F87171'),
];
$pairs = [
    ['Terang: teks / bg', $p['textL'], $p['paper50'], 4.5],
    ['Terang: teks / bg-soft', $p['textL'], $p['sky100'], 4.5],
    ['Terang: teks / surface', $p['textL'], $p['white'], 4.5],
    ['Terang: muted / bg', $p['mutedL'], $p['paper50'], 4.5],
    ['Terang: muted / surface', $p['mutedL'], $p['white'], 4.5],
    ['Terang: tautan orbit-700 / bg', $p['orbit700'], $p['paper50'], 4.5],
    ['Terang: tautan orbit-700 / surface', $p['orbit700'], $p['white'], 4.5],
    ['Terang: on-primary / emas 400', $p['ink950'], $p['gold400'], 4.5],
    ['Terang: on-primary / emas 500 (hover)', $p['ink950'], $p['gold500'], 4.5],
    ['Terang: cincin fokus electric-500 / bg', $p['elec500'], $p['paper50'], 3.0],
    ['Terang: border-input muted-light / surface', $p['mutedL'], $p['white'], 3.0],
    ['Terang: band-text / band (navy 900)', $p['textD'], $p['ink900'], 4.5],
    ['Terang: band-muted / band (navy 900)', $p['mutedD'], $p['ink900'], 4.5],
    ['Terang: on-band emas 300 / navy 900', $p['gold300'], $p['ink900'], 4.5],
    ['Terang: success / success-surface (3% mix)', $p['green600'], blendSrgb($p['green600'], $p['white'], 0.03), 4.5],
    ['Terang: text / success-surface (3% mix)', $p['textL'], blendSrgb($p['green600'], $p['white'], 0.03), 4.5],
    ['Terang: danger / danger-surface (3% mix)', $p['red600'], blendSrgb($p['red600'], $p['white'], 0.03), 4.5],
    ['Terang: text / danger-surface (3% mix)', $p['textL'], blendSrgb($p['red600'], $p['white'], 0.03), 4.5],
    ['Terang: border danger / surface (tombol)', $p['red600'], blendSrgb($p['red600'], $p['white'], 0.03), 3.0],
    ['Terang: text / warning-surface (16% mix)', $p['textL'], blendSrgb($p['gold400'], $p['white'], 0.16), 4.5],
    ['Terang (DILARANG): cerulean 500 / bg', $p['orbit500'], $p['paper50'], 4.5],
    ['Terang (DILARANG): emas 400 / bg', $p['gold400'], $p['paper50'], 4.5],
    ['Gelap: teks / bg', $p['textD'], $p['ink950'], 4.5],
    ['Gelap: teks / surface (navy 900)', $p['textD'], $p['ink900'], 4.5],
    ['Gelap: teks / raised (navy 800)', $p['textD'], $p['ink800'], 4.5],
    ['Gelap: muted / bg', $p['mutedD'], $p['ink950'], 4.5],
    ['Gelap: muted / raised', $p['mutedD'], $p['ink800'], 4.5],
    ['Gelap: tautan orbit-400 / bg', $p['orbit400'], $p['ink950'], 4.5],
    ['Gelap: tautan orbit-400 / raised', $p['orbit400'], $p['ink800'], 4.5],
    ['Gelap: on-primary / emas 400', $p['ink950'], $p['gold400'], 4.5],
    ['Gelap: on-primary / emas 300 (hover)', $p['ink950'], $p['gold300'], 4.5],
    ['Gelap: cincin fokus electric-400 / bg', $p['elec400'], $p['ink950'], 3.0],
    ['Gelap: border-input muted-dark / surface', $p['mutedD'], $p['ink900'], 3.0],
    ['Gelap: band-text / band (navy 800)', $p['textD'], $p['ink800'], 4.5],
    ['Gelap: on-band emas 300 / band (navy 800)', $p['gold300'], $p['ink800'], 4.5],
    ['Gelap: success / success-surface (14% mix)', $p['green400'], blendSrgb($p['green400'], $p['ink900'], 0.14), 4.5],
    ['Gelap: text / success-surface (14% mix)', $p['textD'], blendSrgb($p['green400'], $p['ink900'], 0.14), 4.5],
    ['Gelap: danger / danger-surface (14% mix)', $p['red400'], blendSrgb($p['red400'], $p['ink900'], 0.14), 4.5],
    ['Gelap: text / danger-surface (14% mix)', $p['textD'], blendSrgb($p['red400'], $p['ink900'], 0.14), 4.5],
    ['Gelap: text / warning-surface (18% mix)', $p['textD'], blendSrgb($p['gold400'], $p['ink900'], 0.18), 4.5],
    ['Gelap (DEKORATIF): border 12% putih / bg', blendSrgb($p['white'], $p['ink950'], 0.12), $p['ink950'], 0.0],
];
foreach ($pairs as [$name, $fg, $bg, $min]) {
    $ratio = contrast($fg, $bg);
    $status = $min === 0.0 ? 'info' : ($ratio >= $min ? 'LULUS' : 'GAGAL');
    printf("%-43s | %5.2f:1 | target %.1f | %s\n", $name, $ratio, $min, $status);
}
```

Output mentah skrip kontras:
```text
Terang: teks / bg                           | 15.76:1 | target 4.5 | LULUS
Terang: teks / bg-soft                      | 14.39:1 | target 4.5 | LULUS
Terang: teks / surface                      | 16.89:1 | target 4.5 | LULUS
Terang: muted / bg                          |  6.62:1 | target 4.5 | LULUS
Terang: muted / surface                     |  7.10:1 | target 4.5 | LULUS
Terang: tautan orbit-700 / bg               |  5.54:1 | target 4.5 | LULUS
Terang: tautan orbit-700 / surface          |  5.93:1 | target 4.5 | LULUS
Terang: on-primary / emas 400               |  7.96:1 | target 4.5 | LULUS
Terang: on-primary / emas 500 (hover)       |  5.87:1 | target 4.5 | LULUS
Terang: cincin fokus electric-500 / bg      |  3.71:1 | target 3.0 | LULUS
Terang: border-input muted-light / surface  |  7.10:1 | target 3.0 | LULUS
Terang: band-text / band (navy 900)         | 15.60:1 | target 4.5 | LULUS
Terang: band-muted / band (navy 900)        |  8.59:1 | target 4.5 | LULUS
Terang: on-band emas 300 / navy 900         |  9.57:1 | target 4.5 | LULUS
Terang: success / success-surface (3% mix)  |  4.81:1 | target 4.5 | LULUS
Terang: text / success-surface (3% mix)     | 16.21:1 | target 4.5 | LULUS
Terang: danger / danger-surface (3% mix)    |  4.60:1 | target 4.5 | LULUS
Terang: text / danger-surface (3% mix)      | 16.08:1 | target 4.5 | LULUS
Terang: border danger / surface (tombol)    |  4.60:1 | target 3.0 | LULUS
Terang: text / warning-surface (16% mix)    | 14.90:1 | target 4.5 | LULUS
Terang (DILARANG): cerulean 500 / bg        |  3.44:1 | target 4.5 | GAGAL
Terang (DILARANG): emas 400 / bg            |  2.15:1 | target 4.5 | GAGAL
Gelap: teks / bg                            | 16.94:1 | target 4.5 | LULUS
Gelap: teks / surface (navy 900)            | 15.60:1 | target 4.5 | LULUS
Gelap: teks / raised (navy 800)             | 13.68:1 | target 4.5 | LULUS
Gelap: muted / bg                           |  9.33:1 | target 4.5 | LULUS
Gelap: muted / raised                       |  7.53:1 | target 4.5 | LULUS
Gelap: tautan orbit-400 / bg                |  7.88:1 | target 4.5 | LULUS
Gelap: tautan orbit-400 / raised            |  6.36:1 | target 4.5 | LULUS
Gelap: on-primary / emas 400                |  7.96:1 | target 4.5 | LULUS
Gelap: on-primary / emas 300 (hover)        | 10.40:1 | target 4.5 | LULUS
Gelap: cincin fokus electric-400 / bg       |  6.74:1 | target 3.0 | LULUS
Gelap: border-input muted-dark / surface    |  8.59:1 | target 3.0 | LULUS
Gelap: band-text / band (navy 800)          | 13.68:1 | target 4.5 | LULUS
Gelap: on-band emas 300 / band (navy 800)   |  8.39:1 | target 4.5 | LULUS
Gelap: success / success-surface (14% mix)  |  7.25:1 | target 4.5 | LULUS
Gelap: text / success-surface (14% mix)     | 11.67:1 | target 4.5 | LULUS
Gelap: danger / danger-surface (14% mix)    |  5.05:1 | target 4.5 | LULUS
Gelap: text / danger-surface (14% mix)      | 12.90:1 | target 4.5 | LULUS
Gelap: text / warning-surface (18% mix)     | 11.51:1 | target 4.5 | LULUS
Gelap (DEKORATIF): border 12% putih / bg    |  1.39:1 | target 0.0 | info
```
Perbandingan dengan tabel referensi `DESIGN.md` 4.6:
- Semua 17 pasangan teks/UI pada tabel `DESIGN.md` 4.6 (`15.76`, `6.62`, `5.54`, `7.96`, `5.87`, `3.71`, `9.57`, `3.44`, `2.15`, `16.94`, `15.60`, `13.68`, `9.33`, `7.53`, `7.88`, `6.36`, `10.40`, `6.74`) cocok tepat hingga perseratusan.
- Selisih di luar pembulatan hanya ditemukan pada baris informasi non-teks `Gelap: border dekoratif 12% putih / bg`: `DESIGN.md` 4.6 menuliskan `≈1,53`, sedangkan kompositing alpha sRGB `rgba(255, 255, 255, 0.12)` di atas `#0A1429` (`#273043` vs `#0A1429`) menghasilkan `1,39:1`. Border ini hanya dipakai sebagai pemisah dekoratif (tidak untuk batas kolom input, yang memakai `--border-input` = `7,10:1` terang / `8,59:1` gelap). Sesuai aturan R1, tidak ada hex primitif di `tokens.css` yang diubah.

---

### 4. Ukuran Font `.woff2`, CSS/JS Gzip, `npm run build`, `pint --test`, `php artisan test`, Audit Dependensi

```text
=== NPM RUN BUILD ===

> build
> vite build

vite v7.3.8 building client environment for production...
transforming...
✓ 61 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                                                 1.18 kB │ gzip:  0.33 kB
public/build/assets/instrument-sans-latin-wght-normal-BbzFLZTg.woff2      30.09 kB
public/build/assets/bricolage-grotesque-latin-wght-normal-DLoelf7F.woff2  41.34 kB
public/build/assets/fraunces-latin-wght-italic-Py8at3oI.woff2             45.66 kB
public/build/assets/app-QC7QOFv0.css                                      68.11 kB │ gzip: 12.02 kB
public/build/assets/app-CrPK6Rdo.js                                       63.49 kB │ gzip: 23.41 kB
✓ built in 451ms
=== WOFF2 & GZIP SIZES ===
bricolage-grotesque-latin-wght-normal-DLoelf7F.woff2       40.38 KB
fraunces-latin-wght-italic-Py8at3oI.woff2                  44.59 KB
instrument-sans-latin-wght-normal-BbzFLZTg.woff2           29.39 KB
TOTAL WOFF2: 114.35 KB
app-CrPK6Rdo.js                               raw=  62.00 KB  gzip= 22.80 KB
app-QC7QOFv0.css                              raw=  66.51 KB  gzip= 11.72 KB
=== PINT TEST ===
{"tool":"pint","result":"passed"}=== PHP ARTISAN TEST ===

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.01s  

   PASS  Tests\Feature\AdminElectionWorkflowTest
  ✓ panitia can create election import voters open and export audit csv                                          0.47s  

   PASS  Tests\Feature\AdminRbacTest
  ✓ guest cannot access admin routes                                                                             0.05s  
  ✓ kominfo role is restricted to content modules                                                                0.29s  
  ✓ panitia pemilu can access elections but not org or users                                                     0.17s  
  ✓ super admin validates activity dates against out of range typos                                              0.14s  
  ✓ inactive user cannot login                                                                                   0.40s  

   PASS  Tests\Feature\DatabaseSeederSecurityTest
  ✓ seeder aborts in production when admin email is missing                                                      0.06s  
  ✓ seeder aborts in production when admin password is missing                                                   0.04s  
  ✓ seeder aborts when admin password is shorter than 12 characters                                              0.04s  
  ✓ seeder aborts in production when deprecated default password is used                                         0.05s  
  ✓ seeder prints generated password once in local when empty                                                    0.11s  
  ✓ seeder succeeds in production without seeding demo data                                                      0.03s  

   PASS  Tests\Feature\EVotingSecurityTest
  ✓ request token requires email for both mahasiswa and dosen and rejects unregistered                           0.13s  
  ✓ verified voter can cast once and double vote is blocked                                                      0.19s  
  ✓ expired token and closed election and cross election candidate are rejected                                  0.21s  
  ✓ votes table preserves ballot secrecy without voter columns                                                   0.31s  

   PASS  Tests\Feature\PublicPortalTest
  ✓ all public pages render successfully with unique seo titles                                                  1.69s  
  ✓ legacy routes redirect cleanly                                                                               0.21s  
  ✓ public pages do not expose personal npm or stale branding                                                    0.58s  
  ✓ homepage stats reflect actual database counts                                                                0.32s  
  ✓ contact form stores valid message and blocks honeypot spam                                                   0.15s  

   PASS  Tests\Feature\StyleguideTest
  ✓ styleguide returns 404 when environment is production                                                        0.08s  
  ✓ styleguide renders successfully when environment is local                                                    0.30s  

  Tests:    24 passed (139 assertions)
  Duration: 6.34s

=== COMPOSER & NPM AUDIT ===
No security vulnerability advisories found.
found 0 vulnerabilities
```
Ringkasan anggaran: Font `.woff2` total `114.35 KB` (<= `150 KB`), CSS gzip `11.72 KB` (<= `60 KB`), JS gzip `22.80 KB` (<= `60 KB`).

---

### 5. Bukti Browser Nyata (Playwright Chromium): Tanpa Kedipan, Persistensi Tema, Drawer Fokus, Mobile `360px`, & Tangkapan Layar

Log eksekusi Playwright headless (`verify-r1.mjs`) terhadap server lokal `http://127.0.0.1:8099`:
```text
DESKTOP LIGHT INITIAL: {"theme":"light","scrollWidth":1280,"innerWidth":1280,"togglePressed":"false","toggleLabel":"Mode gelap","themeLog":[{"stage":"DOMContentLoaded","theme":"light"},{"stage":"load","theme":"light"}]}
DESKTOP AFTER TOGGLE (NO RELOAD): {"theme":"dark","stored":"dark","togglePressed":"true","toggleLabel":"Mode terang","computedBg":"rgb(10, 20, 41)","moonHidden":true,"sunVisible":true}
DESKTOP AFTER RELOAD (PERSISTENCE/NO-FLASH): {"theme":"dark","stored":"dark","themeLog":[{"stage":"DOMContentLoaded","theme":"dark"},{"stage":"load","theme":"dark"}],"togglePressed":"true","toggleLabel":"Mode terang"}
TICKER AFTER PAUSE: {"pausedAttr":"true","pressed":"true","label":"Putar","pauseIconHidden":true}
LOGIN 1280 DARK: {"theme":"dark","inputBg":"rgb(15, 28, 56)","inputBorder":"rgb(174, 185, 211)","moonHidden":true}
ADMIN DASHBOARD (C6): {"url":"/admin","title":"Ringkasan Sistem — HMIF ITATS","h1":"Ringkasan Portal HMIF ITATS","asideBg":"rgb(15, 28, 56)","scrollWidth":1280,"innerWidth":1280}
OS DARK DEFAULT (NO STORAGE): {"theme":"dark","stored":null,"themeLog":[{"stage":"DOMContentLoaded","theme":"dark"}],"computedBg":"rgb(10, 20, 41)"}
MOBILE 360 LIGHT: {"scrollWidth":360,"innerWidth":360,"themeBtnSize":"110x44","menuBtnSize":"44x44"}
MOBILE DRAWER ESC CHECK: {"drawerOpenInfo":{"panelVisible":true,"activeInsidePanel":true},"drawerClosedInfo":{"panelHidden":true,"focusReturnedToToggle":true}}
MOBILE 360 DARK: {"theme":"dark","scrollWidth":360,"innerWidth":360}
CONSOLE ERRORS: []
FAILED ASSETS (>=400): []
```

Berkas tangkapan layar yang tersimpan dan diperiksa visual:
- `docs/redesign/evidence/R1/styleguide-1280-light.png` (833,021 bytes)
- `docs/redesign/evidence/R1/styleguide-1280-dark.png` (797,448 bytes)
- `docs/redesign/evidence/R1/styleguide-360-light.png` (663,101 bytes)
- `docs/redesign/evidence/R1/styleguide-360-dark.png` (636,479 bytes)
- `docs/redesign/evidence/R1/login-1280-light.png` (113,570 bytes)
- `docs/redesign/evidence/R1/login-1280-dark.png` (103,838 bytes)
- `docs/redesign/evidence/R1/admin-1280.png` (79,123 bytes)

---

## LADDER CHECK

- **Berkas ditambahkan:**
  - `resources/css/fonts.css`, `resources/css/tokens.css`
  - `resources/svg/*.svg` (14 ikon Lucide-style stroke `1.75px`, zero hex)
  - `resources/views/components/icon.blade.php` + 13 Blade anonymous components (`button`, `navbar`, `window-card`, `stat-strip`, `ticker`, `now-card`, `bento-nav`, `section-header`, `member-card`, `division-item`, `status-badge`, `empty-state`, `form-field`)
  - `resources/views/pages/styleguide.blade.php`, `tests/Feature/StyleguideTest.php`
  - `database/seeders/DemoContentSeeder.php` (pemisahan demo seed non-production sesuai R0 C3)
  - `public/image/logo-asakusa.webp` (16.25 KB sesuai R0 C5)
  - `docs/redesign/ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md` (disalin dari prompt v1.1), `docs/redesign/evidence/R1/*.png` (7 tangkapan layar), `docs/redesign/reports/R1-report.md`
- **Berkas diubah:** Lihat output `git diff --stat` di atas (43 berkas diubah/dihapus dari working tree: seeder/docs R1.0, CSS/JS/layout/komponen R1, penghapusan utilitas warna bawaan Tailwind & tulisan `"Enam Divisi"` di view, pembaruan `AppServiceProvider` agar `components.*` menerima data layout).
- **Berkas dihapus:** `resources/views/partials/navbar.blade.php` (digantikan `<x-navbar />`), `public/image/Logo-Icon-Kabinet-Asakusa.jpg` (dipindah ke `docs/redesign/source/` yang diabaikan Git), berkas sementara `public/hot` dihapus karena mengarah ke `http://[::1]:5173`.
- **Dependensi ditambahkan:** Hanya 3 paket font devDependencies di `package.json`: `@fontsource-variable/bricolage-grotesque`, `@fontsource-variable/fraunces`, `@fontsource-variable/instrument-sans`. Nol package JS runtime/UI/ikon tambahan.
- **Dibangun di luar PRD?** Tidak. Seluruh pekerjaan berada tepat dalam cakupan R1.0 (C1–C7) dan R1 (fondasi token, font, tema, layout, 13 komponen + ikon SVG, `/_styleguide`).

---

## ACCEPTANCE (Kriteria PRD yang Disentuh pada Phase R1)

| ID | Diverifikasi oleh | Status |
|---|---|---|
| AC-2.1 (no overflow 360px pada fondasi/styleguide) | Chromium `scrollWidth: 360, innerWidth: 360` di `/_styleguide` terang & gelap | **VERIFIED** (halaman beranda `/` menyusul di R2) |
| AC-2.2 (target sentuh >= 44px pada navbar mobile) | Chromium `themeBtnSize: 110x44`, `menuBtnSize: 44x44` | **VERIFIED** (audit seluruh `/` menyusul di R2/R4) |
| AC-3.1 (`prefers-color-scheme: dark` sebelum render, tanpa kedipan) | Chromium `OS DARK DEFAULT: theme=dark` pada `DOMContentLoaded` + script sinkron sebelum `@vite` | **VERIFIED** |
| AC-3.2 (toggle bertahan setelah reload tanpa reload saat klik) | Chromium `DESKTOP AFTER TOGGLE` + `DESKTOP AFTER RELOAD` (`localStorage.theme='dark'`) | **VERIFIED** |
| AC-3.3 (kontras terhitung terpisah per tema) | Skrip kontras WCAG PHP (`LULUS` semua pasangan teks >= 4.5:1, UI >= 3.0:1; selisih dekoratif 12% putih dijelaskan) | **VERIFIED** |
| AC-3.4 (toggle `aria-pressed` & teks "Mode gelap"/"Mode terang") | DOM check Chromium + `StyleguideTest::test_styleguide_renders_successfully_when_environment_is_local` | **VERIFIED** |
| AC-8.1 / AC-8.3 (file & tes e-voting 0 baris diff, semua lulus) | `git diff --stat HEAD -- ...` kosong + `php artisan test` (`EVotingSecurityTest`, `AdminElectionWorkflowTest` lulus) | **VERIFIED** |
| AC-10.3 (menu mobile kunci fokus + `Esc` tutup) | Chromium `MOBILE DRAWER ESC CHECK` (`activeInsidePanel: true` -> `panelHidden: true`, fokus kembali ke toggle) | **VERIFIED** |
| AC-10.4 (ticker punya tombol jeda keyboard) | DOM check Chromium `TICKER AFTER PAUSE` + implementasi `<button data-ticker-toggle>` | **VERIFIED** |
| AC-11.1 (logika sembunyikan statistik bernilai 0 pada komponen) | Visual check `x-stat-strip` pada `styleguide-1280-light.png` (item `value => 0` disembunyikan) | **VERIFIED** (integrasi data `/` menyusul di R2) |
| AC-11.3 (penamaan hanya HMIF ITATS, 0 "HMTI"/"HMTIF") | `Select-String` di `resources/` kosong | **VERIFIED** |
| AC-13.4 (PDF sumber tidak dilacak Git & masuk `.gitignore`) | `git check-ignore -v` + `git ls-files docs` (working tree & index bersih; catatan commit lokal `77e2309` di bawah) | **VERIFIED** (working tree/index) / lihat RISKS untuk commit lokal `77e2309` |

Kriteria halaman spesifik R1D (`AC-13.1`, `AC-13.2`, `AC-13.3`, `AC-13.5`), R2 (`AC-1.x`, `AC-2.3`, `AC-2.4`, `/` penuh), R3 (`US-4`..`US-9`, `US-12`), dan R4 (`AC-10.1`, `AC-10.2`, `AC-10.5` Lighthouse) **belum dikerjakan di Phase R1** dan menunggu gerbang fase berikutnya.

---

## NOT VERIFIED

- `UNVERIFIED: visual — viewport 768px (tablet) belum di-screenshot pada styleguide R1 (hanya 360px dan 1280px sesuai instruksi R1; 360/768/1280 akan diambil penuh mulai R2).`
- `UNVERIFIED: Lighthouse mobile — belum dijalankan pada R1 (terjadwal pada R2 `/` dan R4 penuh).`
- `UNVERIFIED: urutan Tab keyboard menyeluruh & prefers-reduced-motion melalui emulasi browser — ticker pause & mobile Esc terverifikasi di browser, sedangkan emulasi CSS reduced-motion dan audit urutan Tab lengkap di / dijadwalkan di R2/R4.`

**Langkah verifikasi manual untuk owner (opsional):**
1. Jalankan `php artisan serve` dari folder `hmif-itats`, lalu buka `http://127.0.0.1:8000/_styleguide` (`APP_ENV=local` di `.env`).
2. Ubah ukuran browser ke 360px dan 1280px, tekan tombol `"Mode gelap"` / `"Mode terang"`, muat ulang halaman (`F5`), uji tombol `"Jeda"` ticker dan menu mobile (`Esc`).

---

## RISKS / QUESTIONS

1. **Pertanyaan C2 (Kredensial Lama Ter-push ke `origin/main`):** Commit `c77925d` yang berisi kata sandi lama `HMIF-Admin-ChangeMe...` terkonfirmasi sudah berada di branch remote **`origin/main`**. Kata sandi tersebut **hangus** dan tidak boleh digunakan lagi. **Mohon konfirmasi owner:** apakah email `admin@hmif-itats.site` atau kata sandi lama tersebut pernah dipakai di server nyata / layanan lain?
2. **Peringatan C1 (Riwayat Commit Lokal `77e2309`):** Meskipun `docs/redesign/source/` dan `docs/redesign/reference/` sekarang sudah masuk `.gitignore` dan dihapus dari indeks Git (`D`), commit lokal `77e2309` (`ahead` dari `upstream/main`, **belum di-push ke remote mana pun**) masih menyimpan salinan berkas tersebut di riwayat lokal. Sebelum nanti melakukan `git push` ke repo organisasi HMIF, apakah Anda ingin kita menyapu commit lokal `77e2309` / membuat commit bersih terlebih dahulu agar PDF bermuatan NPM/NIP/WA pribadi tidak pernah masuk ke remote Git?
3. **Konfirmasi Kontras Border Dekoratif (`DESIGN.md` 4.6 vs Skrip WCAG):** Skrip kontras menghasilkan `1,39:1` (vs `≈1,53` pada `DESIGN.md` 4.6) untuk border dekoratif `rgba(255, 255, 255, 0.12)` di mode gelap. Tidak ada kolom input yang memakai token border ini (kolom formulir memakai `--border-input` dengan rasio `8,59:1`), dan tidak ada primitif hex yang saya ubah. Apakah nilai primitif & semantik `tokens.css` saat ini sudah disetujui untuk lanjut?

Silakan balas **`APPROVE R1`** (disertai jawaban pertanyaan 1–3 di atas) jika Phase R1 ini sudah sesuai, agar saya dapat melanjutkan ke **Phase R1D-a (ekstraksi data resmi Kabinet Asakusa ke berkas markdown untuk Anda proofread sebelum seeding)**.
