@props([
    'filename' => 'dokumentasi.jpg',
    'date' => null,
    'image' => null,
    'alt' => '',
    'tilt' => 'none',
    'aspect' => 'aspect-[16/10]',
    'fetchpriority' => null,
    'imgWidth' => 960,
    'imgHeight' => 600,
    'href' => null,
    'title' => null,
    'summary' => null,
])

@php
    $tiltClasses = match ($tilt) {
        'left' => 'window-card-tilted md:-rotate-[1.5deg] md:hover:rotate-0',
        'right' => 'window-card-tilted md:rotate-[1.5deg] md:hover:rotate-0',
        default => '',
    };

    $loadingAttr = $fetchpriority === 'high' ? 'eager' : 'lazy';
@endphp

<article {{ $attributes->merge(['class' => "rounded-[20px] border border-border bg-surface-raised shadow-card overflow-hidden transition-transform duration-200 {$tiltClasses}"]) }}>
    <div class="h-9 px-3.5 border-b border-border bg-surface flex items-center justify-between gap-3">
        <div class="flex items-center gap-2 min-w-0">
            <span class="flex items-center gap-1.5 shrink-0" aria-hidden="true">
                <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-accent"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-focus-ring"></span>
            </span>
            <span class="font-mono text-[13px] font-medium text-text truncate">{{ $filename }}</span>
        </div>
        @if($date)
            <span class="text-xs text-text-muted shrink-0">{{ $date }}</span>
        @endif
    </div>

    @if($image)
        <div class="{{ $aspect }} w-full overflow-hidden bg-bg-soft">
            <img
                src="{{ $image }}"
                alt="{{ $alt }}"
                width="{{ $imgWidth }}"
                height="{{ $imgHeight }}"
                loading="{{ $loadingAttr }}"
                decoding="async"
                @if($fetchpriority) fetchpriority="{{ $fetchpriority }}" @endif
                class="h-full w-full object-cover"
            >
        </div>
    @endif

    @if($title || $summary || $slot->isNotEmpty())
        <div class="p-5 space-y-2.5">
            @isset($badge)
                <div>{{ $badge }}</div>
            @endisset

            @if($title)
                <h3 class="font-display text-lg font-semibold leading-snug text-text">
                    @if($href)
                        <a href="{{ $href }}" class="hover:text-link hover:underline inline-flex items-center gap-1.5 min-h-11 py-1">
                            <span>{{ $title }}</span>
                        </a>
                    @else
                        {{ $title }}
                    @endif
                </h3>
            @endif

            @if($summary)
                <p class="text-sm text-text-muted leading-relaxed line-clamp-3">{{ $summary }}</p>
            @endif

            {{ $slot }}
        </div>
    @endif
</article>
