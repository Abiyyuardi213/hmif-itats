@extends('layouts.admin')

@section('title', 'Pengumuman')
@section('page_title', 'Manajemen Pengumuman')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-5">
            <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Terbitkan Pengumuman</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Judul</label>
                    <input type="text" name="title" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Kategori</label>
                        <input type="text" name="category" placeholder="Rekrutmen / Tata Kelola" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Periode</label>
                        <select name="period_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                            <option value="">-- Umum --</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Tanggal Terbit (opsional)</label>
                    <input type="datetime-local" name="published_at" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Ringkasan</label>
                    <textarea name="excerpt" rows="2" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Isi Pengumuman</label>
                    <textarea name="content" rows="5" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div class="flex flex-wrap gap-4 text-sm">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_pinned" value="1" class="rounded border-line">
                        <span>Sematkan di atas</span>
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="is_published" value="1" checked class="rounded border-line">
                        <span>Publikasikan</span>
                    </label>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Pengumuman</button>
            </form>
        </div>

        <div class="lg:col-span-7 space-y-3">
            @foreach($announcements as $item)
                <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-mono text-xs text-brand-700 font-semibold">
                            {{ $item->category }} &middot; {{ optional($item->published_at)->translatedFormat('d M Y H:i') }}
                            @if($item->is_pinned) &middot; PINNED @endif
                            @if(! $item->is_published) &middot; DRAFT @endif
                        </div>
                        <div class="font-display font-bold text-ink-950 mt-0.5">{{ $item->title }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.pengumuman.edit', $item) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Edit</a>
                        <form method="POST" action="{{ route('admin.pengumuman.destroy', $item) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
