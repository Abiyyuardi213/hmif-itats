@props([
    'name',
    'position',
    'photoUrl' => null,
])

@php
    $hasPhoto = is_string($photoUrl)
        && $photoUrl !== ''
        && ! str_ends_with($photoUrl, 'default-avatar.svg');
@endphp

<article {{ $attributes->merge(['class' => 'space-y-3']) }}>
    <div class="aspect-[4/5] w-full overflow-hidden rounded-[20px] border border-border bg-surface-raised">
        @if($hasPhoto)
            <img
                src="{{ $photoUrl }}"
                alt="{{ $name }}"
                width="400"
                height="500"
                loading="lazy"
                decoding="async"
                class="h-full w-full object-cover"
            >
        @else
            {{-- Theme-aware inline silhouette kept inside safe viewBox inset so card radius never clips it --}}
            <svg
                viewBox="0 0 160 200"
                fill="none"
                role="img"
                aria-label="{{ $name }}"
                focusable="false"
                class="h-full w-full text-text-muted"
            >
                <circle cx="80" cy="74" r="22" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-opacity="0.52" stroke-width="2.5" />
                <path d="M44 154C48 128 62 118 80 118C98 118 112 128 116 154" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-opacity="0.52" stroke-width="2.5" stroke-linecap="round" />
            </svg>
        @endif
    </div>

    <div class="space-y-0.5">
        <h3 class="font-display text-base font-semibold leading-snug text-text">
            {{ $name }}
        </h3>
        <p class="text-sm text-text-muted">
            {{ $position }}
        </p>
    </div>
</article>
