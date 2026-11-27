@extends('layouts.admin')

@section('title', 'Ringkasan Sistem')
@section('page_title', 'Ringkasan Portal HMIF ITATS')
@section('page_subtitle', 'Statistik langsung dari database & aktivitas tata kelola terbaru.')

@section('content')
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="rounded-2xl border border-line bg-white p-5">
            <div class="font-mono text-xs text-ink-500 uppercase">Periode Aktif</div>
            <div class="font-display text-2xl font-extrabold text-ink-950 mt-1">{{ $metrics['period_name'] }}</div>
            <div class="text-xs text-brand-700 mt-1">{{ $activePeriod?->cabinet_name }}</div>
        </div>
        <div class="rounded-2xl border border-line bg-white p-5">
            <div class="font-mono text-xs text-ink-500 uppercase">Divisi &amp; Pengurus</div>
            <div class="font-display text-2xl font-extrabold text-ink-950 mt-1">{{ $metrics['divisions'] }} / {{ $metrics['members'] }}</div>
            <div class="text-xs text-ink-500 mt-1">Tanpa NPM publik</div>
        </div>
        <div class="rounded-2xl border border-line bg-white p-5">
            <div class="font-mono text-xs text-ink-500 uppercase">Proker &amp; Kegiatan</div>
            <div class="font-display text-2xl font-extrabold text-ink-950 mt-1">{{ $metrics['programs'] }} / {{ $metrics['activities'] }}</div>
            <div class="text-xs text-ink-500 mt-1">{{ $metrics['announcements'] }} pengumuman</div>
        </div>
        <div class="rounded-2xl border border-line bg-white p-5">
            <div class="font-mono text-xs text-ink-500 uppercase">Pesan Masuk Baru</div>
            <div class="font-display text-2xl font-extrabold text-ink-950 mt-1">{{ $metrics['unread_messages'] }}</div>
            <div class="text-xs text-ink-500 mt-1">
                Pemilu: {{ $latestElection?->statusLabel() ?? 'Belum ada' }}
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-line bg-white p-6">
        <h2 class="font-display text-lg font-bold text-ink-950 mb-4">Audit Log Aktivitas Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-line font-mono text-xs text-ink-500 uppercase">
                        <th class="py-2.5 pr-4">Waktu</th>
                        <th class="py-2.5 pr-4">Pengguna</th>
                        <th class="py-2.5 pr-4">Aksi</th>
                        <th class="py-2.5">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($recentLogs as $log)
                        <tr>
                            <td class="py-2.5 pr-4 font-mono text-xs text-ink-500 whitespace-nowrap">
                                {{ $log->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-2.5 pr-4 font-medium">{{ $log->user?->name ?? 'Sistem' }}</td>
                            <td class="py-2.5 pr-4 font-mono text-xs text-brand-700">{{ $log->action }}</td>
                            <td class="py-2.5 text-ink-700">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-ink-500">Belum ada catatan aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
