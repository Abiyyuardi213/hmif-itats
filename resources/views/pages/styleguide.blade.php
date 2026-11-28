@extends('layouts.app')

@section('title', 'Styleguide Desain Sistem — HMIF ITATS')
@section('meta_description', 'Galeri token warna, tipografi, dan komponen UI HMIF ITATS untuk verifikasi tema terang dan gelap.')

@section('content')
    <div class="bg-bg-soft border-b border-border py-12 sm:py-16">
        <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-[68ch] space-y-3">
                <h1
                    class="font-display font-bold text-text leading-[1.05] tracking-[-0.025em]"
                    style="font-size: clamp(2.25rem, 1rem + 4.5vw, 4rem);"
                >
                    Galeri komponen HMIF ITATS
                </h1>
                <p class="font-editorial text-text-muted" style="font-size: clamp(1.25rem, 1rem + 1.2vw, 1.75rem);">
                    Kabinet Asakusa &middot; 2026/2027
                </p>
                <p class="text-base text-text-muted leading-relaxed">
                    Halaman khusus environment lokal untuk memverifikasi seluruh token 3 tingkat, kontras terang/gelap, dan keutuhan 13 komponen Blade.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-button variant="primary" :href="route('kegiatan.index')">
                    <span>Tombol utama</span>
                    <x-icon name="arrow-right" size="18" />
                </x-button>
                <x-button variant="secondary" :href="route('struktur')">
                    Tombol sekunder
                </x-button>
                <x-button variant="ghost" :href="route('about')">
                    Tombol hantu
                </x-button>
                <x-button variant="primary" :loading="true">
                    Memproses...
                </x-button>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 space-y-16 py-12 sm:py-16">
        <section aria-labelledby="sg-tokens" class="space-y-6">
            <x-section-header id="sg-tokens" title="Token semantik" />

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-sm">
                <div class="rounded-[20px] border border-border bg-bg p-4 space-y-2">
                    <div class="h-10 rounded-[12px] border border-border bg-bg"></div>
                    <div class="font-mono text-xs text-text">--bg</div>
                </div>
                <div class="rounded-[20px] border border-border bg-bg-soft p-4 space-y-2">
                    <div class="h-10 rounded-[12px] border border-border bg-bg-soft"></div>
                    <div class="font-mono text-xs text-text">--bg-soft</div>
                </div>
                <div class="rounded-[20px] border border-border bg-surface-raised p-4 shadow-card space-y-2">
                    <div class="h-10 rounded-[12px] border border-border bg-surface-raised"></div>
                    <div class="font-mono text-xs text-text">--surface-raised</div>
                </div>
                <div class="rounded-[20px] border border-border bg-surface p-4 space-y-2">
                    <div class="h-10 rounded-[12px] bg-primary flex items-center justify-center font-semibold text-on-primary text-xs">
                        Teks
                    </div>
                    <div class="font-mono text-xs text-text">--primary</div>
                </div>
                <div class="rounded-[20px] border border-border bg-surface p-4 space-y-2">
                    <div class="h-10 rounded-[12px] bg-band flex items-center justify-center font-semibold text-on-band text-xs">
                        Pita
                    </div>
                    <div class="font-mono text-xs text-text">--band / --on-band</div>
                </div>
                <div class="rounded-[20px] border border-border bg-surface p-4 space-y-2">
                    <div class="h-10 rounded-[12px] border-2 border-border-input flex items-center justify-center text-link text-xs font-semibold">
                        Tautan
                    </div>
                    <div class="font-mono text-xs text-text">--link / --border-input</div>
                </div>
            </div>
        </section>

        <section aria-labelledby="sg-type" class="space-y-6">
            <x-section-header id="sg-type" title="Tipografi dan status" />

            <div class="rounded-[20px] border border-border bg-surface-raised p-6 shadow-card space-y-4">
                <p class="font-display font-extrabold text-text leading-[0.95] tracking-[-0.03em]" style="font-size: clamp(2.75rem, 1rem + 8vw, 4.5rem);">
                    Bertumbuh. Berjejaring. Berkarya.
                </p>
                <p class="font-editorial text-text-muted" style="font-size: clamp(1.25rem, 1rem + 1.2vw, 1.75rem);">
                    Editorial italic Fraunces untuk nama kabinet dan kutipan.
                </p>
                <p class="text-base text-text max-w-[68ch]">
                    Instrument Sans untuk keterbacaan teks panjang maksimal enam puluh delapan karakter dengan ritme spasi yang tenang dan jelas.
                </p>
                <p class="font-mono text-sm text-text-muted">
                    wisuda-ke-73.jpg &middot; ui-monospace system stack
                </p>

                <div class="flex flex-wrap gap-2 pt-2">
                    <x-status-badge status="completed" />
                    <x-status-badge status="in_progress" />
                    <x-status-badge status="upcoming" />
                    <x-status-badge status="archive" />
                    <x-status-badge status="error" label="Ditolak" />
                </div>
            </div>
        </section>

        <section aria-labelledby="sg-strip" class="space-y-6">
            <x-section-header id="sg-strip" title="Strip statistik dan ticker" />

            <x-stat-strip :stats="[
                ['value' => 4, 'label' => 'Divisi'],
                ['value' => 34, 'label' => 'Pengurus'],
                ['value' => 0, 'label' => 'Nilai nol tersembunyi'],
                ['value' => '2026/2027', 'label' => 'Periode berjalan'],
            ]" />

            <x-ticker
                :items="[
                    ['title' => 'Musyawarah Himpunan HMIF ITATS 2026', 'url' => route('pengumuman.index')],
                    ['title' => 'Pendaftaran Kuliah Tamu Rekayasa Perangkat Lunak', 'url' => route('pengumuman.index')],
                    ['title' => 'Arsip Laporan Kerja Kabinet Sebelumnya', 'url' => route('proker.index')],
                ]"
            />
        </section>

        <section aria-labelledby="sg-cards" class="space-y-6">
            <x-section-header id="sg-cards" title="Kartu jendela dan navigasi" actionLabel="Lihat kegiatan" :actionHref="route('kegiatan.index')" />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-window-card
                    filename="hmif-wisuda72.jpg"
                    date="28 Nov 2025"
                    tilt="left"
                    :image="asset('image/hmif-wisuda72.jpg')"
                    alt="Dokumentasi prosesi pelepasan wisudawan Teknik Informatika ITATS"
                    title="Pelepasan Wisudawan Teknik Informatika"
                    summary="Apresiasi kelulusan dan silaturahmi alumni bersama pengurus HMIF ITATS."
                    :href="route('kegiatan.index')"
                >
                    <x-slot:badge>
                        <x-status-badge status="completed" />
                    </x-slot:badge>
                </x-window-card>

                <x-window-card
                    filename="hmif-pmo.jpg"
                    date="14 Mar 2026"
                    tilt="right"
                    :image="asset('image/hmif-pmo.jpg')"
                    alt="Dokumentasi kegiatan pelatihan organisasi mahasiswa HMIF ITATS"
                    title="Pengkaderan dan Pelatihan Organisasi"
                    summary="Pembekalan tata kelola himpunan bagi calon pengurus periode terbaru."
                    :href="route('kegiatan.index')"
                >
                    <x-slot:badge>
                        <x-status-badge status="in_progress" />
                    </x-slot:badge>
                </x-window-card>

                <x-now-card
                    label="Sedang berlangsung"
                    title="Musyawarah & Agenda HMIF ITATS"
                    meta="Agenda terdekat • Kampus ITATS Surabaya"
                    :url="route('kegiatan.index')"
                    cta="Lihat jadwal kegiatan"
                />
            </div>

            <x-bento-nav />
        </section>

        <section aria-labelledby="sg-org" class="space-y-6">
            <x-section-header id="sg-org" title="Pengurus, divisi, dan keadaan kosong" />

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <x-member-card name="Pengurus Inti HMIF" position="Ketua Himpunan" />
                <x-member-card name="Sekretaris Himpunan" position="Administrasi dan Arsip" />
            </div>

            <div class="border-t border-border">
                <x-division-item
                    name="Penelitian dan Pengembangan"
                    description="Riset akademik, lokakarya teknologi perangkat lunak, dan pendampingan kompetisi informatika."
                    count="Contoh baris"
                    :href="route('divisi.index')"
                />
                <x-division-item
                    name="Komunikasi dan Informasi"
                    description="Pengelolaan kanal informasi resmi, dokumentasi kegiatan, dan identitas visual himpunan."
                    count="Contoh baris"
                    :href="route('divisi.index')"
                />
            </div>

            <x-empty-state
                message="Anggota divisi ini belum ditambahkan."
                actionLabel="Lihat semua divisi"
                :actionHref="route('divisi.index')"
            />
        </section>

        <section aria-labelledby="sg-form" class="space-y-6">
            <x-section-header id="sg-form" title="Formulir dan ikon (14 SVG)" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <form method="GET" class="rounded-[20px] border border-border bg-surface-raised p-6 shadow-card space-y-4">
                    <x-form-field
                        name="sample_name"
                        label="Nama lengkap"
                        placeholder="Masukkan nama Anda"
                        hint="Nama tampil pada arsip pesan masuk sekretariat."
                        :required="true"
                    />
                    <x-form-field
                        name="sample_category"
                        label="Tujuan pesan"
                        type="select"
                        :options="['aspirasi' => 'Aspirasi mahasiswa', 'kemitraan' => 'Kerja sama dan kemitraan']"
                    />
                    <x-form-field
                        name="sample_message"
                        label="Isi pesan"
                        type="textarea"
                        placeholder="Tuliskan pertanyaan atau masukan Anda..."
                        :required="true"
                    />
                    <x-button type="submit" variant="primary">Kirim pesan</x-button>
                </form>

                <div class="rounded-[20px] border border-border bg-surface-raised p-6 shadow-card space-y-4">
                    <h3 class="font-display text-lg font-semibold text-text">Ikon inline SVG (stroke 1.75px)</h3>
                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-3">
                        @foreach(['menu', 'x', 'sun', 'moon', 'play', 'pause', 'arrow-right', 'arrow-up-right', 'check-circle', 'clock', 'calendar', 'alert-circle', 'chevron-down', 'mail'] as $iconName)
                            <div class="flex flex-col items-center justify-center gap-1.5 rounded-[12px] border border-border bg-bg p-3 text-text">
                                <x-icon :name="$iconName" size="20" />
                                <span class="font-mono text-[10px] text-text-muted truncate max-w-full">{{ $iconName }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
