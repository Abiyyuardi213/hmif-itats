@php
    $navItems = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Tentang', 'href' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'Struktur', 'href' => route('struktur'), 'active' => request()->routeIs('struktur')],
        ['label' => 'Program kerja', 'href' => route('proker.index'), 'active' => request()->routeIs('proker.*')],
        ['label' => 'Kegiatan', 'href' => route('kegiatan.index'), 'active' => request()->routeIs('kegiatan.*')],
        ['label' => 'Pengumuman', 'href' => route('pengumuman.index'), 'active' => request()->routeIs('pengumuman.*')],
    ];

    if (! empty(config('merchandise.items', [])) && \Illuminate\Support\Facades\Route::has('merchandise')) {
        $navItems[] = [
            'label' => 'Merchandise',
            'href' => route('merchandise'),
            'active' => request()->routeIs('merchandise'),
        ];
    }

    $openElection = $openElection ?? null;
@endphp

<header class="sticky z-40 px-3 sm:px-6 lg:px-8" style="top: calc(12px + env(safe-area-inset-top, 0px));">
    <div class="mx-auto max-w-[1200px] rounded-full border border-border bg-surface px-2.5 sm:px-4 h-16 flex items-center justify-between gap-2 shadow-card">
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 min-h-11 pr-1 sm:pr-2 rounded-full shrink-0 group">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-plate p-1 border border-border shrink-0">
                <img
                    src="{{ asset('image/icon-hmif.jpg') }}"
                    alt="Logo HMIF ITATS"
                    width="28"
                    height="28"
                    class="h-7 w-7 rounded-md object-contain"
                >
            </span>
            <span class="font-display text-sm sm:text-base font-bold tracking-tight text-text whitespace-nowrap">
                HMIF ITATS
            </span>
        </a>

        <nav aria-label="Navigasi utama" class="hidden lg:flex items-center gap-1 text-sm">
            @foreach($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    @if($item['active']) aria-current="page" @endif
                    class="inline-flex items-center min-h-11 px-3 rounded-full transition-colors whitespace-nowrap {{ $item['active'] ? 'font-semibold text-text underline decoration-text decoration-2 underline-offset-8' : 'font-medium text-text-muted hover:text-text hover:bg-bg-soft' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2 shrink-0">
            <button
                type="button"
                data-theme-toggle
                aria-pressed="false"
                aria-label="Aktifkan mode gelap"
                class="inline-flex items-center justify-center gap-1.5 min-h-11 min-w-11 px-2.5 sm:px-3 rounded-full border border-border-input bg-surface text-xs font-medium text-text hover:bg-bg-soft transition-colors whitespace-nowrap"
            >
                <x-icon name="moon" size="16" data-theme-icon="moon" />
                <x-icon name="sun" size="16" class="hidden" data-theme-icon="sun" />
                <span data-theme-label>Mode gelap</span>
            </button>

            <div class="hidden lg:flex items-center gap-2">
                <x-button variant="primary" :href="route('kontak')">
                    Kontak HMIF
                </x-button>
            </div>

            <button
                type="button"
                data-mobile-menu-toggle
                aria-expanded="false"
                aria-controls="mobile-nav-panel"
                aria-label="Buka menu navigasi"
                class="lg:hidden inline-flex items-center justify-center min-h-11 min-w-11 rounded-full border border-border-input bg-surface text-text hover:bg-bg-soft transition-colors"
            >
                <x-icon name="menu" size="20" />
            </button>
        </div>
    </div>

    <div
        id="mobile-nav-panel"
        data-mobile-menu
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
        aria-label="Menu navigasi"
        class="hidden lg:hidden fixed inset-0 z-50 bg-bg text-text flex flex-col p-4 sm:p-6 overflow-y-auto"
    >
        <div class="flex items-center justify-between gap-3 pb-4 border-b border-border">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 min-h-11">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-plate p-1 border border-border">
                    <img
                        src="{{ asset('image/icon-hmif.jpg') }}"
                        alt="Logo HMIF ITATS"
                        width="28"
                        height="28"
                        class="h-7 w-7 rounded-md object-contain"
                    >
                </span>
                <span class="font-display text-base font-bold text-text">HMIF ITATS</span>
            </a>

            <button
                type="button"
                data-mobile-menu-close
                aria-label="Tutup menu navigasi"
                class="inline-flex items-center justify-center min-h-11 min-w-11 rounded-full border border-border-input bg-surface text-text hover:bg-bg-soft transition-colors"
            >
                <x-icon name="x" size="20" />
            </button>
        </div>

        <nav aria-label="Navigasi seluler" class="flex-1 py-4 flex flex-col">
            @foreach($navItems as $item)
                <a
                    href="{{ $item['href'] }}"
                    @if($item['active']) aria-current="page" @endif
                    class="min-h-12 flex items-center justify-between px-2 py-3 border-b border-border text-lg {{ $item['active'] ? 'font-semibold text-text underline decoration-text decoration-2 underline-offset-8' : 'font-medium text-text-muted hover:text-text' }}"
                >
                    <span>{{ $item['label'] }}</span>
                    <x-icon name="arrow-right" size="18" />
                </a>
            @endforeach

            <a
                href="{{ route('divisi.index') }}"
                @if(request()->routeIs('divisi.*')) aria-current="page" @endif
                class="min-h-12 flex items-center justify-between px-2 py-3 border-b border-border text-lg {{ request()->routeIs('divisi.*') ? 'font-semibold text-text underline decoration-text decoration-2 underline-offset-8' : 'font-medium text-text-muted hover:text-text' }}"
            >
                <span>Divisi</span>
                <x-icon name="arrow-right" size="18" />
            </a>

            <a
                href="{{ route('pemilu.index') }}"
                @if(request()->routeIs('pemilu.*')) aria-current="page" @endif
                class="min-h-12 flex items-center justify-between px-2 py-3 border-b border-border text-lg {{ request()->routeIs('pemilu.*') ? 'font-semibold text-text underline decoration-text decoration-2 underline-offset-8' : 'font-medium text-text-muted hover:text-text' }}"
            >
                <span>{{ $openElection ? 'Pemilu (berlangsung)' : 'Pemilu dan arsip' }}</span>
                <x-icon name="arrow-right" size="18" />
            </a>
        </nav>

        <div class="pt-4 space-y-3 border-t border-border">
            <x-button variant="primary" :href="route('kontak')" class="w-full justify-center">
                Kontak HMIF
            </x-button>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    data-theme-toggle
                    aria-pressed="false"
                    aria-label="Aktifkan mode gelap"
                    class="flex-1 min-h-11 inline-flex items-center justify-center gap-2 rounded-full border border-border-input bg-surface px-4 text-sm font-medium text-text hover:bg-bg-soft"
                >
                    <x-icon name="moon" size="16" data-theme-icon="moon" />
                    <x-icon name="sun" size="16" class="hidden" data-theme-icon="sun" />
                    <span data-theme-label>Mode gelap</span>
                </button>

                @auth
                    <x-button variant="secondary" :href="route('admin.dashboard')" class="flex-1">
                        Dashboard
                    </x-button>
                @else
                    <x-button variant="secondary" :href="route('login')" class="flex-1">
                        Portal pengurus
                    </x-button>
                @endauth
            </div>
        </div>
    </div>
</header>
