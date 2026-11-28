@extends('layouts.admin')

@section('title', 'Edit Divisi')
@section('page_title', 'Edit Divisi: '.$division->name)

@section('content')
    <form method="POST" action="{{ route('admin.divisions.update', $division) }}" class="max-w-xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-xs font-semibold mb-1">Periode</label>
            <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                @foreach($periods as $period)
                    <option value="{{ $period->id }}" @selected($division->period_id === $period->id)>{{ $period->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Kode</label>
                <input type="text" name="code" value="{{ old('code', $division->code) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $division->sort_order) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Nama Divisi</label>
            <input type="text" name="name" value="{{ old('name', $division->name) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Ringkasan</label>
            <input type="text" name="short_description" value="{{ old('short_description', $division->short_description) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Deskripsi Lengkap</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('description', $division->description) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.divisions.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
