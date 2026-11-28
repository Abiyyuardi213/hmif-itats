@extends('layouts.app')

@section('title', 'Masuk Portal Pengurus — HMIF ITATS')
@section('meta_description', 'Halaman autentikasi pengurus resmi HMIF ITATS.')

@section('content')
    <section class="py-16 bg-bg min-h-[70vh] flex items-center">
        <div class="mx-auto w-full max-w-md px-4">
            <div class="rounded-[20px] border border-border bg-surface-raised p-8 shadow-card">
                <p class="text-sm font-medium text-link">Akses terbatas pengurus</p>
                <h1 class="mt-2 font-display text-2xl font-bold text-text">Portal pengurus HMIF ITATS</h1>
                <p class="mt-1.5 text-sm text-text-muted">
                    Masuk menggunakan akun pengurus atau panitia pemilu yang terdaftar.
                </p>

                <form method="POST" action="{{ route('login.attempt') }}" data-focus-first-error class="mt-6 space-y-4">
                    @csrf

                    <x-form-field
                        name="email"
                        label="Email pengurus"
                        type="email"
                        autocomplete="email"
                        :required="true"
                        :autofocus="! $errors->any()"
                    />

                    <x-form-field
                        name="password"
                        label="Kata sandi"
                        type="password"
                        autocomplete="current-password"
                        :required="true"
                    />

                    <div class="flex items-center justify-between text-sm">
                        <label class="min-h-11 inline-flex items-center gap-2.5 text-text-muted cursor-pointer">
                            <input
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-border-input accent-primary"
                            >
                            <span>Ingat sesi ini</span>
                        </label>
                    </div>

                    <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
                        Masuk ke console
                    </x-button>
                </form>
            </div>
        </div>
    </section>
@endsection
