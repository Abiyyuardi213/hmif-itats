@extends('layouts.app')

@section('title', 'Masuk Portal Pengurus — HMIF ITATS')
@section('meta_description', 'Halaman autentikasi pengurus resmi HMIF ITATS.')

@section('content')
    <section class="py-16 bg-surface min-h-[70vh] flex items-center">
        <div class="mx-auto w-full max-w-md px-4">
            <div class="rounded-2xl border border-line bg-white p-8 shadow-sm">
                <div class="font-mono text-xs uppercase tracking-wider text-brand-600 font-semibold">Akses Terbatas</div>
                <h1 class="mt-2 font-display text-2xl font-extrabold text-ink-950">Portal Pengurus HMIF</h1>
                <p class="mt-1.5 text-sm text-ink-500">
                    Masuk menggunakan akun pengurus atau panitia pemilu yang terdaftar.
                </p>

                <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-ink-900 mb-1.5">Email Pengurus</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-ink-900 mb-1.5">Kata Sandi</label>
                        <input type="password" id="password" name="password" required
                            class="w-full rounded-xl border border-line bg-surface px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2 text-ink-700">
                            <input type="checkbox" name="remember" class="rounded border-line text-brand-600">
                            <span>Ingat sesi ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-ink-950 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-600 transition">
                        Masuk ke Console
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
