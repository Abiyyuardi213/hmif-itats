@php
    $socialLinks = collect([
        'Instagram' => $orgSettings['instagram_url'] ?? '',
        'GitHub' => $orgSettings['github_url'] ?? '',
        'LinkedIn' => $orgSettings['linkedin_url'] ?? '',
        'YouTube' => $orgSettings['youtube_url'] ?? '',
    ])->filter(function (?string $url): bool {
        $trimmed = trim((string) $url);

        return $trimmed !== '' && $trimmed !== '#' && str_starts_with($trimmed, 'http');
    });

    $officialEmail = trim((string) ($orgSettings['email'] ?? ''));
    $officialPhone = trim((string) ($orgSettings['phone'] ?? ''));
    $officialAddress = trim((string) ($orgSettings['address'] ?? ''));
    $openElection = $openElection ?? null;
@endphp

<footer class="bg-band text-band-text border-t border-border-on-band mt-auto">
    <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-[12px] bg-plate p-1.5 border border-border-on-band shrink-0">
                        <img
                            src="{{ asset('image/icon-hmif.jpg') }}"
                            alt="Logo HMIF ITATS"
                            width="40"
                            height="40"
                            loading="lazy"
                            class="h-9 w-9 rounded-md object-contain"
                        >
                    </span>
                    <div>
                        <div class="font-display text-lg font-bold text-band-text">
                            HMIF ITATS
                        </div>
                        <div class="text-xs font-medium text-on-band">
                            {{ $orgSettings['campus_name'] ?? 'Institut Teknologi Adhi Tama Surabaya' }}
                        </div>
                    </div>
                </div>

                <p class="text-sm leading-relaxed text-band-muted max-w-[42ch]">
                    Wadah pengembangan kompetensi akademik, rekayasa perangkat lunak, kepemimpinan, dan kolaborasi mahasiswa Teknik Informatika ITATS.
                </p>

                @if($socialLinks->isNotEmpty())
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach($socialLinks as $label => $url)
                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="min-h-11 inline-flex items-center gap-1.5 rounded-full border border-border-on-band px-4 py-2 text-xs font-medium text-band-text hover:text-on-band transition-colors"
                            >
                                <span>{{ $label }}</span>
                                <x-icon name="arrow-up-right" size="14" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:col-span-3">
                <h2 class="font-display text-sm font-semibold text-band-text mb-3">
                    Navigasi portal
                </h2>
                <ul class="space-y-1 text-sm">
                    <li><a href="{{ route('about') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Tentang HMIF ITATS</a></li>
                    <li><a href="{{ route('struktur') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Struktur organisasi</a></li>
                    <li><a href="{{ route('divisi.index') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Divisi</a></li>
                    <li><a href="{{ route('proker.index') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Program kerja</a></li>
                    <li><a href="{{ route('kegiatan.index') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Kegiatan</a></li>
                    <li><a href="{{ route('pengumuman.index') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">Pengumuman</a></li>
                    <li>
                        <a href="{{ route('pemilu.index') }}" class="min-h-11 inline-flex items-center text-band-muted hover:text-band-text hover:underline">
                            {{ $openElection ? 'Pemilu (berlangsung)' : 'Pemilu dan arsip' }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h2 class="font-display text-sm font-semibold text-band-text mb-3">
                    Sekretariat dan kontak
                </h2>
                @if($officialEmail !== '' || $officialPhone !== '' || $officialAddress !== '')
                    <dl class="space-y-3 text-sm">
                        @if($officialEmail !== '')
                            <div>
                                <dt class="text-xs text-band-muted">Email resmi</dt>
                                <dd>
                                    <a href="mailto:{{ $officialEmail }}" class="min-h-11 inline-flex items-center text-on-band hover:underline">
                                        {{ $officialEmail }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($officialPhone !== '')
                            <div>
                                <dt class="text-xs text-band-muted">Telepon kampus</dt>
                                <dd class="text-band-text">{{ $officialPhone }}</dd>
                            </div>
                        @endif
                        @if($officialAddress !== '')
                            <div>
                                <dt class="text-xs text-band-muted">Alamat</dt>
                                <dd class="text-band-muted leading-relaxed">{{ $officialAddress }}</dd>
                            </div>
                        @endif
                    </dl>
                @else
                    <p class="text-sm text-band-muted leading-relaxed max-w-[36ch]">
                        Saluran pesan resmi organisasi tersedia melalui formulir kontak portal.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('kontak') }}" class="min-h-11 inline-flex items-center gap-1.5 text-sm font-medium text-on-band hover:underline">
                            <span>Kirim pesan lewat Kontak HMIF</span>
                            <x-icon name="arrow-right" size="16" />
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-border-on-band flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs text-band-muted">
            <p>
                &copy; {{ date('Y') }} <strong class="text-band-text">HMIF ITATS</strong> — Institut Teknologi Adhi Tama Surabaya.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('kontak') }}" class="min-h-11 inline-flex items-center hover:text-band-text hover:underline">Kontak HMIF</a>
                <a href="{{ route('sitemap') }}" class="min-h-11 inline-flex items-center hover:text-band-text hover:underline">Peta situs</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="min-h-11 inline-flex items-center hover:text-band-text hover:underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="min-h-11 inline-flex items-center hover:text-band-text hover:underline">Portal pengurus</a>
                @endauth
            </div>
        </div>
    </div>
</footer>
