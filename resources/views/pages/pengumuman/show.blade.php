@extends('layouts.app')

@section('title', $announcement->title.' — Pengumuman HMIF ITATS')
@section('meta_description', $announcement->excerpt)
@section('og_type', 'article')

@section('content')
    <article class="bg-white py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('pengumuman.index') }}" class="text-xs font-mono text-brand-600 hover:underline">&larr; Semua Pengumuman</a>

            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs font-mono text-ink-500">
                <span class="rounded bg-brand-50 px-2.5 py-1 text-brand-700 font-semibold">{{ $announcement->category }}</span>
                <time datetime="{{ optional($announcement->published_at)->toIso8601String() }}">
                    Diterbitkan {{ optional($announcement->published_at)->translatedFormat('d F Y, H:i') }} WIB
                </time>
            </div>

            <h1 class="mt-3 font-display text-3xl font-extrabold text-ink-950 leading-tight">
                {{ $announcement->title }}
            </h1>

            <div class="mt-8 pt-6 border-t border-line space-y-4 text-ink-700 leading-relaxed text-base">
                @foreach(preg_split("/\r\n|\n|\r/", $announcement->content) as $paragraph)
                    @if(trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </article>
@endsection
