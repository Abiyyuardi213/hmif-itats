@extends('layouts.app')

@section('title', $division->name.' — Divisi HMIF ITATS')
@section('meta_description', $division->short_description)

@section('content')
    <section class="bg-ink-950 text-white py-14 border-b border-slate-800 bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('divisi.index') }}" class="text-xs font-mono text-cyan-400 hover:underline">&larr; Semua Divisi</a>
            <div class="mt-3 font-mono text-xs text-slate-400">{{ $division->code }}</div>
            <h1 class="mt-1 font-display text-3xl sm:text-4xl font-extrabold">{{ $division->name }}</h1>
            <p class="mt-3 text-slate-300 max-w-2xl">{{ $division->description ?? $division->short_description }}</p>
        </div>
    </section>

    <section class="py-14 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5">
                <h2 class="font-display text-xl font-bold text-ink-950 mb-4">Pengurus Bidang</h2>
                <div class="space-y-3">
                    @forelse($division->members as $member)
                        <div class="flex items-center gap-3.5 rounded-xl border border-line bg-white p-4">
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="h-12 w-12 rounded-full object-cover border border-line">
                            <div>
                                <div class="font-semibold text-sm text-ink-950">{{ $member->name }}</div>
                                <div class="text-xs text-ink-500">{{ $member->position }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-line bg-white p-5 text-sm text-ink-500">
                            Belum ada pengurus tercatat pada divisi ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-7">
                <h2 class="font-display text-xl font-bold text-ink-950 mb-4">Program Kerja Divisi</h2>
                <div class="space-y-4">
                    @forelse($division->workPrograms as $program)
                        <div class="rounded-xl border border-line bg-white p-5">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <h3 class="font-display text-base font-bold text-ink-950">{{ $program->title }}</h3>
                                <span class="font-mono text-xs px-2.5 py-1 rounded-full bg-slate-100 text-ink-700 font-semibold">
                                    {{ $program->statusLabel() }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-ink-600 leading-relaxed">{{ $program->description }}</p>
                            <div class="mt-3 font-mono text-xs text-ink-500 flex flex-wrap gap-4">
                                @if($program->target_date)
                                    <span>Target: {{ $program->target_date->translatedFormat('d M Y') }}</span>
                                @endif
                                @if($program->realized_at)
                                    <span>Terlaksana: {{ $program->realized_at->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-line bg-white p-5 text-sm text-ink-500">
                            Belum ada program kerja untuk divisi ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
