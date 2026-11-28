@extends('layouts.admin')

@section('title', 'Edit Proker')
@section('page_title', 'Edit Program Kerja')

@section('content')
    <form method="POST" action="{{ route('admin.proker.update', $proker) }}" class="max-w-2xl rounded-2xl border border-line bg-white p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Periode</label>
                <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" @selected($proker->period_id === $period->id)>{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Divisi</label>
                <select name="division_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" @selected($proker->division_id === $division->id)>{{ $division->period->name }} &middot; {{ $division->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Judul Proker</label>
            <input type="text" name="title" value="{{ old('title', $proker->title) }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('description', $proker->description) }}</textarea>
        </div>
        <div class="grid sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Status</label>
                <select name="status" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    @foreach(\App\Models\WorkProgram::STATUSES as $k => $v)
                        <option value="{{ $k }}" @selected($proker->status === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Target</label>
                <input type="date" name="target_date" value="{{ old('target_date', $proker->target_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Realisasi</label>
                <input type="date" name="realized_at" value="{{ old('realized_at', $proker->realized_at?->format('Y-m-d')) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Target Peserta</label>
            <input type="number" name="target_participants" value="{{ old('target_participants', $proker->target_participants) }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.proker.index') }}" class="rounded-xl border border-line px-5 py-2.5 text-sm font-semibold">Batal</a>
        </div>
    </form>
@endsection
