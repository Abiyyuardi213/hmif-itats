@extends('layouts.app')

@section('title', 'Pemilu & E-Voting HMIF ITATS')
@section('meta_description', 'Sistem E-Voting terverifikasi berbasis token sekali pakai dan arsip hasil Pemilu Raya HMIF ITATS.')

@section('content')
    <section class="bg-ink-950 text-white py-14 border-b border-slate-800 bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-cyan-400 uppercase tracking-wider">Demokrasi Kampus</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Pemilu Raya HMIF ITATS</h1>
            <p class="mt-2 text-slate-300 max-w-2xl">
                Sistem E-Voting dengan verifikasi Daftar Pemilih Tetap (DPT), tautan token sekali pakai melalui email terdaftar, serta pemisahan identitas pemilih dan suara untuk menjamin asas Luber Jurdil.
            </p>
        </div>
    </section>

    <section class="py-12 bg-surface">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-8">
            @if(! $election)
                <div class="rounded-2xl border border-line bg-white p-10 text-center text-sm text-ink-500">
                    Belum ada jadwal atau arsip Pemilu Raya yang dipublikasikan.
                </div>
            @elseif($election->isCurrentlyOpen())
                <div class="grid lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 space-y-4">
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5">
                            <div class="font-mono text-xs font-bold uppercase text-emerald-800">PEMUNGUTAN SUARA DIBUKA</div>
                            <h2 class="mt-1 font-display text-xl font-bold text-ink-950">{{ $election->title }}</h2>
                            <p class="mt-1 text-sm text-ink-700">{{ $election->description }}</p>
                            <div class="mt-2 font-mono text-xs text-emerald-800">
                                Jadwal: {{ $election->starts_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} &mdash;
                                {{ $election->ends_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($election->candidates as $candidate)
                                <div class="rounded-2xl border border-line bg-white p-5">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-lg font-extrabold text-white bg-brand-600 h-10 w-10 rounded-xl flex items-center justify-center">
                                            0{{ $candidate->candidate_number }}
                                        </span>
                                        <div>
                                            <div class="font-display font-bold text-ink-950">{{ $candidate->ketua_name }}</div>
                                            @if($candidate->wakil_name)
                                                <div class="text-xs text-ink-500">&amp; {{ $candidate->wakil_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($candidate->tagline)
                                        <p class="mt-3 text-xs font-semibold text-brand-700">&ldquo;{{ $candidate->tagline }}&rdquo;</p>
                                    @endif
                                    <div class="mt-3 text-xs text-ink-600 whitespace-pre-line leading-relaxed">{{ $candidate->vision_mission }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:col-span-5">
                        <form method="POST" action="{{ route('pemilu.request-token') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4 shadow-sm">
                            @csrf
                            <input type="hidden" name="election_id" value="{{ $election->id }}">

                            <div class="font-mono text-xs uppercase text-brand-600 font-semibold">Langkah 1 // Verifikasi Pemilih</div>
                            <h3 class="font-display text-lg font-bold text-ink-950">Minta Tautan Surat Suara</h3>
                            <p class="text-xs text-ink-500 leading-relaxed">
                                Masukkan NPM (mahasiswa) atau NIDN (dosen) beserta alamat email yang terdaftar pada DPT. Tautan rahasia sekali pakai akan dikirim ke email Anda.
                            </p>

                            <div>
                                <label for="identifier" class="block text-xs font-semibold text-ink-900 mb-1">NPM / NIDN</label>
                                <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}" required
                                    placeholder="Contoh: 06.2024.1.00001"
                                    class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm font-mono focus:border-brand-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold text-ink-900 mb-1">Email Terdaftar (Wajib)</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="nama@itats.ac.id / email terdaftar di DPT"
                                    class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                            </div>

                            <button type="submit" class="w-full rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-700 transition">
                                Kirim Tautan Surat Suara
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-line pb-5">
                        <div>
                            <span class="inline-block rounded-full bg-slate-100 border border-line px-3 py-1 font-mono text-xs font-semibold text-ink-700">
                                SESI PEMILU {{ strtoupper($election->statusLabel()) }}
                            </span>
                            <h2 class="mt-2 font-display text-2xl font-bold text-ink-950">{{ $election->title }}</h2>
                            <p class="mt-1 text-sm text-ink-600">{{ $election->description }}</p>
                        </div>
                        <div class="text-right font-mono text-xs text-ink-500">
                            <div>Total Suara Masuk: <strong class="text-ink-950">{{ $totalVotes }}</strong></div>
                            <div>Total DPT: <strong class="text-ink-950">{{ $totalEligible }}</strong></div>
                        </div>
                    </div>

                    @if($election->status === \App\Models\Election::STATUS_CLOSED && $results->isNotEmpty())
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($results as $row)
                                @php
                                    $pct = $totalVotes > 0 ? round(($row['votes'] / $totalVotes) * 100, 1) : 0;
                                @endphp
                                <div class="rounded-xl border border-line bg-surface p-5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-xs font-bold text-brand-700">PASLON 0{{ $row['candidate']->candidate_number }}</span>
                                        <span class="font-mono text-sm font-bold text-ink-950">{{ $row['votes'] }} suara ({{ $pct }}%)</span>
                                    </div>
                                    <div class="mt-2 font-display text-lg font-bold text-ink-950">
                                        {{ $row['candidate']->ketua_name }}
                                        @if($row['candidate']->wakil_name)
                                            &amp; {{ $row['candidate']->wakil_name }}
                                        @endif
                                    </div>
                                    <div class="mt-3 h-2 w-full rounded-full bg-slate-200 overflow-hidden">
                                        <div class="h-full bg-brand-600 rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
