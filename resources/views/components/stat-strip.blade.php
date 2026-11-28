@props([
    'stats' => [],
])

@php
    $visibleStats = collect($stats)->filter(function ($stat) {
        $value = $stat['value'] ?? null;

        if ($value === null || $value === '') {
            return false;
        }

        if (is_numeric($value) && (float) $value == 0.0) {
            return false;
        }

        return true;
    })->values();

    $colsClass = match ($visibleStats->count()) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 lg:grid-cols-3',
        default => 'grid-cols-2 lg:grid-cols-4',
    };
@endphp

@if($visibleStats->isNotEmpty())
    <div {{ $attributes->merge(['class' => "rounded-none bg-surface border-y border-border grid {$colsClass} divide-x divide-y lg:divide-y-0 divide-border"]) }}>
        @foreach($visibleStats as $stat)
            <div class="px-4 py-5 sm:px-6 sm:py-6">
                <div class="font-display font-bold text-text leading-[1.15] tracking-[-0.02em]" style="font-size: clamp(1.75rem, 1.1rem + 2.6vw, 2.75rem);">
                    {{ $stat['value'] }}
                </div>
                <div class="mt-1 text-sm text-text-muted">
                    {{ $stat['label'] }}
                </div>
            </div>
        @endforeach
    </div>
@endif
