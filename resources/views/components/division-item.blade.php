@props([
    'name',
    'description' => null,
    'href' => null,
    'count' => null,
])

<div {{ $attributes->merge(['class' => 'border-b border-border py-5 grid grid-cols-1 md:grid-cols-12 gap-2 md:gap-6 items-baseline']) }}>
    <div class="md:col-span-5">
        <h3 class="font-display text-lg font-semibold text-text">
            @if($href)
                <a href="{{ $href }}" class="min-h-11 inline-flex items-center gap-2 hover:text-link hover:underline">
                    <span>{{ $name }}</span>
                </a>
            @else
                {{ $name }}
            @endif
        </h3>
    </div>

    <div class="md:col-span-7 flex flex-wrap items-baseline justify-between gap-3">
        @if($description)
            <p class="text-sm text-text-muted leading-relaxed max-w-[68ch]">
                {{ $description }}
            </p>
        @endif

        @if($count)
            <span class="text-xs font-medium text-text-muted shrink-0">
                {{ $count }}
            </span>
        @endif
    </div>
</div>
