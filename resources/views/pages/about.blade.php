@extends('layouts.app')

@section('title', 'Tentang HMIF ITATS — Profil, Visi & Misi Organisasi')
@section('meta_description', 'Profil resmi, visi, misi, dan jajaran pimpinan inti Himpunan Mahasiswa Teknik Informatika Institut Teknologi Adhi Tama Surabaya.')

@section('content')
    <section class="bg-band text-band-text py-14 border-b border-border bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-on-band uppercase tracking-wider">Profil Organisasi</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Tentang HMIF ITATS</h1>
            <p class="mt-3 text-band-muted max-w-2xl">
                Himpunan Mahasiswa Teknik Informatika — Institut Teknologi Adhi Tama Surabaya.
                Ruang bertumbuh bagi mahasiswa informatika dalam riset, rekayasa perangkat lunak, dan pengabdian kampus.
            </p>
        </div>
    </section>

    <section class="py-14 bg-white border-b border-line">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6">
                <img src="{{ asset('image/hmif-webinar.jpg') }}" alt="Kegiatan Akademik HMIF ITATS" class="w-full h-80 object-cover rounded-2xl border border-line shadow-sm">
            </div>
            <div class="lg:col-span-6 space-y-4">
                <div class="font-mono text-xs font-semibold uppercase tracking-wider text-brand-600">
                    @if($period)
                        Periode Aktif {{ $period->name }} &middot; {{ $period->cabinet_name }}
                    @else
                        HMIF ITATS
                    @endif
                </div>
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-ink-950">Wadah Aspirasi &amp; Inovasi Informatika</h2>
                <p class="text-ink-700 leading-relaxed">
                    HMIF ITATS merupakan organisasi kemahasiswaan tingkat program studi S-1 Teknik Informatika yang berperan menjembatani aspirasi akademik, membangun budaya rekayasa teknologi, serta membina soft-skill kepemimpinan mahasiswa.
                </p>
                <p class="text-ink-700 leading-relaxed">
                    Seluruh data kepengurusan, program kerja divisi, agenda kegiatan, serta layanan pemilu dikelola terpusat oleh pengurus resmi dan tim Divisi Pengembangan &amp; Sistem Digital.
                </p>
            </div>
        </div>
    </section>

    @if($period)
        <section class="py-14 bg-surface border-b border-line">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <div class="font-mono text-xs font-semibold uppercase tracking-wider text-brand-600">Arah Gerak Kabinet</div>
                    <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Visi &amp; Misi {{ $period->cabinet_name }}</h2>
                </div>

                <div class="grid md:grid-cols-12 gap-6">
                    <div class="md:col-span-5 rounded-2xl border border-line bg-white p-6">
                        <div class="font-mono text-xs uppercase text-link font-semibold mb-2">Visi</div>
                        <p class="text-ink-900 leading-relaxed font-medium">{{ $period->vision }}</p>
                    </div>
                    <div class="md:col-span-7 rounded-2xl border border-line bg-white p-6">
                        <div class="font-mono text-xs uppercase text-brand-600 font-semibold mb-3">Misi</div>
                        <ol class="space-y-3 text-sm text-ink-700">
                            @foreach((array) $period->mission as $index => $missionItem)
                                <li class="flex gap-3">
                                    <span class="font-mono text-xs font-bold text-brand-700 bg-brand-50 h-6 w-6 rounded-md flex items-center justify-center flex-shrink-0">
                                        0{{ $index + 1 }}
                                    </span>
                                    <span class="leading-relaxed">{{ $missionItem }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-14 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <div class="font-mono text-xs font-semibold uppercase tracking-wider text-brand-600">Pimpinan Inti</div>
                    <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Badan Pengurus Harian</h2>
                </div>
                <a href="{{ route('struktur') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                    Lihat struktur lengkap &rarr;
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($coreMembers as $member)
                    <div class="rounded-2xl border border-line bg-surface p-6 text-center">
                        @if($member->photo_path)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                class="mx-auto h-24 w-24 rounded-full object-cover border-2 border-border bg-surface-raised">
                        @else
                            <svg viewBox="0 0 160 160" fill="none" aria-hidden="true" class="mx-auto h-24 w-24 rounded-full border-2 border-border bg-surface-raised text-text-muted">
                                <circle cx="80" cy="60" r="24" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" />
                                <path d="M40 132C44 108 60 98 80 98C100 98 116 108 120 132" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" stroke-linecap="round" />
                            </svg>
                        @endif
                        <h3 class="mt-4 font-display text-base font-bold text-ink-950">{{ $member->name }}</h3>
                        <p class="mt-1 text-sm font-medium text-brand-700">{{ $member->position }}</p>
                        @if($period)
                            <p class="mt-1 font-mono text-xs text-ink-500">Periode {{ $period->name }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
