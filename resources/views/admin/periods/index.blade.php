@extends('layouts.admin')

@section('title', 'Periode & Kabinet')
@section('page_title', 'Manajemen Periode & Kabinet')
@section('page_subtitle', 'Atur periode aktif, arsip periode lama, visi, dan misi.')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-5">
            <form method="POST" action="{{ route('admin.periods.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Periode Baru</h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Tahun Periode</label>
                        <input type="text" name="name" placeholder="2027/2028" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Nama Kabinet</label>
                        <input type="text" name="cabinet_name" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Tagline</label>
                    <input type="text" name="tagline" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Mulai</label>
                        <input type="date" name="starts_at" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Selesai</label>
                        <input type="date" name="ends_at" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Visi</label>
                    <textarea name="vision" rows="3" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Misi (satu poin per baris)</label>
                    <textarea name="mission_text" rows="4" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-line">
                    <span>Jadikan periode aktif sekarang</span>
                </label>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                    Simpan Periode
                </button>
            </form>
        </div>

        <div class="lg:col-span-7 space-y-4">
            @foreach($periods as $period)
                <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-display text-lg font-bold text-ink-950">{{ $period->name }}</span>
                            <span class="text-sm text-ink-600">&mdash; {{ $period->cabinet_name }}</span>
                            @if($period->is_active)
                                <span class="rounded-full border border-success bg-success-surface px-2.5 py-0.5 font-mono text-xs font-semibold text-success">AKTIF</span>
                            @endif
                        </div>
                        <div class="mt-1 font-mono text-xs text-ink-500">
                            {{ $period->divisions_count }} divisi &middot; {{ $period->board_members_count }} pengurus &middot; {{ $period->work_programs_count }} proker
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(! $period->is_active)
                            <form method="POST" action="{{ route('admin.periods.activate', $period) }}">
                                @csrf
                                <button type="submit" class="rounded-lg border border-success bg-success-surface px-3 py-1.5 text-xs font-semibold text-success hover:bg-bg-soft">
                                    Aktifkan
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.periods.edit', $period) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold hover:bg-bg">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
