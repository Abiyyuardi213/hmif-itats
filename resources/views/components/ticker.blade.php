@props([
    'items' => [],
    'slogan' => 'Informatika • Kolaboratif • Progresif',
])

@php
    $entries = collect($items)->take(5)->map(function ($item) {
        if (is_array($item)) {
            return [
                'title' => $item['title'] ?? '',
                'url' => $item['url'] ?? null,
            ];
        }

        if (is_object($item)) {
            return [
                'title' => $item->title ?? '',
                'url' => isset($item->slug) ? route('pengumuman.show', $item->slug) : null,
            ];
        }

        return ['title' => (string) $item, 'url' => null];
    })->filter(fn (array $entry) => $entry['title'] !== '')->values();
@endphp

<div
    data-ticker
    data-paused="false"
    {{ $attributes->merge(['class' => 'bg-band text-band-text border-y border-border-on-band flex items-stretch overflow-hidden']) }}
>
    <button
        type="button"
        data-ticker-toggle
        aria-pressed="false"
        aria-label="Jeda ticker pengumuman"
        class="relative z-20 min-h-11 inline-flex items-center gap-1.5 px-3 sm:px-4 text-xs font-medium text-on-band bg-band border-r border-border-on-band hover:underline shrink-0"
    >
        <x-icon name="pause" size="14" data-ticker-icon="pause" />
        <x-icon name="play" size="14" class="hidden" data-ticker-icon="play" />
        <span data-ticker-toggle-label>Jeda</span>
    </button>

    <div class="relative flex-1 overflow-hidden min-h-11 flex items-center" role="region" aria-label="Pengumuman berjalan">
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 z-10 w-8 bg-gradient-to-r from-band to-transparent"></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 z-10 w-8 bg-gradient-to-l from-band to-transparent"></div>

        <div class="ticker-track text-sm">
            <div class="flex items-center gap-6 pl-6 pr-4 shrink-0">
                <span class="font-medium text-on-band whitespace-nowrap">{{ $slogan }}</span>
                @foreach($entries as $entry)
                    <span class="text-on-band" aria-hidden="true">&bull;</span>
                    @if($entry['url'])
                        <a href="{{ $entry['url'] }}" class="min-h-11 inline-flex items-center text-band-text hover:text-on-band hover:underline whitespace-nowrap">
                            {{ $entry['title'] }}
                        </a>
                    @else
                        <span class="text-band-text whitespace-nowrap">{{ $entry['title'] }}</span>
                    @endif
                @endforeach
            </div>

            <div class="flex items-center gap-6 pl-6 pr-4 shrink-0" data-ticker-clone aria-hidden="true">
                <span class="font-medium text-on-band whitespace-nowrap">{{ $slogan }}</span>
                @foreach($entries as $entry)
                    <span class="text-on-band">&bull;</span>
                    @if($entry['url'])
                        <a href="{{ $entry['url'] }}" tabindex="-1" class="min-h-11 inline-flex items-center text-band-text whitespace-nowrap">
                            {{ $entry['title'] }}
                        </a>
                    @else
                        <span class="text-band-text whitespace-nowrap">{{ $entry['title'] }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
