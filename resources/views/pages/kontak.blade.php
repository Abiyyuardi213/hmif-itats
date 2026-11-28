@extends('layouts.app')

@section('title', 'Kontak & Aspirasi — HMIF ITATS')
@section('meta_description', 'Hubungi sekretariat HMIF ITATS atau sampaikan aspirasi, kolaborasi kegiatan, dan pertanyaan seputar himpunan.')

@section('content')
    <section class="bg-band text-band-text py-14 border-b border-border bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-on-band uppercase tracking-wider">Sekretariat</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Kontak &amp; Aspirasi</h1>
            <p class="mt-2 text-band-muted max-w-2xl">
                Saluran resmi komunikasi untuk mahasiswa Informatika, alumni, mitra komunitas, dan kolaborasi kegiatan.
            </p>
        </div>
    </section>

    <section class="py-14 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5 space-y-4">
                <div class="rounded-2xl border border-line bg-white p-6 space-y-4">
                    <h2 class="font-display text-lg font-bold text-ink-950">Informasi Resmi</h2>
                    <div class="text-sm space-y-3">
                        @if(! empty($orgSettings['email']))
                            <div>
                                <div class="font-mono text-xs uppercase text-ink-500">Email</div>
                                <a href="mailto:{{ $orgSettings['email'] }}" class="font-medium text-brand-600 hover:underline">
                                    {{ $orgSettings['email'] }}
                                </a>
                            </div>
                        @endif
                        @if(! empty($orgSettings['phone']))
                            <div>
                                <div class="font-mono text-xs uppercase text-ink-500">Telepon Kampus</div>
                                <div class="font-medium text-ink-900">{{ $orgSettings['phone'] }}</div>
                            </div>
                        @endif
                        @if(! empty($orgSettings['address']))
                            <div>
                                <div class="font-mono text-xs uppercase text-ink-500">Alamat</div>
                                <div class="text-ink-700 leading-relaxed">{{ $orgSettings['address'] }}</div>
                            </div>
                        @endif
                        @if(! empty($orgSettings['instagram_url']))
                            <div>
                                <div class="font-mono text-xs uppercase text-ink-500">Instagram</div>
                                <a href="{{ $orgSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" class="font-medium text-brand-600 hover:underline">
                                    @hmif_itats &nearr;
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <form method="POST" action="{{ route('kontak.store') }}" class="rounded-2xl border border-line bg-white p-6 sm:p-8 space-y-5">
                    @csrf
                    {{-- Honeypot field for spam protection --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <h2 class="font-display text-xl font-bold text-ink-950">Kirim Pesan atau Aspirasi</h2>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-ink-900 mb-1.5">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-ink-900 mb-1.5">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-ink-900 mb-1.5">Subjek</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                            placeholder="Contoh: Kerja sama seminar / Pendaftaran Divisi 6 / Aspirasi"
                            class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-ink-900 mb-1.5">Pesan</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700 transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
