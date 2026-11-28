# ROADMAP & REKOMENDASI — Website HMIF ITATS

> 28 November 2026. Dokumen untuk Kahim dan Divisi 6. Urutan = prioritas. Semua rekomendasi di sini sudah disetujui Kahim.

## 0. Prinsip

Kode sudah tiga fase di depan tata kelola. Redesain yang bagus di repo lokal tidak menolong apa-apa selama situs yang tayang masih berjalan dari kode dan database yang tidak kamu pegang. Karena itu urutannya: **kendali → data → tampilan → tayang → rutinitas.**

## 1. Definisi "siap tayang" (gerbang deploy, semua harus centang)

| # | Syarat | Pemilik | Status |
|---|---|---|---|
| 1 | Repo dipindah ke GitHub Organization HMIF (Settings → Transfer); minimal 2 admin dan 2 maintainer; 2FA wajib untuk anggota org; branch protection di `main` | Kahim | Belum |
| 2 | Snapshot kode **dan** dump database `portal.hmif-itats.site` diarsipkan di tempat terpisah (bukan di repo) | Kahim + Divisi 6 | Belum |
| 3 | Log e-voting 2026 diekspor read-only dan salinannya dipegang panitia/dosen pembina | Kahim + panitia | Belum |
| 4 | Serah terima akun: registrar domain, DNS, hosting/VPS, database, email organisasi, SMTP. Semua kredensial dirotasi; kata sandi lama `HMIF-Admin-ChangeMe…` dianggap hangus | Kahim | Belum |
| 5 | Target deploy dipilih (VPS kecil atau hosting PHP yang mendukung Laravel 12 / PHP 8.2+), ada lingkungan staging, HTTPS aktif, `APP_DEBUG=false`, `APP_ENV=production` | Divisi 6 | Belum |
| 6 | SMTP produksi sudah diuji (token e-voting dikirim lewat email; `MAIL_MAILER=log` hanya untuk lokal) | Divisi 6 | Belum |
| 7 | `ADMIN_SEED_EMAIL`/`ADMIN_SEED_PASSWORD` diisi dengan kredensial unik; akun super admin dibatasi ≤ 2 orang | Kahim | Belum |
| 8 | Backup database terjadwal **dan** satu kali latihan restore berhasil | Divisi 6 | Belum |
| 9 | Data resmi Kabinet Asakusa tampil benar (R1D disetujui) dan Sertijab dikonfirmasi sah | Kahim | Menunggu |
| 10 | Redesain lolos semua gerbang R2–R5 dan uji "5 mahasiswa" (PRD bagian 7) | Kahim | Belum |

Jangan tentukan tanggal tayang sebelum butir 1–4 selesai. Itu bagian yang tidak bisa dikerjakan agen.

## 2. Tata kelola dan keberlanjutan (pelajaran dari serah terima ini)

- **Kamu mewarisi repo di akun pribadi mantan kahim dan database yang tidak kamu pegang.** Itu kegagalan serah terima, dan akan terulang pada kahim berikutnya kecuali dibuat prosedur. Buat `docs/HANDOVER.md` (agen menulisnya di R5, kamu mengisinya): daftar akun dan sistem, siapa pemilik, di mana kredensial disimpan (pengelola kata sandi tim, bukan chat), prosedur rotasi saat pergantian kepengurusan.
- **Minimal dua maintainer aktif** dari Divisi 6. Satu orang = titik gagal tunggal.
- **Alur kerja:** cabang `feature/*` → Pull Request → CI hijau → review → merge. CI (`ci.yml`) sudah ada; pastikan benar-benar jalan di repo organisasi.
- **Perawatan bulanan (15 menit):** `composer audit`, `npm audit --omit=dev`, perbarui patch Laravel, periksa sertifikat HTTPS, periksa backup. Dependabot mingguan boleh dipasang.
- Riwayat repo asli (commit `ab30888`–`c26e8a7`) dapat memuat NPM pengurus lama. Itu bukan kebocoran baru, tetapi pertimbangkan repo organisasi baru dengan riwayat bersih bila ingin menghilangkannya dari jejak sendiri.

## 3. Operasi konten (situs hanya sebaik rutinitas isinya)

Masalah terbesar portal lama bukan teknis: "Belum ada kegiatan", pengumuman berumur dua bulan, angka yang bertentangan. Redesain tidak memperbaiki itu. Rutinitas yang memperbaikinya:

