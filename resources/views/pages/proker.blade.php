@extends('layouts.app')

@section('title', 'Program Kerja HMIF ITATS — Realisasi & Rencana Kabinet')
@section('meta_description', 'Daftar program kerja resmi HMIF ITATS beserta status pelaksanaan dan penanggung jawab divisi.')

@section('content')
    <section class="bg-ink-950 text-white py-14 border-b border-slate-800 bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-cyan-400 uppercase tracking-wider">Transparansi Kerja</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Program Kerja</h1>
            <p class="mt-2 text-slate-300 max-w-2xl">
                @if($period)
                    Daftar terpadu program kerja Periode {{ $period->name }} ({{ $period->cabinet_name }}).
                @else
                    Daftar terpadu program kerja HMIF ITATS.
                @endif
            </p>

            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl">
                <div class="rounded-xl border border-slate-800 bg-slate-900/80 p-4">
                    <div class="font-mono text-xs text-slate-400">Total Proker</div>
                    <div class="font-display text-2xl font-bold mt-1">{{ $summary['total'] }}</div>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-900/80 p-4">
                    <div class="font-mono text-xs text-emerald-300">Terlaksana</div>
                    <div class="font-display text-2xl font-bold mt-1">{{ $summary['completed'] }}</div>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-900/80 p-4">
                    <div class="font-mono text-xs text-amber-300">Berjalan</div>
                    <div class="font-display text-2xl font-bold mt-1">{{ $summary['in_progress'] }}</div>
                </div>
                <div class="rounded-xl border border-slate-800 bg-slate-900/80 p-4">
                    <div class="font-mono text-xs text-slate-300">Direncanakan</div>
                    <div class="font-display text-2xl font-bold mt-1">{{ $summary['planned'] }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('proker.index') }}" class="mb-8 flex flex-wrap items-center gap-3 rounded-2xl border border-line bg-white p-4">
                <select name="divisi" class="rounded-lg border border-line bg-surface px-3 py-2 text-sm">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->slug }}" @selected($selectedDivision === $division->slug)>
                            {{ $division->code }} — {{ $division->name }}
                        </option>
                    @endforeach
                </select>
                <select name="status" class="rounded-lg border border-line bg-surface px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\WorkProgram::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected($selectedStatus === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                    Terapkan Filter
                </button>
                @if($selectedDivision || $selectedStatus)
                    <a href="{{ route('proker.index') }}" class="text-sm font-medium text-ink-500 hover:text-ink-950">Reset</a>
                @endif
            </form>

            <div class="grid md:grid-cols-2 gap-5">
                @forelse($programs as $program)
                    @php
                        $badgeColor = match ($program->status) {
                            'completed' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'in_progress' => 'bg-amber-50 text-amber-800 border-amber-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200',
                        };
                    @endphp
                    <article class="rounded-2xl border border-line bg-white p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="font-mono text-xs text-brand-700 font-semibold">
                                    {{ $program->division->code }} &middot; {{ $program->division->name }}
                                </span>
                                <span class="font-mono text-xs px-2.5 py-1 rounded-full border font-semibold {{ $badgeColor }}">
                                    {{ $program->statusLabel() }}
                                </span>
                            </div>
                            <h2 class="mt-3 font-display text-lg font-bold text-ink-950">{{ $program->title }}</h2>
                            <p class="mt-2 text-sm text-ink-600 leading-relaxed">{{ $program->description }}</p>
                        </div>

                        <div class="mt-5 pt-4 border-t border-line flex flex-wrap items-center justify-between gap-2 text-xs font-mono text-ink-500">
                            <span>Target: {{ optional($program->target_date)->translatedFormat('d M Y') ?? 'Fleksibel' }}</span>
                            @if($program->target_participants)
                                <span>Sasaran: {{ $program->target_participants }} peserta</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 rounded-2xl border border-line bg-white p-10 text-center text-sm text-ink-500">
                        Tidak ada program kerja yang cocok dengan filter yang dipilih.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
