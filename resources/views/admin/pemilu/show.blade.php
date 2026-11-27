@extends('layouts.admin')

@section('title', $pemilu->title)
@section('page_title', $pemilu->title)
@section('page_subtitle', 'Status: '.$pemilu->statusLabel().' | '.$stats['voted'].' / '.$stats['eligible'].' DPT telah memilih ('.$stats['ballots'].' suara anonim)')

@section('header_actions')
    <a href="{{ route('admin.pemilu.export', $pemilu) }}" class="rounded-xl border border-line bg-white px-4 py-2 text-xs font-semibold text-ink-950 hover:bg-slate-50">
        Ekspor CSV Audit Pembina
    </a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-line bg-white p-5 flex flex-wrap items-center justify-between gap-4">
            <div class="text-sm text-ink-700">
                Jadwal: <strong>{{ $pemilu->starts_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</strong> &mdash;
                <strong>{{ $pemilu->ends_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</strong>
            </div>
            <form method="POST" action="{{ route('admin.pemilu.status', $pemilu) }}" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-lg border border-line px-3 py-2 text-sm">
                    @foreach(\App\Models\Election::STATUSES as $k => $v)
                        <option value="{{ $k }}" @selected($pemilu->status === $k)>{{ $v }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2 text-xs font-semibold text-white">Ubah Status</button>
            </form>
        </div>

        <div class="grid lg:grid-cols-12 gap-6">
            <div class="lg:col-span-5 space-y-6">
                <form method="POST" action="{{ route('admin.pemilu.candidates.store', $pemilu) }}" enctype="multipart/form-data" class="rounded-2xl border border-line bg-white p-6 space-y-3">
                    @csrf
                    <h2 class="font-display text-base font-bold">Tambah Kandidat</h2>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">No. Urut</label>
                            <input type="number" name="candidate_number" min="1" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold mb-1">Nama Calon Ketua</label>
                            <input type="text" name="ketua_name" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Calon Wakil (opsional)</label>
                            <input type="text" name="wakil_name" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Tagline</label>
                            <input type="text" name="tagline" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Visi &amp; Misi</label>
                        <textarea name="vision_mission" rows="3" required class="w-full rounded-lg border border-line px-3 py-2 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Foto (opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white">Tambah Kandidat</button>
                </form>

                <form method="POST" action="{{ route('admin.pemilu.voters.import', $pemilu) }}" class="rounded-2xl border border-line bg-white p-6 space-y-3">
                    @csrf
                    <h2 class="font-display text-base font-bold">Import DPT (CSV Baris)</h2>
                    <p class="text-xs text-ink-500">
                        Format per baris: <code>NPM_ATAU_NIDN,Nama Pemilih,email@domain,mahasiswa|dosen</code>. Identifier disimpan sebagai hash HMAC-SHA256.
                    </p>
                    <textarea name="voters_csv" rows="5" required placeholder="06.2024.1.07801,Budi Santoso,budi@itats.ac.id,mahasiswa" class="w-full rounded-lg border border-line px-3 py-2 font-mono text-xs"></textarea>
                    <button type="submit" class="w-full rounded-xl bg-ink-950 px-4 py-2 text-sm font-semibold text-white">Import ke DPT</button>
                </form>
            </div>

            <div class="lg:col-span-7 space-y-6">
                <div class="rounded-2xl border border-line bg-white p-6">
                    <h2 class="font-display text-base font-bold mb-4">Kandidat &amp; Perolehan Suara</h2>
                    <div class="space-y-3">
                        @foreach($pemilu->candidates as $candidate)
                            <div class="rounded-xl border border-line bg-surface p-4 flex items-center justify-between">
                                <div>
                                    <span class="font-mono text-xs font-bold text-brand-700">NO. 0{{ $candidate->candidate_number }}</span>
                                    <div class="font-display font-bold text-ink-950">
                                        {{ $candidate->ketua_name }}
                                        @if($candidate->wakil_name) &amp; {{ $candidate->wakil_name }} @endif
                                    </div>
                                </div>
                                <div class="font-mono text-lg font-bold text-ink-950">
                                    {{ (int) ($voteCounts[$candidate->id] ?? 0) }} suara
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl border border-line bg-white p-6">
                    <h2 class="font-display text-base font-bold mb-4">Daftar Pemilih Tetap (DPT)</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead>
                                <tr class="border-b border-line font-mono text-ink-500 uppercase">
                                    <th class="py-2 pr-3">ID Terlindung</th>
                                    <th class="py-2 pr-3">Nama</th>
                                    <th class="py-2 pr-3">Tipe</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-line">
                                @forelse($voters as $voter)
                                    <tr>
                                        <td class="py-2 pr-3 font-mono">{{ $voter->identifier_masked }}</td>
                                        <td class="py-2 pr-3 font-medium">{{ $voter->voter_name }}</td>
                                        <td class="py-2 pr-3">{{ $voter->voter_type }}</td>
                                        <td class="py-2 font-mono">
                                            {{ $voter->has_voted ? 'SUDAH' : 'BELUM' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-ink-500">Belum ada DPT terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $voters->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
