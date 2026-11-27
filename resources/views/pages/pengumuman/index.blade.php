@extends('layouts.app')

@section('title', 'Pengumuman Resmi HMIF ITATS')
@section('meta_description', 'Papan informasi resmi, rekrutmen, jadwal organisasi, dan pembaruan penting dari HMIF ITATS.')

@section('content')
    <section class="bg-ink-950 text-white py-14 border-b border-slate-800 bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-cyan-400 uppercase tracking-wider">Papan Informasi</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Pengumuman Resmi</h1>
            <p class="mt-2 text-slate-300 max-w-2xl">
                Informasi terbaru terkait kepengurusan, agenda akademik, rekrutmen panitia, dan arsip keputusan HMIF ITATS.
            </p>
        </div>
    </section>

    <section class="py-12 bg-surface">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-wrap items-center gap-2">
                <a href="{{ route('pengumuman.index') }}"
                    class="rounded-full px-3.5 py-1.5 text-xs font-semibold border transition {{ ! $category ? 'bg-ink-950 text-white border-ink-950' : 'bg-white text-ink-700 border-line hover:border-brand-500' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('pengumuman.index', ['kategori' => $cat]) }}"
                        class="rounded-full px-3.5 py-1.5 text-xs font-semibold border transition {{ $category === $cat ? 'bg-ink-950 text-white border-ink-950' : 'bg-white text-ink-700 border-line hover:border-brand-500' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <div class="space-y-4">
                @forelse($announcements as $item)
                    <article class="rounded-2xl border border-line bg-white p-6 hover:border-brand-500 transition">
                        <div class="flex flex-wrap items-center justify-between gap-2 text-xs font-mono text-ink-500">
                            <div class="flex items-center gap-2">
                                <span class="rounded bg-brand-50 px-2.5 py-0.5 text-brand-700 font-semibold">{{ $item->category }}</span>
                                @if($item->is_pinned)
                                    <span class="rounded bg-amber-100 px-2.5 py-0.5 text-amber-800 font-semibold">DISAMATKAN</span>
                                @endif
                            </div>
                            <time datetime="{{ optional($item->published_at)->toIso8601String() }}">
                                {{ optional($item->published_at)->translatedFormat('d M Y, H:i') }} WIB
                            </time>
                        </div>
                        <h2 class="mt-3 font-display text-xl font-bold text-ink-950">
                            <a href="{{ route('pengumuman.show', $item->slug) }}" class="hover:text-brand-600 transition">
                                {{ $item->title }}
                            </a>
                        </h2>
                        <p class="mt-2 text-sm text-ink-600 leading-relaxed">{{ $item->excerpt }}</p>
                        <div class="mt-4">
                            <a href="{{ route('pengumuman.show', $item->slug) }}" class="text-sm font-semibold text-brand-600 hover:underline">
                                Baca selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-line bg-white p-10 text-center text-sm text-ink-500">
                        Belum ada pengumuman yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        </div>
    </section>
@endsection
