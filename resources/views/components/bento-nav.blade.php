@props([
    'items' => null,
])

@php
    $blocks = $items ?? [
        [
            'title' => 'Kegiatan',
            'description' => 'Agenda kuliah tamu, workshop, lomba, dan rekam jejak dokumentasi HMIF ITATS.',
            'href' => route('kegiatan.index'),
            'featured' => true,
        ],
        [
            'title' => 'Struktur',
            'description' => 'Pengurus inti dan anggota divisi.',
            'href' => route('struktur'),
        ],
        [
            'title' => 'Program kerja',
            'description' => 'Target kerja tiap bidang kabinet.',
            'href' => route('proker.index'),
        ],
        [
            'title' => 'Pengumuman',
            'description' => 'Papan informasi resmi himpunan.',
            'href' => route('pengumuman.index'),
        ],
    ];

    $primary = $blocks[0] ?? null;
    $secondary = array_slice($blocks, 1, 3);
@endphp

<nav aria-label="Navigasi cepat portal" {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 items-stretch']) }}>
    @if($primary)
        <a
            href="{{ $primary['href'] }}"
            class="lg:col-span-6 rounded-[20px] border border-border bg-bg-soft p-6 flex flex-col justify-between gap-4 hover:border-border-input transition-colors"
        >
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-4">
                    <h3 class="font-display text-2xl font-bold text-text">
                        {{ $primary['title'] }}
                    </h3>
                    <x-icon name="arrow-up-right" size="20" class="text-text" />
                </div>
                <p class="text-sm text-text-muted max-w-md leading-relaxed">
                    {{ $primary['description'] }}
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-link">
                <span>Jelajahi kegiatan</span>
                <x-icon name="arrow-right" size="16" />
            </span>
        </a>
    @endif

    <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($secondary as $index => $block)
            <a
                href="{{ $block['href'] }}"
                class="rounded-[20px] border border-border bg-surface-raised p-5 flex flex-col justify-between gap-3 shadow-card hover:border-border-input transition-colors {{ $index === 2 ? 'sm:col-span-2' : '' }}"
            >
                <div class="flex items-center justify-between gap-3">
                    <h3 class="font-display text-lg font-semibold text-text">
                        {{ $block['title'] }}
                    </h3>
                    <x-icon name="arrow-right" size="18" class="text-text-muted" />
                </div>
                <p class="text-sm text-text-muted">
                    {{ $block['description'] }}
                </p>
            </a>
        @endforeach
    </div>
</nav>
