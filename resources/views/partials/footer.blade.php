<footer class="bg-ink-950 text-slate-300 border-t border-slate-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/hima.png') }}" alt="Logo HMIF ITATS" class="h-11 w-11 rounded-xl bg-white p-1.5 object-contain">
                    <div>
                        <div class="font-display text-lg font-bold text-white">
                            {{ $orgSettings['org_name'] ?? 'Himpunan Mahasiswa Teknik Informatika' }}
                        </div>
                        <div class="text-xs font-mono uppercase tracking-wider text-cyan-400">
                            {{ $orgSettings['campus_name'] ?? 'Institut Teknologi Adhi Tama Surabaya' }}
                        </div>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-slate-400 max-w-md">
                    Wadah pengembangan kompetensi akademik, rekayasa perangkat lunak, kepemimpinan, dan kolaborasi mahasiswa Teknik Informatika ITATS.
                </p>

                @php
                    $socialLinks = array_filter([
                        'Instagram' => $orgSettings['instagram_url'] ?? '',
                        'GitHub' => $orgSettings['github_url'] ?? '',
                        'LinkedIn' => $orgSettings['linkedin_url'] ?? '',
                        'YouTube' => $orgSettings['youtube_url'] ?? '',
                    ]);
                @endphp

                @if(! empty($socialLinks))
                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach($socialLinks as $label => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-700 bg-slate-900/70 px-3 py-1.5 text-xs font-medium text-slate-200 hover:border-cyan-500 hover:text-white transition">
                                <span>{{ $label }}</span>
                                <span aria-hidden="true">&#8599;</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:col-span-3">
                <h2 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-4">Navigasi Portal</h2>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">Tentang HMIF</a></li>
                    <li><a href="{{ route('struktur') }}" class="hover:text-white transition">Struktur Kepengurusan</a></li>
                    <li><a href="{{ route('divisi.index') }}" class="hover:text-white transition">Enam Divisi</a></li>
                    <li><a href="{{ route('proker.index') }}" class="hover:text-white transition">Program Kerja</a></li>
                    <li><a href="{{ route('kegiatan.index') }}" class="hover:text-white transition">Kegiatan</a></li>
                    <li><a href="{{ route('pengumuman.index') }}" class="hover:text-white transition">Pengumuman</a></li>
                    <li><a href="{{ route('pemilu.index') }}" class="hover:text-white transition">Pemilu &amp; Arsip</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h2 class="font-display text-sm font-bold uppercase tracking-wider text-white mb-4">Sekretariat &amp; Kontak</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-mono uppercase text-slate-500">Email Resmi</dt>
                        <dd>
                            <a href="mailto:{{ $orgSettings['email'] ?? 'hmif@itats.ac.id' }}" class="text-slate-200 hover:text-cyan-400 transition">
                                {{ $orgSettings['email'] ?? 'hmif@itats.ac.id' }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-mono uppercase text-slate-500">Telepon Kampus</dt>
                        <dd class="text-slate-200">{{ $orgSettings['phone'] ?? '+62 31 5991101' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-mono uppercase text-slate-500">Alamat</dt>
                        <dd class="text-slate-300 leading-relaxed">
                            {{ $orgSettings['address'] ?? 'Jl. Arief Rachman Hakim No. 100, Surabaya 60117' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <p>
                &copy; {{ date('Y') }} <strong class="text-slate-200">HMIF ITATS</strong> — Institut Teknologi Adhi Tama Surabaya.
            </p>
            <div class="flex items-center gap-5">
                <a href="{{ route('kontak') }}" class="hover:text-white transition">Kirim Aspirasi</a>
                <a href="{{ route('sitemap') }}" class="hover:text-white transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
