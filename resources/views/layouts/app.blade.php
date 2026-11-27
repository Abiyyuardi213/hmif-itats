<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HMIF ITATS — Himpunan Mahasiswa Teknik Informatika ITATS')</title>
    <meta name="description" content="@yield('meta_description', 'Portal resmi Himpunan Mahasiswa Teknik Informatika (HMIF) Institut Teknologi Adhi Tama Surabaya: program kerja, kegiatan, pengumuman, dan layanan digital mahasiswa.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:site_name" content="HMIF ITATS">
    <meta property="og:title" content="@yield('title', 'HMIF ITATS')">
    <meta property="og:description" content="@yield('meta_description', 'Portal resmi Himpunan Mahasiswa Teknik Informatika Institut Teknologi Adhi Tama Surabaya.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('image/hmif-pmo.jpg'))">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" type="image/png" href="{{ asset('image/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('structured_data')
</head>
<body class="min-h-screen flex flex-col bg-surface text-ink-950 selection:bg-brand-600 selection:text-white">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-lg focus:bg-ink-950 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white">
        Langsung ke konten utama
    </a>

    @include('partials.navbar')

    <main id="main-content" class="flex-1">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.logout-modal')
</body>
</html>
