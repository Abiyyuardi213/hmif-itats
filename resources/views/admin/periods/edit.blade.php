@extends('layouts.admin')

@section('title', 'Edit Periode')
@section('page_title', 'Edit Periode '.$period->name)

@section('content')
    <form method="POST" action="{{ route('admin.periods.update', $period) }}" class="max-w-2xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Tahun Periode</label>
                <input type="text" name="name" value="{{ old('name', $period->name) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Nama Kabinet</label>
                <input type="text" name="cabinet_name" value="{{ old('cabinet_name', $period->cabinet_name) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Tagline</label>
            <input type="text" name="tagline" value="{{ old('tagline', $period->tagline) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Mulai</label>
                <input type="date" name="starts_at" value="{{ old('starts_at', $period->starts_at?->format('Y-m-d')) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Selesai</label>
                <input type="date" name="ends_at" value="{{ old('ends_at', $period->ends_at?->format('Y-m-d')) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Visi</label>
            <textarea name="vision" rows="3" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('vision', $period->vision) }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Misi (satu poin per baris)</label>
            <textarea name="mission_text" rows="5" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('mission_text', implode("\n", (array) $period->mission)) }}</textarea>
        </div>
        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $period->is_active)) class="rounded border-line">
            <span>Periode aktif</span>
        </label>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">Simpan Perubahan</button>
            <a href="{{ route('admin.periods.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
