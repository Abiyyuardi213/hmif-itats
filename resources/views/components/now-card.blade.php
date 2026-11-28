@props([
    'label' => 'Sedang berlangsung',
    'title' => null,
    'meta' => null,
    'url' => null,
    'cta' => 'Lihat detail',
    'status' => 'in_progress',
])

<section
    aria-label="{{ $label }}"
    {{ $attributes->merge(['class' => 'h-fit self-start rounded-[20px] border border-border bg-surface-raised p-6 shadow-card space-y-4']) }}
>
    <div class="space-y-3">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <x-status-badge :status="$status" :label="$label" />
        </div>

        @if($title)
            <h2 class="font-display text-xl font-semibold text-text leading-snug">
                {{ $title }}
            </h2>
        @endif

        @if($meta)
            <p class="text-sm text-text-muted leading-relaxed">
                {{ $meta }}
            </p>
        @endif
    </div>

    @if($url)
        <div class="pt-1">
            <a
                href="{{ $url }}"
                class="min-h-11 inline-flex items-center gap-1.5 text-sm font-semibold text-link hover:underline"
            >
                <span>{{ $cta }}</span>
                <x-icon name="arrow-right" size="16" />
            </a>
        </div>
    @endif
</section>
