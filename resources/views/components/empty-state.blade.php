@props([
    'message',
    'actionLabel' => null,
    'actionHref' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-[20px] border border-border bg-surface p-6 text-center space-y-4']) }}>
    <p class="text-base text-text-muted max-w-[68ch] mx-auto">
        {{ $message }}
    </p>

    @if($actionLabel && $actionHref)
        <div>
            <a
                href="{{ $actionHref }}"
                class="min-h-11 inline-flex items-center gap-1.5 text-sm font-semibold text-link hover:underline px-3"
            >
                <span>{{ $actionLabel }}</span>
                <x-icon name="arrow-right" size="16" />
            </a>
        </div>
    @endif
</div>
