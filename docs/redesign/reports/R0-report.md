# PHASE REPORT R0

**CLAIM** — Verifikasi kondisi awal repositori `hmif-itats`, pemindahan dokumen serta aset referensi ke `docs/redesign/`, audit dependensi dan kode, inventarisasi aset/warna, serta perbaikan celah keamanan kredensial default pada `DatabaseSeeder.php` telah selesai dijalankan tanpa satu pun perubahan desain tampilan maupun file terlarang pemilu. Seluruh 20 pengujian (123 assertions) termasuk 4 pengujian baru untuk abort keamanan seeder di environment `production` lulus, `composer audit` dan `npm audit --omit=dev` bersih (0 advisories/vulnerabilities), `pint --test` lulus, `npm run build` sukses, serta pencarian string password default lama di seluruh repositori menghasilkan 0 kemunculan.

---

## EVIDENCE

### 1. Git Status, Branches, and History

```text
=== GIT STATUS ===
M .env.example
M database/seeders/DatabaseSeeder.php
?? docs/
?? public/image/Logo-Icon-Kabinet-Asakusa-Potrait.jpg
?? public/image/Logo-Icon-Kabinet-Asakusa.jpg
?? tests/Feature/DatabaseSeederSecurityTest.php

=== GIT BRANCHES ===
* main
  remotes/origin/main
  remotes/upstream/HEAD -> upstream/main
  remotes/upstream/main

=== GIT LOG ===
c77925d feat: initialize HMIF ITATS web application with core modules and admin panel
c26e8a7 nambah struktur himpunan
2d1f973 nambah view about
c7cfdff nambah view homepage
ab30888 first commit
```

### 2. Security Audits, Pint, Vite Build, and Tests (Post-Fix Raw Output)

```text
{"tool":"pint","result":"passed"}=== COMPOSER AUDIT ===
No security vulnerability advisories found.
=== NPM AUDIT ===
found 0 vulnerabilities
=== PHP ARTISAN TEST ===

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\AdminElectionWorkflowTest
  ✓ panitia can create election import voters open and export audit csv                                          0.31s  

   PASS  Tests\Feature\AdminRbacTest
  ✓ guest cannot access admin routes                                                                             0.04s  
  ✓ kominfo role is restricted to content modules                                                                0.07s  
  ✓ panitia pemilu can access elections but not org or users                                                     0.04s  
  ✓ super admin validates activity dates against out of range typos                                              0.04s  
  ✓ inactive user cannot login                                                                                   0.25s  

   PASS  Tests\Feature\DatabaseSeederSecurityTest
  ✓ seeder aborts in production when admin email is missing                                                      0.01s  
  ✓ seeder aborts in production when admin password is missing                                                   0.01s  
  ✓ seeder aborts in production when deprecated default password is used                                         0.01s  
  ✓ seeder succeeds in production with explicit non default credentials                                          0.03s  

   PASS  Tests\Feature\EVotingSecurityTest
  ✓ request token requires email for both mahasiswa and dosen and rejects unregistered                           0.05s  
  ✓ verified voter can cast once and double vote is blocked                                                      0.07s  
  ✓ expired token and closed election and cross election candidate are rejected                                  0.04s  
  ✓ votes table preserves ballot secrecy without voter columns                                                   0.03s  

   PASS  Tests\Feature\PublicPortalTest
  ✓ all public pages render successfully with unique seo titles                                                  0.14s  
  ✓ legacy routes redirect cleanly                                                                               0.04s  
  ✓ public pages do not expose personal npm or stale branding                                                    0.06s  
  ✓ homepage stats reflect actual database counts                                                                0.04s  
  ✓ contact form stores valid message and blocks honeypot spam                                                   0.04s  

  Tests:    20 passed (123 assertions)
  Duration: 1.47s

=== NPM RUN BUILD ===

> build
> vite build

vite v7.3.8 building client environment for production...
transforming...
✓ 61 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json             0.33 kB │ gzip:  0.17 kB
public/build/assets/app-KLjQ6bHG.css  43.25 kB │ gzip:  8.32 kB
public/build/assets/app-DGDBAcGz.js   60.59 kB │ gzip: 22.61 kB
✓ built in 1.28s
```

