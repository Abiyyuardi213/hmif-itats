@extends('layouts.app')

@section('title', 'Struktur Organisasi HMIF ITATS — Kepengurusan & Divisi')
@section('meta_description', 'Susunan Badan Pengurus Harian dan pengurus divisi HMIF ITATS per periode kepengurusan.')

@section('content')
    <section class="bg-band text-band-text py-14 border-b border-border bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-wrap items-end justify-between gap-6">
            <div>
                <div class="font-mono text-xs text-on-band uppercase tracking-wider">Kepengurusan Resmi</div>
                <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Struktur Organisasi</h1>
                @if($selectedPeriod)
                    <p class="mt-2 text-band-muted">
                        Periode {{ $selectedPeriod->name }} &mdash; {{ $selectedPeriod->cabinet_name }}
                        @if($selectedPeriod->is_active)
                            <span class="ml-2 inline-block rounded-full bg-primary px-2.5 py-0.5 font-mono text-xs font-semibold text-on-primary">AKTIF</span>
                        @else
                            <span class="ml-2 inline-block rounded-full border border-border px-2.5 py-0.5 font-mono text-xs text-band-muted">ARSIP</span>
                        @endif
                    </p>
                @endif
            </div>

            @if($allPeriods->count() > 1)
                <form method="GET" action="{{ route('struktur') }}" class="flex items-center gap-2">
                    <label for="periode" class="text-xs font-mono text-band-muted">Periode:</label>
                    <select id="periode" name="periode" onchange="this.form.submit()"
                        class="rounded-lg border border-border-input bg-surface px-3 py-2 text-sm text-text">
                        @foreach($allPeriods as $periodItem)
                            <option value="{{ $periodItem->name }}" @selected($selectedPeriod && $selectedPeriod->id === $periodItem->id)>
                                {{ $periodItem->name }} ({{ $periodItem->cabinet_name }})
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </section>

    <section class="py-14 bg-white border-b border-line">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="font-mono text-xs font-semibold uppercase tracking-wider text-brand-600">01 // Inti</div>
                <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Badan Pengurus Harian</h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($coreMembers as $member)
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
                    </div>
                @empty
                    <p class="text-sm text-ink-500 col-span-4">Data pengurus inti untuk periode ini belum ditambahkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-14 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="font-mono text-xs font-semibold uppercase tracking-wider text-link">02 // Bidang Kerja</div>
                <h2 class="font-display text-2xl font-bold text-ink-950 mt-1">Pengurus Divisi</h2>
            </div>

            <div class="space-y-8">
                @forelse($divisions as $division)
                    <div class="rounded-2xl border border-line bg-white p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-line">
                            <div>
                                <span class="font-mono text-xs font-semibold text-brand-700 bg-brand-50 px-2.5 py-1 rounded">
                                    {{ $division->code }}
                                </span>
                                <h3 class="font-display text-xl font-bold text-ink-950 mt-2">{{ $division->name }}</h3>
                                <p class="text-sm text-ink-500 mt-1">{{ $division->short_description }}</p>
                            </div>
                            <a href="{{ route('divisi.show', $division->slug) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                                Lihat proker divisi &rarr;
                            </a>
                        </div>

                        <div class="mt-5 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @forelse($division->members as $member)
                                <div class="flex items-center gap-3.5 rounded-xl border border-line bg-surface p-3.5">
                                    @if($member->photo_path)
                                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                                            class="h-12 w-12 rounded-full object-cover flex-shrink-0 bg-surface-raised border border-line">
                                    @else
                                        <svg viewBox="0 0 160 160" fill="none" aria-hidden="true" class="h-12 w-12 rounded-full flex-shrink-0 bg-surface-raised border border-line text-text-muted">
                                            <circle cx="80" cy="60" r="24" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" />
                                            <path d="M40 132C44 108 60 98 80 98C100 98 116 108 120 132" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" stroke-linecap="round" />
                                        </svg>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-ink-950 truncate">{{ $member->name }}</div>
                                        <div class="text-xs text-ink-500 truncate">{{ $member->position }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-ink-500 col-span-4">Anggota divisi sedang dalam proses pembaruan data oleh pengurus.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-ink-500">Belum ada divisi terdaftar untuk periode ini.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
