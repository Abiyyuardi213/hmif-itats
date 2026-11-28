@extends('layouts.app')

@section('title', $activity->title.' — Kegiatan HMIF ITATS')
@section('meta_description', $activity->summary)
@section('og_type', 'article')
@section('og_image', $activity->cover_url)

@section('content')
    <article class="bg-white border-b border-line">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
            <a href="{{ route('kegiatan.index') }}" class="text-xs font-mono text-brand-600 hover:underline">&larr; Kembali ke Kegiatan</a>

            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-mono text-ink-500">
                <span class="rounded bg-brand-50 px-2.5 py-1 text-brand-700 font-semibold">{{ $activity->category }}</span>
                <time datetime="{{ $activity->event_date->format('Y-m-d') }}">
                    {{ $activity->event_date->translatedFormat('d F Y') }}
                </time>
                @if($activity->location)
                    <span>&middot; {{ $activity->location }}</span>
                @endif
            </div>

            <h1 class="mt-3 font-display text-3xl sm:text-4xl font-extrabold text-ink-950 leading-tight">
                {{ $activity->title }}
            </h1>

            @if($activity->workProgram)
                <p class="mt-3 text-sm text-ink-500">
                    Bagian dari Program Kerja:
                    <strong class="text-ink-900">{{ $activity->workProgram->title }}</strong>
                    @if($activity->workProgram->division)
                        ({{ $activity->workProgram->division->name }})
                    @endif
                </p>
            @endif

            <img src="{{ $activity->cover_url }}" alt="{{ $activity->title }}" class="mt-8 w-full max-h-[460px] object-cover rounded-2xl border border-line">

            <div class="mt-8 space-y-4 text-ink-700 leading-relaxed text-base">
                @foreach(preg_split("/\r\n|\n|\r/", $activity->content) as $paragraph)
                    @if(trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>

            @if($activity->registration_url)
                <div class="mt-8 rounded-2xl border border-brand-200 bg-brand-50 p-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-display font-bold text-ink-950">Tautan Pendaftaran Kegiatan</div>
                        <div class="text-sm text-ink-600">Daftar melalui formulir resmi yang disediakan panitia.</div>
                    </div>
                    <a href="{{ $activity->registration_url }}" target="_blank" rel="noopener noreferrer"
                        class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition">
                        Daftar Sekarang &nearr;
                    </a>
                </div>
            @endif
        </div>
    </article>

    @if($related->isNotEmpty())
        <section class="py-12 bg-surface">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="font-display text-xl font-bold text-ink-950 mb-5">Kegiatan Lainnya</h2>
                <div class="grid sm:grid-cols-3 gap-5">
                    @foreach($related as $item)
                        <a href="{{ route('kegiatan.show', $item->slug) }}" class="rounded-xl border border-line bg-white p-4 hover:border-brand-500 transition">
                            <div class="font-mono text-xs text-ink-500">{{ $item->event_date->translatedFormat('d M Y') }}</div>
                            <div class="mt-1 font-display font-bold text-ink-950">{{ $item->title }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
