@props([
    'title',
    'actionLabel' => null,
    'actionHref' => null,
    'id' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-baseline justify-between gap-4']) }}>
    <h2
        @if($id) id="{{ $id }}" @endif
        class="font-display font-bold text-text leading-[1.15] tracking-[-0.02em]"
        style="font-size: clamp(1.75rem, 1.1rem + 2.6vw, 2.75rem);"
    >
        {{ $title }}
    </h2>

    @if($actionLabel && $actionHref)
        <a
            href="{{ $actionHref }}"
            class="min-h-11 inline-flex items-center gap-1.5 text-sm font-semibold text-link hover:underline"
        >
            <span>{{ $actionLabel }}</span>
            <x-icon name="arrow-right" size="16" />
        </a>
    @endif
</div>