### 3. Routes (`php artisan route:list --except-vendor`)

```text
  GET|HEAD        / ...................................................................... home › HomeController@index
  GET|HEAD        about ................................................................. about › HomeController@about
  GET|HEAD        admin ............................................ admin.dashboard › Admin\DashboardController@index
  GET|HEAD        admin/divisions ............................. admin.divisions.index › Admin\DivisionController@index
  POST            admin/divisions ............................. admin.divisions.store › Admin\DivisionController@store
  PUT|PATCH       admin/divisions/{division} ................ admin.divisions.update › Admin\DivisionController@update
  DELETE          admin/divisions/{division} .............. admin.divisions.destroy › Admin\DivisionController@destroy
  GET|HEAD        admin/divisions/{division}/edit ............... admin.divisions.edit › Admin\DivisionController@edit
  GET|HEAD        admin/kegiatan ............................... admin.kegiatan.index › Admin\ActivityController@index
  POST            admin/kegiatan ............................... admin.kegiatan.store › Admin\ActivityController@store
  PUT|PATCH       admin/kegiatan/{kegiatan} .................. admin.kegiatan.update › Admin\ActivityController@update
  DELETE          admin/kegiatan/{kegiatan} ................ admin.kegiatan.destroy › Admin\ActivityController@destroy
  GET|HEAD        admin/kegiatan/{kegiatan}/edit ................. admin.kegiatan.edit › Admin\ActivityController@edit
  GET|HEAD        admin/members .............................. admin.members.index › Admin\BoardMemberController@index
  POST            admin/members .............................. admin.members.store › Admin\BoardMemberController@store
  PUT|PATCH       admin/members/{member} ................... admin.members.update › Admin\BoardMemberController@update
  DELETE          admin/members/{member} ................. admin.members.destroy › Admin\BoardMemberController@destroy
  GET|HEAD        admin/members/{member}/edit .................. admin.members.edit › Admin\BoardMemberController@edit
  GET|HEAD        admin/pemilu ................................... admin.pemilu.index › Admin\ElectionController@index
  POST            admin/pemilu ................................... admin.pemilu.store › Admin\ElectionController@store
  GET|HEAD        admin/pemilu/{pemilu} ............................ admin.pemilu.show › Admin\ElectionController@show
  POST            admin/pemilu/{pemilu}/candidates admin.pemilu.candidates.store › Admin\ElectionController@storeCandidate
  GET|HEAD        admin/pemilu/{pemilu}/export ......... admin.pemilu.export › Admin\ElectionController@exportAuditCsv
  PATCH           admin/pemilu/{pemilu}/status ........... admin.pemilu.status › Admin\ElectionController@updateStatus
  POST            admin/pemilu/{pemilu}/voters-import admin.pemilu.voters.import › Admin\ElectionController@importVoters
  GET|HEAD        admin/pengumuman ....................... admin.pengumuman.index › Admin\AnnouncementController@index
  POST            admin/pengumuman ....................... admin.pengumuman.store › Admin\AnnouncementController@store
  PUT|PATCH       admin/pengumuman/{pengumuman} ........ admin.pengumuman.update › Admin\AnnouncementController@update
  DELETE          admin/pengumuman/{pengumuman} ...... admin.pengumuman.destroy › Admin\AnnouncementController@destroy
  GET|HEAD        admin/pengumuman/{pengumuman}/edit ....... admin.pengumuman.edit › Admin\AnnouncementController@edit
  GET|HEAD        admin/periods ................................... admin.periods.index › Admin\PeriodController@index
  POST            admin/periods ................................... admin.periods.store › Admin\PeriodController@store
  PUT             admin/periods/{period} ........................ admin.periods.update › Admin\PeriodController@update
  POST            admin/periods/{period}/activate ........... admin.periods.activate › Admin\PeriodController@activate
  GET|HEAD        admin/periods/{period}/edit ....................... admin.periods.edit › Admin\PeriodController@edit
  GET|HEAD        admin/pesan ............................... admin.pesan.index › Admin\ContactMessageController@index
  DELETE          admin/pesan/{pesan} ................... admin.pesan.destroy › Admin\ContactMessageController@destroy
  POST            admin/pesan/{pesan}/read ................ admin.pesan.read › Admin\ContactMessageController@markRead
  GET|HEAD        admin/proker ................................ admin.proker.index › Admin\WorkProgramController@index
  POST            admin/proker ................................ admin.proker.store › Admin\WorkProgramController@store
  PUT|PATCH       admin/proker/{proker} ..................... admin.proker.update › Admin\WorkProgramController@update
  DELETE          admin/proker/{proker} ................... admin.proker.destroy › Admin\WorkProgramController@destroy
  GET|HEAD        admin/proker/{proker}/edit .................... admin.proker.edit › Admin\WorkProgramController@edit
  GET|HEAD        admin/settings .................................. admin.settings.edit › Admin\SettingController@edit
  PUT             admin/settings .............................. admin.settings.update › Admin\SettingController@update
  GET|HEAD        admin/users ......................................... admin.users.index › Admin\UserController@index
  POST            admin/users ......................................... admin.users.store › Admin\UserController@store
  PATCH           admin/users/{user}/role ......................... admin.users.role › Admin\UserController@updateRole
  PATCH           admin/users/{user}/toggle ................... admin.users.toggle › Admin\UserController@toggleActive
  GET|HEAD        divisi ..................................................... divisi.index › DivisionController@index
  GET|HEAD        divisi/{slug} ................................................ divisi.show › DivisionController@show
  ANY             home ....................................................... Illuminate\Routing › RedirectController
  GET|HEAD        kegiatan ................................................. kegiatan.index › ActivityController@index
  GET|HEAD        kegiatan/{slug} ............................................ kegiatan.show › ActivityController@show
  GET|HEAD        kontak ............................................................ kontak › ContactController@index
  POST            kontak ...................................................... kontak.store › ContactController@store
  GET|HEAD        login ............................................................ login › Auth\LoginController@show
  POST            login ............................................ login.attempt › Auth\LoginController@authenticate
  ANY             login-guest ................................................ Illuminate\Routing › RedirectController
  POST            logout ....................................................... logout › Auth\LoginController@destroy
  GET|HEAD        pemilu ..................................................... pemilu.index › ElectionController@index
  GET|HEAD        pemilu/ballot/{token} ................................ pemilu.ballot › ElectionController@showBallot
  POST            pemilu/ballot/{token} .................................... pemilu.cast › ElectionController@castVote
  GET|HEAD        pemilu/receipt ......................................... pemilu.receipt › ElectionController@receipt
  POST            pemilu/request-token ........................ pemilu.request-token › ElectionController@requestToken
  GET|HEAD        pengumuman ......................................... pengumuman.index › AnnouncementController@index
  GET|HEAD        pengumuman/{slug} .................................... pengumuman.show › AnnouncementController@show
  ANY             program .................................................... Illuminate\Routing › RedirectController
  GET|HEAD        proker .................................................. proker.index › WorkProgramController@index
  GET|HEAD        sitemap.xml ............................................................ sitemap › SitemapController
  GET|HEAD        struktur ........................................................ struktur › HomeController@struktur

                                                                                                   Showing [71] routes
```

