@props([
    'status' => 'upcoming',
    'label' => null,
])

@php
    $normalized = strtolower((string) $status);

    $config = match ($normalized) {
        'completed', 'selesai', 'published' => [
            'icon' => 'check-circle',
            'iconClass' => 'text-success',
            'wrapClass' => 'bg-success-surface border-border text-text',
            'text' => $label ?? 'Selesai',
        ],
        'in_progress', 'berjalan', 'active', 'open', 'dibuka', 'sedang berlangsung' => [
            'icon' => 'clock',
            'iconClass' => 'text-link',
            'wrapClass' => 'bg-bg-soft border-border text-text',
            'text' => $label ?? 'Berjalan',
        ],
        'error', 'danger', 'failed', 'gagal' => [
            'icon' => 'alert-circle',
            'iconClass' => 'text-danger',
            'wrapClass' => 'bg-danger-surface border-border text-text',
            'text' => $label ?? 'Perlu perhatian',
        ],
        default => [
            'icon' => 'calendar',
            'iconClass' => 'text-text-muted',
            'wrapClass' => 'bg-surface border-border text-text',
            'text' => $label ?? match ($normalized) {
                'archive', 'arsip' => 'Arsip',
                'closed', 'ditutup' => 'Ditutup',
                'planned', 'direncanakan' => 'Direncanakan',
                'terakhir' => 'Terakhir',
                default => 'Akan datang',
            },
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-medium {$config['wrapClass']}"]) }}>
    <x-icon :name="$config['icon']" size="14" class="{{ $config['iconClass'] }}" />
    <span>{{ $config['text'] }}</span>
</span>
