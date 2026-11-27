@extends('layouts.app')

@section('title', 'HMIF ITATS — Portal Resmi Himpunan Mahasiswa Teknik Informatika ITATS')
@section('meta_description', 'Portal resmi Himpunan Mahasiswa Teknik Informatika Institut Teknologi Adhi Tama Surabaya: informasi program kerja, enam divisi, kegiatan, dan pengumuman resmi.')

@push('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'HMIF ITATS',
    'alternateName' => 'Himpunan Mahasiswa Teknik Informatika ITATS',
    'url' => url('/'),
    'logo' => asset('image/hima.png'),
    'email' => $orgSettings['email'] ?? 'hmif@itats.ac.id',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $orgSettings['address'] ?? 'Jl. Arief Rachman Hakim No. 100',
        'addressLocality' => 'Surabaya',
        'postalCode' => '60117',
        'addressCountry' => 'ID',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-ink-950 text-white">
        <div class="absolute inset-0 bg-tech-grid opacity-80"></div>
        <div class="absolute -top-32 right-0 h-96 w-96 rounded-full bg-brand-600/25 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex flex-wrap items-center gap-2 rounded-full border border-slate-700 bg-slate-900/80 px-3.5 py-1.5 text-xs font-mono text-cyan-300">
                        <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                        @if($period)
                            <span>PERIODE {{ $period->name }} &middot; {{ strtoupper($period->cabinet_name) }}</span>
                        @else
                            <span>HMIF ITATS SURABAYA</span>
                        @endif
                    </div>

                    <h1 class="font-display text-3xl sm:text-5xl font-extrabold tracking-tight leading-[1.12] text-white">
                        {{ $orgSettings['hero_headline'] ?? 'Wadah Kolaborasi & Rekayasa Teknologi Mahasiswa Informatika ITATS' }}
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl">
                        {{ $orgSettings['hero_subtitle'] ?? 'Portal resmi program kerja, informasi kegiatan, arsip kepengurusan, dan layanan digital HMIF Institut Teknologi Adhi Tama Surabaya.' }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3.5 pt-2">
                        <a href="{{ route('proker.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/30 hover:bg-brand-500 transition">
                            <span>Lihat Program Kerja</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                        <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900/70 px-5 py-3 text-sm font-semibold text-slate-100 hover:border-cyan-500 hover:text-white transition">
                            Jelajahi Kegiatan
                        </a>
                    </div>

                    @if($openElection)
                        <div class="rounded-xl border border-emerald-500/40 bg-emerald-950/60 p-4 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <div class="text-xs font-mono uppercase tracking-wider text-emerald-300">Pemilu Sedang Berlangsung</div>
                                <div class="text-sm font-semibold text-white">{{ $openElection->title }}</div>
                            </div>
                            <a href="{{ route('pemilu.index') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-xs font-bold text-slate-950 hover:bg-emerald-400 transition">
                                Gunakan Hak Pilih &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-5">
                    <div class="relative rounded-2xl border border-slate-700/80 bg-slate-900/90 p-2.5 shadow-2xl">
                        <img src="{{ asset('image/hmif-pmo.jpg') }}" alt="Pelatihan Manajemen Organisasi HMIF ITATS"
                            class="w-full h-72 sm:h-88 object-cover rounded-xl">
                        <div class="mt-3 px-2 pb-1 flex items-center justify-between text-xs font-mono text-slate-400">
                            <span>HMIF // ITATS SURABAYA</span>
                            <span>{{ $stats['divisions'] }} DIVISI AKTIF</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Live Computed Metrics (Matches Database 1:1) --}}
    <section class="border-b border-line bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="border-l-2 border-brand-600 pl-4">
                    <div class="font-mono text-xs uppercase text-ink-500">Divisi Aktif</div>
                    <div class="font-display text-3xl font-extrabold text-ink-950 mt-1">{{ $stats['divisions'] }}</div>
                </div>
                <div class="border-l-2 border-cyan-600 pl-4">
                    <div class="font-mono text-xs uppercase text-ink-500">Program Kerja</div>
                    <div class="font-display text-3xl font-extrabold text-ink-950 mt-1">{{ $stats['programs'] }}</div>
                </div>
                <div class="border-l-2 border-emerald-600 pl-4">
                    <div class="font-mono text-xs uppercase text-ink-500">Proker Terlaksana</div>
                    <div class="font-display text-3xl font-extrabold text-ink-950 mt-1">{{ $stats['completed_programs'] }}</div>
                </div>
                <div class="border-l-2 border-slate-800 pl-4">
                    <div class="font-mono text-xs uppercase text-ink-500">Kegiatan Terdokumentasi</div>
                    <div class="font-display text-3xl font-extrabold text-ink-950 mt-1">{{ $stats['activities'] }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Divisions Overview --}}
    <section class="py-16 bg-light-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
                <div>
                    <div class="font-mono text-xs uppercase tracking-wider text-brand-600 font-semibold">Struktur Bidang Kerja</div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-ink-950 mt-1">Enam Divisi HMIF ITATS</h2>
                </div>
                <a href="{{ route('divisi.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                    Lihat semua divisi &rarr;
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($divisions as $division)
                    <a href="{{ route('divisi.show', $division->slug) }}"
                        class="group rounded-2xl border border-line bg-white p-6 hover:border-brand-500 hover:shadow-lg hover:shadow-slate-900/5 transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-mono text-xs font-semibold text-brand-700 bg-brand-50 px-2.5 py-1 rounded-md">
                                    {{ $division->code }}
                                </span>
                                <span class="font-mono text-xs text-ink-500">
                                    {{ $division->work_programs_count }} Proker
                                </span>
                            </div>
                            <h3 class="font-display text-lg font-bold text-ink-950 group-hover:text-brand-600 transition">
                                {{ $division->name }}
                            </h3>
                            <p class="mt-2 text-sm text-ink-500 leading-relaxed">
                                {{ $division->short_description }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-line text-xs font-semibold text-ink-700 group-hover:text-brand-600">
                            Detail bidang &rarr;
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Latest Activities & Announcements --}}
    <section class="py-16 bg-white border-t border-line">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-10">
                <div class="lg:col-span-8">
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <div class="font-mono text-xs uppercase tracking-wider text-cyan-600 font-semibold">Dokumentasi Agenda</div>
                            <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Kegiatan Terbaru</h2>
                        </div>
                        <a href="{{ route('kegiatan.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                            Semua kegiatan &rarr;
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-5">
                        @forelse($latestActivities as $activity)
                            <article class="rounded-2xl border border-line bg-surface overflow-hidden flex flex-col hover:border-brand-500 transition">
                                <img src="{{ $activity->cover_url }}" alt="{{ $activity->title }}" class="h-40 w-full object-cover">
                                <div class="p-4 flex-1 flex flex-col">
                                    <div class="flex items-center justify-between gap-2 text-[11px] font-mono text-ink-500">
                                        <span class="text-brand-700 font-semibold">{{ $activity->category }}</span>
                                        <time datetime="{{ $activity->event_date->format('Y-m-d') }}">
                                            {{ $activity->event_date->translatedFormat('d M Y') }}
                                        </time>
                                    </div>
                                    <h3 class="mt-2 font-display text-base font-bold text-ink-950 line-clamp-2">
                                        <a href="{{ route('kegiatan.show', $activity->slug) }}" class="hover:text-brand-600">
                                            {{ $activity->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-xs text-ink-500 line-clamp-3 flex-1">{{ $activity->summary }}</p>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-ink-500 col-span-3">Belum ada kegiatan yang dipublikasikan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <div class="font-mono text-xs uppercase tracking-wider text-brand-600 font-semibold">Informasi Resmi</div>
                            <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Pengumuman</h2>
                        </div>
                        <a href="{{ route('pengumuman.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                            Arsip &rarr;
                        </a>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($latestAnnouncements as $announcement)
                            <a href="{{ route('pengumuman.show', $announcement->slug) }}"
                                class="block rounded-xl border border-line bg-surface p-4 hover:border-brand-500 hover:bg-white transition">
                                <div class="flex items-center justify-between gap-2 text-[11px] font-mono text-ink-500">
                                    <span class="rounded bg-slate-200/80 px-2 py-0.5 text-ink-900 font-semibold">
                                        {{ $announcement->category }}
                                    </span>
                                    <span>{{ optional($announcement->published_at)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="mt-2 font-display text-sm font-bold text-ink-950 leading-snug">
                                    {{ $announcement->title }}
                                </h3>
                                <p class="mt-1 text-xs text-ink-500 line-clamp-2">{{ $announcement->excerpt }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-ink-500">Belum ada pengumuman terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
