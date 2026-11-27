@extends('layouts.app')

@section('title', 'Enam Divisi HMIF ITATS — Bidang & Fokus Kerja')
@section('meta_description', 'Daftar lengkap enam divisi aktif di bawah Himpunan Mahasiswa Teknik Informatika ITATS beserta anggota dan program kerjanya.')

@section('content')
    <section class="bg-ink-950 text-white py-14 border-b border-slate-800 bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-cyan-400 uppercase tracking-wider">Organisasi</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Divisi HMIF ITATS</h1>
            <p class="mt-3 text-slate-300 max-w-2xl">
                Bidang kerja yang menjalankan roda kaderisasi, riset teknologi, publikasi media, relasi eksternal, pengabdian sosial, hingga pengembangan sistem digital.
            </p>
        </div>
    </section>

    <section class="py-14 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($divisions as $division)
                <article class="rounded-2xl border border-line bg-white p-6 flex flex-col justify-between hover:border-brand-500 transition">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs font-semibold text-brand-700 bg-brand-50 px-2.5 py-1 rounded-md">
                                {{ $division->code }}
                            </span>
                            <span class="font-mono text-xs text-ink-500">
                                {{ $division->members_count }} Pengurus &middot; {{ $division->work_programs_count }} Proker
                            </span>
                        </div>
                        <h2 class="mt-4 font-display text-xl font-bold text-ink-950">{{ $division->name }}</h2>
                        <p class="mt-2 text-sm text-ink-600 leading-relaxed">{{ $division->description ?? $division->short_description }}</p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-line flex items-center justify-between">
                        <a href="{{ route('divisi.show', $division->slug) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                            Buka profil divisi &rarr;
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