### 4. Security Fix Diff & Legacy Password Removal

```diff
diff --git a/.env.example b/.env.example
index f0922dd..082a3af 100644
--- a/.env.example
+++ b/.env.example
@@ -63,3 +63,7 @@ AWS_BUCKET=
 AWS_USE_PATH_STYLE_ENDPOINT=false
 
 VITE_APP_NAME="${APP_NAME}"
+
+# Initial super admin credentials used only by DatabaseSeeder (never commit real values)
+ADMIN_SEED_EMAIL=
+ADMIN_SEED_PASSWORD=
diff --git a/database/seeders/DatabaseSeeder.php b/database/seeders/DatabaseSeeder.php
index 4b5ed07..b55bfd6 100644
--- a/database/seeders/DatabaseSeeder.php
+++ b/database/seeders/DatabaseSeeder.php
@@ -13,17 +13,45 @@
 use App\Models\User;
 use App\Models\WorkProgram;
 use Illuminate\Database\Seeder;
+use Illuminate\Support\Env;
 use Illuminate\Support\Facades\Hash;
+use Illuminate\Support\Str;
+use RuntimeException;
 
 class DatabaseSeeder extends Seeder
 {
+    private const DEPRECATED_PASSWORD_SHA256 = '2f2f40a3d3e6128b69094891bb4a663836dde009cac35e3ffd1fd4ddd40eaac9';
+
     public function run(): void
     {
+        $adminEmail = trim((string) Env::get('ADMIN_SEED_EMAIL', ''));
+        $adminPassword = (string) Env::get('ADMIN_SEED_PASSWORD', '');
+
+        $usesDeprecatedDefault = $adminPassword !== ''
+            && hash_equals(self::DEPRECATED_PASSWORD_SHA256, hash('sha256', $adminPassword));
+
+        if (app()->environment('production')) {
+            if ($adminEmail === '' || $adminPassword === '') {
+                throw new RuntimeException('ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD must be set in production before running DatabaseSeeder.');
+            }
+
+            if ($usesDeprecatedDefault) {
+                throw new RuntimeException('Refusing to seed production with the deprecated default admin password. Configure a unique ADMIN_SEED_PASSWORD.');
+            }
+        } else {
+            if ($usesDeprecatedDefault) {
+                throw new RuntimeException('Refusing to seed with the deprecated default admin password. Set a fresh ADMIN_SEED_PASSWORD or leave it empty for an ephemeral local password.');
+            }
+
+            $adminEmail = $adminEmail !== '' ? $adminEmail : 'admin@hmif-itats.local';
+            $adminPassword = $adminPassword !== '' ? $adminPassword : Str::random(32);
+        }
+
         User::query()->updateOrCreate(
-            ['email' => 'admin@hmif-itats.site'],
+            ['email' => $adminEmail],
             [
                 'name' => 'Administrator HMIF ITATS',
-                'password' => Hash::make('HMIF-Admin-ChangeMe!2026'),
+                'password' => Hash::make($adminPassword),
                 'role' => User::ROLE_SUPER_ADMIN,
                 'is_active' => true,
                 'email_verified_at' => now(),
```

