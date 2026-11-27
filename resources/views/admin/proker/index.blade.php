@extends('layouts.admin')

@section('title', 'Program Kerja')
@section('page_title', 'Manajemen Program Kerja')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <form method="POST" action="{{ route('admin.proker.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Program Kerja</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Periode</label>
                    <select name="period_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Divisi Penanggung Jawab</label>
                    <select name="division_id" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->period->name }} &middot; {{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Judul Proker</label>
                    <input type="text" name="title" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                            @foreach(\App\Models\WorkProgram::STATUSES as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Target Peserta</label>
                        <input type="number" name="target_participants" min="1" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Tanggal Target</label>
                        <input type="date" name="target_date" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Tanggal Realisasi</label>
                        <input type="date" name="realized_at" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Proker</button>
            </form>
        </div>

        <div class="lg:col-span-8 space-y-3">
            @foreach($programs as $program)
                <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-mono text-xs text-brand-700 font-semibold">
                            {{ $program->division->code }} &middot; {{ $program->period->name }} &middot; {{ $program->statusLabel() }}
                        </div>
                        <div class="font-display text-base font-bold text-ink-950 mt-0.5">{{ $program->title }}</div>
                        <div class="text-xs text-ink-500 mt-1">{{ \Illuminate\Support\Str::limit($program->description, 110) }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.proker.edit', $program) }}" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Edit</a>
                        <form method="POST" action="{{ route('admin.proker.destroy', $program) }}" onsubmit="return confirm('Hapus proker ini?')">
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
