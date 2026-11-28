<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard Pengurus') — HMIF ITATS</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <aside class="w-full lg:w-68 bg-band text-band-text flex-shrink-0 border-b lg:border-b-0 lg:border-r border-border">
            <div class="p-5 border-b border-border flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-plate p-1 border border-border">
                        <img src="{{ asset('image/icon-hmif.jpg') }}" alt="Logo HMIF ITATS" width="28" height="28" class="h-7 w-7 rounded object-contain">
                    </span>
                    <div>
                        <div class="font-display text-sm font-bold text-band-text leading-tight">HMIF Console</div>
                        <div class="font-mono text-[11px] text-on-band">PANEL PENGURUS</div>
                    </div>
                </a>
                <a href="{{ route('home') }}" class="min-h-11 inline-flex items-center text-xs font-mono text-band-muted hover:text-band-text border border-border px-2.5 py-1 rounded-md">
                    Portal
                </a>
            </div>

            <nav class="p-4 space-y-1 text-sm" aria-label="Menu admin">
                @php
                    $navLink = fn (string $pattern) => request()->routeIs($pattern)
                        ? 'bg-primary text-on-primary font-semibold'
                        : 'text-band-muted hover:bg-surface/10 hover:text-band-text';
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="block px-3.5 py-2.5 rounded-lg transition {{ $navLink('admin.dashboard') }}">
                    Ringkasan Sistem
                </a>

                @if(auth()->user()->canManageOrganization())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-band-muted">Organisasi</div>
                    <a href="{{ route('admin.periods.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.periods.*') }}">
                        Periode &amp; Kabinet
                    </a>
                    <a href="{{ route('admin.divisions.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.divisions.*') }}">
                        Divisi &amp; Bidang
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.members.*') }}">
                        Pengurus (Tanpa NPM)
                    </a>
                    <a href="{{ route('admin.proker.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.proker.*') }}">
                        Program Kerja
                    </a>
                @endif

                @if(auth()->user()->canManageContent())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-band-muted">Publikasi</div>
                    <a href="{{ route('admin.kegiatan.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.kegiatan.*') }}">
                        Kegiatan &amp; Agenda
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.pengumuman.*') }}">
                        Pengumuman Resmi
                    </a>
                    <a href="{{ route('admin.pesan.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.pesan.*') }}">
                        Pesan Kontak
                    </a>
                @endif

                @if(auth()->user()->canManageElection())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-band-muted">Pemilu Raya</div>
                    <a href="{{ route('admin.pemilu.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.pemilu.*') }}">
                        E-Voting &amp; DPT
                    </a>
                @endif

                @if(auth()->user()->isSuperAdmin())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-band-muted">Tata Kelola</div>
                    <a href="{{ route('admin.users.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.users.*') }}">
                        Akun &amp; Role Pengurus
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.settings.*') }}">
                        Pengaturan Portal
                    </a>
                @endif
            </nav>

            <div class="p-4 mt-auto border-t border-border text-xs">
                <div class="font-semibold text-band-text truncate">{{ auth()->user()->name }}</div>
                <div class="font-mono text-on-band text-[11px] mb-3">{{ auth()->user()->roleLabel() }}</div>
                <button type="button" data-modal-open="logoutModal" class="w-full min-h-11 text-left px-3 py-2 rounded-lg border border-border text-band-text hover:bg-danger/20 transition font-medium">
                    Keluar dari Panel
                </button>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-surface border-b border-border px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="font-display text-xl font-bold text-text">@yield('page_title', 'Dashboard')</h1>
                    @hasSection('page_subtitle')
                        <p class="text-sm text-text-muted mt-0.5">@yield('page_subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @yield('header_actions')
                </div>
            </header>

            <main class="flex-1 p-6">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.logout-modal')
</body>
</html>
