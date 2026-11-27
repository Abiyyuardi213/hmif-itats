@php
    $isNavActive = fn (string $pattern) => request()->routeIs($pattern)
        ? 'text-brand-600 bg-brand-50 font-semibold'
        : 'text-ink-700 hover:text-brand-600 hover:bg-slate-100';
@endphp

<header class="sticky top-0 z-40 border-b border-line bg-white/95 backdrop-blur-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-18 items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('image/hima.png') }}" alt="Logo HMIF ITATS" class="h-10 w-10 object-contain transition group-hover:scale-105">
                <div class="leading-tight">
                    <span class="block font-display text-base font-extrabold tracking-tight text-ink-950">HMIF ITATS</span>
                    <span class="hidden sm:block text-xs font-medium text-ink-500">Teknik Informatika Surabaya</span>
                </div>
            </a>

            <nav aria-label="Navigasi utama" class="hidden lg:flex items-center gap-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg transition {{ $isNavActive('home') }}">
                    Beranda
                </a>
                <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-lg transition {{ $isNavActive('about') }}">
                    Tentang
                </a>

                <div class="relative">
                    <button type="button" data-dropdown-toggle="orgDropdown" aria-expanded="false"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg transition {{ request()->routeIs(['struktur', 'divisi.*', 'proker.*', 'pemilu.*']) ? 'text-brand-600 bg-brand-50 font-semibold' : 'text-ink-700 hover:text-brand-600 hover:bg-slate-100' }}">
                        <span>Organisasi</span>
                        <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="orgDropdown" data-dropdown-panel class="hidden absolute left-0 mt-2 w-60 rounded-xl border border-line bg-white p-1.5 shadow-xl shadow-slate-900/10">
                        <a href="{{ route('struktur') }}" class="block rounded-lg px-3.5 py-2.5 text-sm text-ink-700 hover:bg-brand-50 hover:text-brand-700">
                            <div class="font-semibold">Struktur Kepengurusan</div>
                            <div class="text-xs text-ink-500">BPH Inti &amp; Pengurus Periode</div>
                        </a>
                        <a href="{{ route('divisi.index') }}" class="block rounded-lg px-3.5 py-2.5 text-sm text-ink-700 hover:bg-brand-50 hover:text-brand-700">
                            <div class="font-semibold">Enam Divisi</div>
                            <div class="text-xs text-ink-500">Profil bidang kerja HMIF</div>
                        </a>
                        <a href="{{ route('proker.index') }}" class="block rounded-lg px-3.5 py-2.5 text-sm text-ink-700 hover:bg-brand-50 hover:text-brand-700">
                            <div class="font-semibold">Program Kerja</div>
                            <div class="text-xs text-ink-500">Progres &amp; realisasi kabinet</div>
                        </a>
                        <a href="{{ route('pemilu.index') }}" class="block rounded-lg px-3.5 py-2.5 text-sm text-ink-700 hover:bg-brand-50 hover:text-brand-700">
                            <div class="font-semibold">Pemilu &amp; Arsip Suara</div>
                            <div class="text-xs text-ink-500">{{ $openElection ? 'Pemilihan sedang berlangsung' : 'Status & arsip hasil pemilu' }}</div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('kegiatan.index') }}" class="px-3.5 py-2 rounded-lg transition {{ $isNavActive('kegiatan.*') }}">
                    Kegiatan
                </a>
                <a href="{{ route('pengumuman.index') }}" class="px-3.5 py-2 rounded-lg transition {{ $isNavActive('pengumuman.*') }}">
                    Pengumuman
                </a>
                <a href="{{ route('kontak') }}" class="px-3.5 py-2 rounded-lg transition {{ $isNavActive('kontak') }}">
                    Kontak
                </a>

                @if($openElection)
                    <a href="{{ route('pemilu.index') }}" class="ml-1 inline-flex items-center gap-1.5 rounded-full bg-emerald-600 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                        <span class="h-2 w-2 rounded-full bg-emerald-200 animate-pulse"></span>
                        E-Voting Aktif
                    </a>
                @endif
            </nav>

            <div class="hidden lg:flex items-center gap-2.5">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-line bg-white px-3.5 py-2 text-sm font-semibold text-ink-950 hover:bg-slate-50 transition">
                        Dashboard
                    </a>
                    <button type="button" data-modal-open="logoutModal" class="rounded-lg bg-ink-950 px-3.5 py-2 text-sm font-semibold text-white hover:bg-ink-900 transition">
                        Keluar
                    </button>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-ink-950 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600 transition">
                        Portal Pengurus
                    </a>
                @endauth
            </div>

            <button type="button" data-mobile-menu-toggle aria-expanded="false" aria-label="Buka menu navigasi"
                class="lg:hidden inline-flex items-center justify-center rounded-lg border border-line p-2 text-ink-700 hover:bg-slate-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div data-mobile-menu class="hidden lg:hidden border-t border-line py-4 space-y-1 text-sm font-medium">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('home') }}">Beranda</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('about') }}">Tentang</a>
            <a href="{{ route('struktur') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('struktur') }}">Struktur Organisasi</a>
            <a href="{{ route('divisi.index') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('divisi.*') }}">Divisi</a>
            <a href="{{ route('proker.index') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('proker.*') }}">Program Kerja</a>
            <a href="{{ route('kegiatan.index') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('kegiatan.*') }}">Kegiatan</a>
            <a href="{{ route('pengumuman.index') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('pengumuman.*') }}">Pengumuman</a>
            <a href="{{ route('pemilu.index') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('pemilu.*') }}">
                {{ $openElection ? 'E-Voting (Aktif)' : 'Pemilu & Arsip' }}
            </a>
            <a href="{{ route('kontak') }}" class="block px-3 py-2 rounded-lg {{ $isNavActive('kontak') }}">Kontak</a>

            <div class="pt-3 mt-3 border-t border-line flex gap-2">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center rounded-lg border border-line px-3 py-2 font-semibold">Dashboard</a>
                    <button type="button" data-modal-open="logoutModal" class="flex-1 rounded-lg bg-ink-950 px-3 py-2 font-semibold text-white">Keluar</button>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center rounded-lg bg-ink-950 px-3 py-2 font-semibold text-white">Portal Pengurus</a>
                @endauth
            </div>
        </div>
    </div>
</header>
