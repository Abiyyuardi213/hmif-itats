@extends('layouts.admin')

@section('title', 'Edit Pengumuman')
@section('page_title', 'Edit Pengumuman')

@section('content')
    <form method="POST" action="{{ route('admin.pengumuman.update', $pengumuman) }}" class="max-w-2xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-xs font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $pengumuman->title) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $pengumuman->category) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Periode</label>
                <select name="period_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    <option value="">-- Umum --</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" @selected($pengumuman->period_id === $period->id)>{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Tanggal Terbit</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', $pengumuman->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Ringkasan</label>
            <textarea name="excerpt" rows="2" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('excerpt', $pengumuman->excerpt) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Isi Pengumuman</label>
            <textarea name="content" rows="6" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('content', $pengumuman->content) }}</textarea>
        </div>
        <div class="flex gap-4 text-sm">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $pengumuman->is_pinned)) class="rounded border-line">
                <span>Sematkan</span>
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $pengumuman->is_published)) class="rounded border-line">
                <span>Publikasikan</span>
            </label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.pengumuman.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
