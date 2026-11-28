@extends('layouts.admin')

@section('title', 'Manajemen Divisi')
@section('page_title', 'Divisi & Bidang Kerja')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <form method="POST" action="{{ route('admin.divisions.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Divisi</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Periode</label>
                    <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->name }} ({{ $period->cabinet_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Kode</label>
                        <input type="text" name="code" placeholder="DIV-07" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Urutan</label>
                        <input type="number" name="sort_order" value="1" min="0" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Nama Divisi</label>
                    <input type="text" name="name" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Ringkasan</label>
                    <input type="text" name="short_description" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Deskripsi Lengkap</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Divisi</button>
            </form>
        </div>

        <div class="lg:col-span-8 space-y-3">
            @foreach($divisions as $division)
                <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-mono text-xs text-brand-700 font-semibold">{{ $division->code }} &middot; Periode {{ $division->period->name }}</div>
                        <div class="font-display text-base font-bold text-ink-950">{{ $division->name }}</div>
                        <div class="text-xs text-ink-500 mt-1">{{ $division->members_count }} anggota &middot; {{ $division->work_programs_count }} proker</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.divisions.edit', $division) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Edit</a>
                        <form method="POST" action="{{ route('admin.divisions.destroy', $division) }}" onsubmit="return confirm('Hapus divisi ini?')">
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
