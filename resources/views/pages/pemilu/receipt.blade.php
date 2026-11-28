@extends('layouts.app')

@section('title', 'Bukti Suara Tercatat — HMIF ITATS')

@section('content')
    <section class="py-16 bg-surface min-h-[65vh] flex items-center">
        <div class="mx-auto max-w-xl px-4">
            <div class="rounded-2xl border border-success bg-surface-raised p-8 text-center shadow-card">
                <div class="mx-auto h-12 w-12 rounded-full bg-success-surface text-success flex items-center justify-center font-bold text-xl">
                    &#10003;
                </div>
                <h1 class="mt-4 font-display text-2xl font-extrabold text-ink-950">Suara Anda Telah Tercatat</h1>
                <p class="mt-2 text-sm text-ink-600">
                    Terima kasih telah berpartisipasi dalam <strong>{{ $electionTitle }}</strong>.
                    Identitas pemilih telah dipisahkan dari surat suara Anda untuk menjaga kerahasiaan pilihan.
                </p>

                <div class="mt-6 rounded-xl border border-line bg-surface p-4 text-left">
                    <div class="font-mono text-[11px] uppercase text-ink-500">Kode Tanda Terima Anonim (SHA-256)</div>
                    <div class="mt-1 font-mono text-xs break-all text-ink-950 font-semibold">{{ $receipt }}</div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-block rounded-xl bg-ink-950 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
