<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard Pengurus') — HMIF ITATS</title>
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-ink-950">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <aside class="w-full lg:w-68 bg-ink-950 text-slate-200 flex-shrink-0 border-b lg:border-b-0 lg:border-r border-slate-800">
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('image/hima.png') }}" alt="Logo HMIF ITATS" class="h-9 w-9 rounded-lg object-contain bg-white p-1">
                    <div>
                        <div class="font-display text-sm font-bold text-white leading-tight">HMIF Console</div>
                        <div class="font-mono text-[11px] text-cyan-400">DIV-06 / PANEL</div>
                    </div>
                </a>
                <a href="{{ route('home') }}" class="text-xs font-mono text-slate-300 hover:text-white border border-slate-700 px-2.5 py-1 rounded-md">
                    Portal
                </a>
            </div>

            <nav class="p-4 space-y-1 text-sm">
                @php
                    $navLink = fn (string $pattern) => request()->routeIs($pattern)
                        ? 'bg-brand-600 text-white font-semibold'
                        : 'text-slate-300 hover:bg-slate-800/80 hover:text-white';
                @endphp

                <a href="{{ route('admin.dashboard') }}" class="block px-3.5 py-2.5 rounded-lg transition {{ $navLink('admin.dashboard') }}">
                    Ringkasan Sistem
                </a>

                @if(auth()->user()->canManageOrganization())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-slate-400">Organisasi</div>
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
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-slate-400">Publikasi</div>
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
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-slate-400">Pemilu Raya</div>
                    <a href="{{ route('admin.pemilu.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.pemilu.*') }}">
                        E-Voting &amp; DPT
                    </a>
                @endif

                @if(auth()->user()->isSuperAdmin())
                    <div class="pt-3 pb-1 px-3.5 text-[11px] font-mono uppercase tracking-wider text-slate-400">Tata Kelola</div>
                    <a href="{{ route('admin.users.index') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.users.*') }}">
                        Akun &amp; Role Pengurus
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="block px-3.5 py-2 rounded-lg transition {{ $navLink('admin.settings.*') }}">
                        Pengaturan Portal
                    </a>
                @endif
            </nav>

            <div class="p-4 mt-auto border-t border-slate-800 text-xs">
                <div class="font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="font-mono text-cyan-400 text-[11px] mb-3">{{ auth()->user()->roleLabel() }}</div>
                <button type="button" data-modal-open="logoutModal" class="w-full text-left px-3 py-2 rounded-lg bg-slate-800 hover:bg-red-600/90 text-slate-200 hover:text-white transition font-medium">
                    Keluar dari Panel
                </button>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-line px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="font-display text-xl font-bold text-ink-950">@yield('page_title', 'Dashboard')</h1>
                    @hasSection('page_subtitle')
                        <p class="text-sm text-ink-500 mt-0.5">@yield('page_subtitle')</p>
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