```text
=== SEARCH OLD PASSWORD (post-fix) ===
0 occurrences found.
```

*(Catatan historis: sebelum perbaikan, pencarian string password lama hanya ditemukan 1 kali pada `database/seeders/DatabaseSeeder.php:26`. Tidak ada kemunculan di `README.md` maupun `docs/`.)*

### 5. Logo Dominant Color Sampling (Raw PHP GD Output) & Inventory

Inventaris lengkap view, gambar, warna literal di `resources/`, dan referensi Bootstrap tersimpan di `docs/redesign/R0-inventory.md`.

```text
icon-hmif.jpg (512x512, non-white samples: 6931):
  - #1E1B14 (rgb(30,27,20)) : 7.3% (508 px)
  - #EAFFFF (rgb(234,255,255)) : 2.6% (177 px)
  - #0489DE (rgb(4,137,222)) : 2.3% (157 px)
  - #7F7F7B (rgb(127,127,123)) : 1.9% (130 px)
  - #747370 (rgb(116,115,112)) : 1.8% (127 px)
  - #1F1D1B (rgb(31,29,27)) : 1.7% (120 px)
  - #F1FFFF (rgb(241,255,255)) : 1.5% (107 px)
  - #676764 (rgb(103,103,100)) : 1.5% (104 px)
hima.png (478x291, non-white samples: 15065):
  - #1E1B14 (rgb(30,27,20)) : 9.2% (1383 px)
  - #028ADE (rgb(2,138,222)) : 6% (903 px)
  - #028BE7 (rgb(2,139,231)) : 2.6% (393 px)
  - #73736F (rgb(115,115,111)) : 2% (306 px)
  - #0488D3 (rgb(4,136,211)) : 2% (294 px)
  - #807F7B (rgb(128,127,123)) : 2% (294 px)
  - #1E1C1A (rgb(30,28,26)) : 1.9% (281 px)
  - #676763 (rgb(103,103,99)) : 1.8% (269 px)
Logo-Icon-Kabinet-Asakusa-Potrait.jpg (1350x1119, non-white samples: 6526):
  - #D4A340 (rgb(212,163,64)) : 33.8% (2206 px)
  - #111F3F (rgb(17,31,63)) : 25.9% (1691 px)
  - #0F1C38 (rgb(15,28,56)) : 13% (848 px)
  - #091328 (rgb(9,19,40)) : 1.7% (111 px)
  - #D3A239 (rgb(211,162,57)) : 1.7% (110 px)
  - #111A2D (rgb(17,26,45)) : 1.6% (105 px)
  - #157BFD (rgb(21,123,253)) : 1.2% (81 px)
  - #0D162A (rgb(13,22,42)) : 1.2% (81 px)
```

