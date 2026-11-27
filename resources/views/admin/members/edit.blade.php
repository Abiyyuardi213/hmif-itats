@extends('layouts.admin')

@section('title', 'Edit Pengurus')
@section('page_title', 'Edit Pengurus: '.$member->name)

@section('content')
    <form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data" class="max-w-xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-xs font-semibold mb-1">Periode</label>
            <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                @foreach($periods as $period)
                    <option value="{{ $period->id }}" @selected($member->period_id === $period->id)>{{ $period->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Divisi</label>
            <select name="division_id" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                <option value="">-- Badan Pengurus Harian (BPH) --</option>
                @foreach($divisions as $division)
                    <option value="{{ $division->id }}" @selected($member->division_id === $division->id)>{{ $division->period->name }} &middot; {{ $division->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Jabatan</label>
                <input type="text" name="position" value="{{ old('position', $member->position) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_core" value="1" @checked(old('is_core', $member->is_core)) class="rounded border-line">
            <span>Termasuk BPH Inti</span>
        </label>
        <div>
            <label class="block text-xs font-semibold mb-1">Ganti Foto (opsional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full text-xs">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.members.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