1. **Satu pemilik konten** (Divisi Media/Kominfo, akun peran `admin_kominfo`), satu cadangan.
2. **Aturan 48 jam:** setiap kegiatan yang diumumkan di Instagram dicatat di website dalam 48 jam. Satu daftar periksa di grup pengurus.
3. **Satu sumber kebenaran:** tanggal, judul, dan tautan pendaftaran dimasukkan ke panel admin dulu, baru dibagikan ke Instagram dengan tautan portal.
4. **Latihan 30 menit** untuk pengelola konten memakai panel admin sebelum tayang.
5. **Selaraskan merek:** beri Divisi Media palet DESIGN.md (navy, emas, cerulean) sebagai brand kit untuk templat poster Instagram, supaya feed dan website terlihat satu keluarga. Magenta di templat lama tidak ada di logo mana pun.
6. **Link in bio** Instagram diarahkan ke portal; kegiatan terdekat selalu terlihat di beranda lewat kartu "Sedang berlangsung".

## 4. E-voting: sebelum pemilu berikutnya

Pemilu Kahim berikutnya sekitar satu tahun lagi. Kerjakan jauh sebelumnya:

- **Korelasi waktu:** rancangan menyimpan `voted_at` (pada pemilih) dan `cast_at` (pada suara). Pada pemilih sedikit, selisih waktu bisa dipakai menebak siapa memilih siapa. Kasarkan salah satunya (misalnya ke jam atau hari) atau hapus, dan acak urutan suara saat ekspor. Ini temuan dari dokumen rencana, belum dari kode; verifikasi di kode sebelum bertindak.
- **Dua orang untuk dua kunci:** administrator pemilu dan penguji hasil berbeda orang, dan keduanya bukan calon.
- **Gladi bersih** dua bulan sebelum hari H dengan DPT uji, termasuk pengiriman email nyata dan skenario token kedaluwarsa.
- **Ekspor audit** disimpan oleh panitia/dosen pembina; hasil resmi diumumkan di portal setelah sesi ditutup (portal lama menulis "Dirahasiakan" tanpa penjelasan).
- Logika pemilu **tidak disentuh** selama redesain. Perubahan apa pun lewat PRD sendiri dengan tes yang diperluas.

## 5. Pengembangan setelah tayang (urut manfaat, belum dikerjakan)

1. **Pendaftaran kegiatan/oprec di situs** (formulir sederhana → pesan di panel admin). Hanya bila uji "5 mahasiswa" menunjukkan orang kesulitan mendaftar lewat tautan eksternal.
2. **Seksi Prestasi** (memakai kegiatan berkategori prestasi, tanpa tabel baru) untuk kredibilitas di mata dosen dan mitra.
3. **Merchandise statis** begitu data item tersedia (config, tanpa checkout).
4. **Gambar OG per kegiatan** agar pratinjau tautan di WhatsApp/Instagram menarik.
5. **Analitik yang menghormati privasi** (tanpa cookie pelacak, tanpa data pribadi) untuk mengukur halaman yang benar-benar dibuka. Putuskan setelah ada kebutuhan nyata.
6. Restyle panel admin (token lama masih alias sementara).
7. Ditunda sampai ada aset resmi: maskot.

## 6. Yang sengaja tidak direkomendasikan

- Menambah framework JS, pustaka animasi, atau CMS pihak ketiga. Situs ini informasi untuk organisasi kecil; stack sekarang cukup.
- Tema per-kabinet otomatis, PWA, pencarian, komentar, akun anggota. Tidak ada kebutuhan yang terbukti.
- Menayangkan tanpa menyelesaikan butir 1–4 di bagian 1.

## 7. Uji penerimaan manusia (5 menit, tiap fase)

Agen tidak bisa menggantikan mata pemilik. Setelah tiap fase:
1. `php artisan serve`, buka `/_styleguide` (dan halaman fase itu).
2. Toggle tema, muat ulang: tema bertahan, tidak berkedip.
3. Perkecil jendela ke ±360 px: tidak ada scroll samping, menu bisa dibuka dan ditutup.
4. Tab dari awal halaman: tautan lompat muncul, fokus selalu terlihat.
5. Cari NPM, nomor WA, nominal RAB dengan fitur cari browser (`Ctrl+F`) di halaman publik: harus tidak ada.
6. Bandingkan dengan Instagram: nama, tanggal, dan angka konsisten.