### 6. Forbidden Files Diff Check

```text
=== FORBIDDEN FILES DIFF ===
(empty - 0 lines changed)
```

---

## LADDER CHECK

- **Files changed (`git diff --stat`):**
  - `.env.example` (+4)
  - `database/seeders/DatabaseSeeder.php` (+30 / -2)
- **Files added / moved:**
  - Ditambahkan oleh agen: `tests/Feature/DatabaseSeederSecurityTest.php`, `docs/redesign/R0-inventory.md`, `docs/redesign/reports/R0-report.md`
  - Dipindahkan sesuai permintaan owner: `docs/PRD.md` → `docs/redesign/PRD.md`, `docs/DESIGN.md` → `docs/redesign/DESIGN.md`, `mock/*` → `docs/redesign/reference/*`, `docs/*.pdf` → `docs/redesign/source/*`
  - Ditambahkan oleh owner sebelumnya: `public/image/Logo-Icon-Kabinet-Asakusa.jpg`, `public/image/Logo-Icon-Kabinet-Asakusa-Potrait.jpg`
- **Dependencies added:** 0 (belum menginstal `@fontsource-variable/*`, baru dimulai di R1).
- **Built beyond PRD:** Tidak ada.

---

## ACCEPTANCE

| ID | Verified By | Status |
|---|---|---|
| P3 (Hapus kredensial admin tetap & abort di production) | `DatabaseSeederSecurityTest` (4 test cases) + `git diff` + full-repo search `0 occurrences found.` | **VERIFIED** |
| AC-8.1 & AC-8.3 (Baseline pemilu & tes pemilu tidak tersentuh) | `EVotingSecurityTest`, `AdminElectionWorkflowTest` lulus + `FORBIDDEN FILES DIFF = (empty)` | **VERIFIED** |
| P1 (Transfer repo GitHub Org, domain, hosting, DB) | Aksi organisasi luar repo | **UNVERIFIED** (menunggu tindakan Kahim) |
| P2 (Snapshot kode & DB live `portal.hmif-itats.site`) | Akses server produksi berada di luar environment lokal | **UNVERIFIED** (menunggu tindakan Kahim + Divisi 6) |

---

## NOT VERIFIED

- **P1 & P2 (Tata kelola aset & snapshot live `portal.hmif-itats.site`):** Belum dapat diverifikasi oleh agen karena menyangkut akses akun GitHub/hosting/database produksi di luar workspace lokal.
- **Redesain visual, kontras tema, screenshot `/_styleguide`, & Lighthouse (R1–R4):** Sengaja belum dikerjakan pada R0 sesuai gerbang fase.

