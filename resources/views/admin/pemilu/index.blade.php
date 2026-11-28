@extends('layouts.admin')

@section('title', 'E-Voting & DPT')
@section('page_title', 'Manajemen Pemilu & E-Voting')
@section('page_subtitle', 'Kelola jadwal pemilu, kandidat, DPT, serta ekspor berita acara audit untuk panitia & dosen pembina.')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <form method="POST" action="{{ route('admin.pemilu.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Buat Sesi Pemilu Baru</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Periode</label>
                    <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->name }} ({{ $period->cabinet_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Judul Pemilu</label>
                    <input type="text" name="title" placeholder="Pemilu Raya HMIF 2027/2028" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Deskripsi</label>
                    <textarea name="description" rows="2" class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Waktu Mulai</label>
                    <input type="datetime-local" name="starts_at" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Waktu Selesai</label>
                    <input type="datetime-local" name="ends_at" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Draft Pemilu</button>
            </form>
        </div>

        <div class="lg:col-span-8 space-y-3">
            @foreach($elections as $election)
                <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-mono text-xs text-brand-700 font-semibold">
                            {{ strtoupper($election->statusLabel()) }} &middot; Periode {{ $election->period->name }}
                        </div>
                        <div class="font-display text-lg font-bold text-ink-950">{{ $election->title }}</div>
                        <div class="text-xs text-ink-500 mt-1">
                            {{ $election->candidates_count }} kandidat &middot; {{ $election->eligible_voters_count }} DPT &middot; {{ $election->votes_count }} suara masuk
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.pemilu.show', $election) }}" class="rounded-lg bg-ink-950 px-3.5 py-2 text-xs font-semibold text-white">
                            Kelola &amp; Audit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
