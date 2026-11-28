@extends('layouts.admin')

@section('title', 'Manajemen Pengurus')
@section('page_title', 'Pengurus HMIF ITATS')
@section('page_subtitle', 'Sesuai prinsip perlindungan data pribadi (UU PDP), NPM tidak dikumpulkan atau ditampilkan ke publik.')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Pengurus</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Periode</label>
                    <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Divisi (kosongkan jika BPH Inti)</label>
                    <select name="division_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        <option value="">-- Badan Pengurus Harian (BPH) --</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->period->name }} &middot; {{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Jabatan</label>
                        <input type="text" name="position" placeholder="Ketua HMIF / Staf" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Urutan</label>
                        <input type="number" name="sort_order" value="1" min="0" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_core" value="1" class="rounded border-line">
                    <span>Termasuk BPH Inti</span>
                </label>
                <div>
                    <label class="block text-xs font-semibold mb-1">Foto Profil (opsional, maks 2 MB)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Pengurus</button>
            </form>
        </div>

        <div class="lg:col-span-8 space-y-3">
            @foreach($members as $member)
                <div class="rounded-2xl border border-line bg-white p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        @if($member->photo_path)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="h-12 w-12 rounded-full object-cover border border-line">
                        @else
                            <svg viewBox="0 0 160 160" fill="none" aria-hidden="true" class="h-12 w-12 rounded-full border border-line bg-surface-raised text-text-muted shrink-0">
                                <circle cx="80" cy="60" r="24" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" />
                                <path d="M40 132C44 108 60 98 80 98C100 98 116 108 120 132" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.55" stroke-width="4" stroke-linecap="round" />
                            </svg>
                        @endif
                        <div>
                            <div class="font-display font-bold text-ink-950">{{ $member->name }}</div>
                            <div class="text-xs text-ink-500">
                                {{ $member->position }} &middot;
                                {{ $member->division?->name ?? 'BPH Inti' }} &middot;
                                Periode {{ $member->period->name }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.members.edit', $member) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Edit</a>
                        <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Hapus pengurus ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-danger bg-danger-surface px-3 py-1.5 text-xs font-semibold text-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
