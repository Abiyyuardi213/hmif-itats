# Portal Web HMIF ITATS

Portal informasi resmi, manajemen organisasi, dan sistem E-Voting terverifikasi **Himpunan Mahasiswa Teknik Informatika (HMIF)** — Institut Teknologi Adhi Tama Surabaya (ITATS).

## Arsitektur & Fitur Utama

- **Portal Publik Dinamis:** Beranda (statistik terhitung langsung dari database), Tentang & Visi/Misi per periode, Struktur Kepengurusan (tanpa mengekspos NPM publik sesuai prinsip privasi data/UU PDP), Profil Divisi, Program Kerja, Kegiatan, Pengumuman, dan Kontak.
- **Panel Admin CMS & RBAC:** Manajemen Periode/Kabinet, Divisi, Pengurus, Program Kerja, Kegiatan, Pengumuman, Pesan Masuk, dan Audit Log untuk pengurus inti & pengelola portal.
- **Sistem E-Voting Pemilu Terverifikasi:**
  - Daftar Pemilih Tetap (DPT) dengan penyimpanan identifier ter-hash (HMAC-SHA256) & email wajib terverifikasi.
  - Token surat suara sekali pakai (*single-use hashed token*) dengan masa berlaku terbatas.
  - Pemisahan identitas pemilih (*eligible_voters*) dan suara anonim (*votes*) dalam transaksi database atomik (*pessimistic lock*) guna menjaga kerahasiaan suara dan mencegah *double voting*.
- **SEO & Performa:** Meta title & description dinamis per halaman, Open Graph, canonical URL, `sitemap.xml` otomatis, Tailwind CSS v4 + Vite bundling, dan aset gambar teroptimasi.

## Prasyarat Sistem

- PHP `>= 8.2` (ekstensi: `pdo_sqlite`/`pdo_mysql`, `gd`, `mbstring`, `openssl`, `fileinfo`, `curl`)
- Composer `>= 2.x`
- Node.js `>= 20` & NPM

## Instalasi Lokal

```powershell
git clone <url-repositori-organisasi> hmif-itats
cd hmif-itats

composer install
npm install

copy .env.example .env
php artisan key:generate
```

### Kredensial Seeder Admin (`ADMIN_SEED_EMAIL` & `ADMIN_SEED_PASSWORD`)

`DatabaseSeeder` membaca dua variabel lingkungan dari `.env`:

- `ADMIN_SEED_EMAIL`: alamat email akun `super_admin` awal.
- `ADMIN_SEED_PASSWORD`: kata sandi akun `super_admin` awal (**minimal 12 karakter** di semua environment).

Perilaku `php artisan db:seed`:
- Di **`local` / `testing`**: bila `ADMIN_SEED_PASSWORD` dikosongkan, seeder menghasilkan kata sandi acak dan menampilkannya satu kali pada output konsol (tidak ditulis ke log). Seeder juga memanggil `DemoContentSeeder` untuk mengisi data contoh lokal.
- Di **`production`**: seeder **membatalkan proses (`abort`)** bila `ADMIN_SEED_EMAIL` atau `ADMIN_SEED_PASSWORD` kosong, kurang dari 12 karakter, atau masih memakai kata sandi bawaan lama. Di `production`, `DatabaseSeeder` **hanya** membuat/memperbarui akun `super_admin` pada tabel `users` dan **tidak** menyeed data demo (`DemoContentSeeder` tidak dijalankan).

Jika menggunakan SQLite untuk pengembangan lokal:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
php artisan migrate --seed
php artisan storage:link
```

Jalankan server pengembangan & Vite:

```powershell
composer dev
```

Atau secara terpisah:

```powershell
npm run build
php artisan serve
```

## Pengujian & Audit Keamanan

```powershell
composer audit
npm audit --omit=dev
php vendor/bin/pint --test
php artisan test
php artisan route:list --except-vendor
```

## Tata Kelola Pengembangan

1. Gunakan branch `feature/<nama-fitur>` atau `fix/<nama-perbaikan>` dari `main`.
2. Jangan pernah meng-commit `.env`, kredensial database, dump data pemilih produksi, maupun berkas PDF/screenshot referensi di `docs/redesign/source/` dan `docs/redesign/reference/`.
3. Pastikan seluruh test dan CI checks lulus melalui Pull Request sebelum merge ke `main`.
