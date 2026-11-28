@extends('layouts.app')

@section('title', 'Surat Suara Rahasia — '.$election->title)
@section('meta_description', 'Bilik suara digital rahasia HMIF ITATS.')

@section('content')
    <section class="py-12 bg-surface min-h-[75vh]">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2 pb-5 border-b border-line">
                    <div>
                        <div class="font-mono text-xs text-success font-semibold">TOKEN TERVERIFIKASI &middot; SATU KALI PAKAI</div>
                        <h1 class="mt-1 font-display text-2xl font-extrabold text-ink-950">{{ $election->title }}</h1>
                    </div>
                    <div class="text-xs font-mono text-ink-500">
                        Pemilih: {{ $voter->voter_name }} ({{ $voter->identifier_masked }})
                    </div>
                </div>

                <form method="POST" action="{{ route('pemilu.cast', ['token' => $rawToken]) }}" class="mt-6 space-y-6">
                    @csrf
                    <p class="text-sm text-ink-600">
                        Pilih satu kandidat di bawah ini. Setelah dikirim, pilihan Anda disimpan secara anonim dan tidak dapat diubah.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($election->candidates as $candidate)
                            <label class="cursor-pointer rounded-2xl border-2 border-line p-5 hover:border-brand-500 has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50/50 transition block">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-base font-extrabold text-white bg-ink-950 h-9 w-9 rounded-lg flex items-center justify-center">
                                            0{{ $candidate->candidate_number }}
                                        </span>
                                        <div>
                                            <div class="font-display font-bold text-ink-950">{{ $candidate->ketua_name }}</div>
                                            @if($candidate->wakil_name)
                                                <div class="text-xs text-ink-500">&amp; {{ $candidate->wakil_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required class="mt-1 h-4 w-4 text-brand-600">
                                </div>
                                @if($candidate->tagline)
                                    <div class="mt-3 text-xs font-semibold text-brand-700">&ldquo;{{ $candidate->tagline }}&rdquo;</div>
                                @endif
                                <div class="mt-2 text-xs text-ink-600 whitespace-pre-line">{{ $candidate->vision_mission }}</div>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-primary px-6 py-3.5 text-sm font-bold text-on-primary hover:bg-primary-hover transition">
                        Kirim Suara Sah Saya
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