---

## RISKS / QUESTIONS

1. **Bahaya Privasi PDF di `docs/redesign/source/`:** Ketiga PDF resmi (`STRUKTUR KABINET ASAKUSA.pdf`, `BIODATA _ KELENGKAPAN KTM.pdf`, `PROGRAM KERJA _ RAB.pdf`) memuat **NPM 34 mahasiswa, NIP 5 pimpinan/dosen, serta nomor WhatsApp pribadi**. Jika repositori GitHub bersifat publik, **jangan commit ketiga PDF tersebut** (rekomendasi: tambahkan `docs/redesign/source/*.pdf` ke `.gitignore` dan hanya gunakan nama lengkap, jabatan, divisi, dan nama program kerja untuk data website).
2. **Keputusan D3 — Kontradiksi Merchandise:** Sebelumnya Anda menyampaikan *"merchandise tetap dibuat pada redesain ini sesuai Section 6 PRD"*, padahal **Section 6 butir 7 `PRD.md` & Section 3 Master Prompt saat ini melarang/menunda pembuatan halaman Merchandise**. Mohon konfirmasi tegas sebelum fase halaman dalam:
   - **Opsi A:** Perbarui `PRD.md` (status `D3 = Disetujui`) dan buat halaman katalog statis `/merchandise` (tanpa tabel baru — bila ya, sertakan daftar item/harga/foto/link order).
   - **Opsi B:** Tetap ditunda (tidak dibuat di R0–R5 sesuai Section 6 `PRD.md`).
3. **Keputusan D5 — Penyelarasan Warna Token untuk R1 (`tokens.css`):**
   - Sampling logo asli menunjukkan **Kabinet Asakusa (`Logo-Icon-Kabinet-Asakusa-Potrait.jpg`)** didominasi **Emas `#D4A340`**, **Navy `#111F3F` / `#0F1C38`**, dan **Biru Panah `#157BFD`**, sedangkan **`hima.png`** memakai biru cincin orbit **`#028ADE`**. Tidak ditemukan warna magenta di file logo (magenta `#C026D3` di `DESIGN.md` berasal dari feed IG/portal lama).
   - Untuk Phase R1 nanti, apakah `--primary` tetap **Magenta (`#C026D3`)** sesuai `DESIGN.md` (dengan penyesuaian `--p-orbit-600` ke `#028ADE`/`#157BFD` dan `--p-amber` ke `#D4A340`), atau `--primary` ingin diselaraskan ke **Navy/Emas/Biru** logo Asakusa?
4. **Cakupan Data Resmi PDF untuk R2/R3:**
   - Pada `STRUKTUR KABINET ASAKUSA.pdf`, kabinet memiliki **4 BPH Inti + 4 Divisi Resmi (PSDM 8, Litbang 7, Media Digital & HUMAS 8, Danus & Minat Bakat 7 = 34 pengurus)** ditambah **5 Jajaran Pelindung/Penasihat/Pembina**. Apakah seluruh nama & jabatan tersebut (tanpa NPM/NIP/WA) boleh langsung dimasukkan ke `DatabaseSeeder` pada fase R2/R3 bersama **12 Program Kerja** (tanpa menampilkan nominal RAB `Rp 14.150.000` di halaman publik)?
   - Aset `Logo-Icon-Kabinet-Asakusa.jpg` berukuran `2047.98 KB` berupa *brand logo sheet*, sedangkan `Logo-Icon-Kabinet-Asakusa-Potrait.jpg` (`147.16 KB`) berupa ikon logo persegi. Untuk banner halaman `/struktur` di R3, apakah Anda punya foto kabinet bersama atau sementara memakai foto dokumentasi yang ada di `public/image/` (`hmif-wisuda72.jpg` / `hmif-pmo.jpg`)?

*(Menunggu balasan **`APPROVE R0`** serta jawaban poin di atas sebelum melangkah ke **Phase R1**.)*
