@extends('layouts.app')

@section('title', 'Kegiatan & Agenda HMIF ITATS')
@section('meta_description', 'Dokumentasi kegiatan, seminar, workshop, pengabdian masyarakat, dan agenda kemahasiswaan Teknik Informatika ITATS.')

@section('content')
    <section class="bg-band text-band-text py-14 border-b border-border bg-tech-grid">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="font-mono text-xs text-on-band uppercase tracking-wider">Agenda &amp; Galeri</div>
            <h1 class="mt-2 font-display text-3xl sm:text-4xl font-extrabold">Kegiatan HMIF ITATS</h1>
            <p class="mt-2 text-band-muted max-w-2xl">
                Rekam jejak kegiatan akademik, kaderisasi, kompetisi, dan sosial kemasyarakatan mahasiswa Informatika ITATS.
            </p>
        </div>
    </section>

    <section class="py-12 bg-surface">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('kegiatan.index') }}" class="mb-8 flex flex-wrap items-center gap-3 rounded-2xl border border-line bg-white p-4">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul kegiatan atau lokasi..."
                    class="flex-1 min-w-52 rounded-lg border border-line bg-surface px-3.5 py-2 text-sm">
                <select name="kategori" class="rounded-lg border border-line bg-surface px-3 py-2 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition">
                    Cari
                </button>
                @if($category || $search !== '')
                    <a href="{{ route('kegiatan.index') }}" class="text-sm font-medium text-ink-500 hover:text-ink-950">Reset</a>
                @endif
            </form>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($activities as $activity)
                    <article class="rounded-2xl border border-line bg-white overflow-hidden flex flex-col hover:border-brand-500 transition">
                        <img src="{{ $activity->cover_url }}" alt="{{ $activity->title }}" class="h-48 w-full object-cover">
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex items-center justify-between gap-2 text-xs font-mono text-ink-500">
                                <span class="rounded bg-brand-50 px-2 py-0.5 text-brand-700 font-semibold">{{ $activity->category }}</span>
                                <time datetime="{{ $activity->event_date->format('Y-m-d') }}">
                                    {{ $activity->event_date->translatedFormat('d M Y') }}
                                </time>
                            </div>
                            <h2 class="mt-3 font-display text-lg font-bold text-ink-950">
                                <a href="{{ route('kegiatan.show', $activity->slug) }}" class="hover:text-brand-600 transition">
                                    {{ $activity->title }}
                                </a>
                            </h2>
                            <p class="mt-2 text-sm text-ink-600 line-clamp-3 flex-1">{{ $activity->summary }}</p>
                            <div class="mt-4 pt-3 border-t border-line flex items-center justify-between text-xs text-ink-500">
                                <span class="truncate">{{ $activity->location ?? 'Kampus ITATS' }}</span>
                                <a href="{{ route('kegiatan.show', $activity->slug) }}" class="font-semibold text-brand-600 hover:underline flex-shrink-0">
                                    Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-line bg-white p-10 text-center text-sm text-ink-500">
                        Belum ada kegiatan yang cocok dengan pencarian Anda.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $activities->links() }}
            </div>
        </div>
    </section>
@endsection
