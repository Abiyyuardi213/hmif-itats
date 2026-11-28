@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'loading' => false,
    'size' => 'md',
])

@php
    $variantClasses = match ($variant) {
        'secondary' => 'border border-border-input bg-surface text-text hover:bg-bg-soft font-semibold',
        'ghost' => 'text-text hover:bg-bg-soft font-medium',
        default => 'bg-primary text-on-primary hover:bg-primary-hover font-semibold shadow-card',
    };

    $sizeClasses = match ($size) {
        'sm' => 'min-h-11 px-4 py-2 text-sm',
        'lg' => 'min-h-12 px-6 py-3 text-base',
        default => 'min-h-11 px-5 py-2.5 text-sm',
    };

    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-full transition-colors duration-200 disabled:opacity-80 disabled:cursor-not-allowed whitespace-nowrap';
@endphp

@if($href && ! $loading)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($loading)
        @if($loading) aria-busy="true" @endif
        {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}
    >
        {{ $slot }}
    </button>
@endif
