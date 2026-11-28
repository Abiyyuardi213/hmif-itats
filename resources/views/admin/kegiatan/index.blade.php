@extends('layouts.admin')

@section('title', 'Kegiatan & Agenda')
@section('page_title', 'Manajemen Kegiatan')
@section('page_subtitle', 'Tanggal kegiatan tervalidasi ketat (2020–2035) dan gambar otomatis dikompresi.')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-5">
            <form method="POST" action="{{ route('admin.kegiatan.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Kegiatan</h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Periode</label>
                        <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Terkait Proker (opsional)</label>
                        <select name="work_program_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                            <option value="">-- Tidak terikat --</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Judul Kegiatan</label>
                    <input type="text" name="title" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Kategori</label>
                        <input type="text" name="category" placeholder="Akademik / Kaderisasi / Sosial" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Tanggal Kegiatan</label>
                        <input type="date" name="event_date" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Lokasi</label>
                    <input type="text" name="location" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Ringkasan Singkat</label>
                    <textarea name="summary" rows="2" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Konten Lengkap</label>
                    <textarea name="content" rows="4" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Link Pendaftaran (opsional)</label>
                    <input type="url" name="registration_url" placeholder="https://..." class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Foto Sampul (opsional, maks 3 MB)</label>
                    <input type="file" name="cover" accept="image/*" class="w-full text-xs">
                </div>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_published" value="1" checked class="rounded border-line">
                    <span>Publikasikan langsung</span>
                </label>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Kegiatan</button>
            </form>
        </div>

        <div class="lg:col-span-7 space-y-3">
            @foreach($activities as $activity)
                <div class="rounded-2xl border border-line bg-white p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <img src="{{ $activity->cover_url }}" alt="{{ $activity->title }}" class="h-16 w-24 rounded-lg object-cover border border-line flex-shrink-0">
                        <div class="min-w-0">
                            <div class="font-mono text-xs text-brand-700 font-semibold">
                                {{ $activity->category }} &middot; {{ $activity->event_date->translatedFormat('d M Y') }}
                                @if(! $activity->is_published)
                                    <span class="text-text-muted">(DRAFT)</span>
                                @endif
                            </div>
                            <div class="font-display font-bold text-ink-950 truncate">{{ $activity->title }}</div>
                            <div class="text-xs text-ink-500 truncate">{{ $activity->location ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.kegiatan.edit', $activity) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Edit</a>
                        <form method="POST" action="{{ route('admin.kegiatan.destroy', $activity) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
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
