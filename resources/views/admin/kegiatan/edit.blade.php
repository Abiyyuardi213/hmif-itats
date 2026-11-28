@extends('layouts.admin')

@section('title', 'Edit Kegiatan')
@section('page_title', 'Edit Kegiatan')

@section('content')
    <form method="POST" action="{{ route('admin.kegiatan.update', $kegiatan) }}" enctype="multipart/form-data" class="max-w-2xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Periode</label>
                <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" @selected($kegiatan->period_id === $period->id)>{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Terkait Proker</label>
                <select name="work_program_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    <option value="">-- Tidak terikat --</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" @selected($kegiatan->work_program_id === $program->id)>{{ $program->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Judul Kegiatan</label>
            <input type="text" name="title" value="{{ old('title', $kegiatan->title) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $kegiatan->category) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Kegiatan</label>
                <input type="date" name="event_date" value="{{ old('event_date', $kegiatan->event_date?->format('Y-m-d')) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $kegiatan->location) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Ringkasan</label>
            <textarea name="summary" rows="2" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('summary', $kegiatan->summary) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Konten Lengkap</label>
            <textarea name="content" rows="5" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('content', $kegiatan->content) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Link Pendaftaran</label>
            <input type="url" name="registration_url" value="{{ old('registration_url', $kegiatan->registration_url) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Ganti Foto Sampul (opsional)</label>
            <input type="file" name="cover" accept="image/*" class="w-full text-xs">
        </div>
        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $kegiatan->is_published)) class="rounded border-line">
            <span>Publikasikan</span>
        </label>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
