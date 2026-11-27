@extends('layouts.admin')

@section('title', 'Akun & Role Pengurus')
@section('page_title', 'Manajemen Akun & Hak Akses (RBAC)')
@section('page_subtitle', 'Rekrut maintainer Divisi 6 dan panitia pemilu dengan prinsip least-privilege.')

@section('content')
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <form method="POST" action="{{ route('admin.users.store') }}" class="rounded-2xl border border-line bg-white p-6 space-y-4">
                @csrf
                <h2 class="font-display text-lg font-bold">Tambah Akun Pengurus</h2>
                <div>
                    <label class="block text-xs font-semibold mb-1">Nama</label>
                    <input type="text" name="name" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Email</label>
                    <input type="email" name="email" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Kata Sandi Awal (min 10 karakter)</label>
                    <input type="password" name="password" minlength="10" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Role</label>
                    <select name="role" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
                        @foreach(\App\Models\User::ROLES as $roleKey => $roleLabel)
                            <option value="{{ $roleKey }}">{{ $roleLabel }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Buat Akun</button>
            </form>
        </div>

        <div class="lg:col-span-8 space-y-3">
            @foreach($users as $u)
                <div class="rounded-2xl border border-line bg-white p-4 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <div class="font-display font-bold text-ink-950">
                            {{ $u->name }}
                            @if(! $u->is_active)
                                <span class="ml-2 rounded bg-red-100 px-2 py-0.5 font-mono text-xs text-red-700">NONAKTIF</span>
                            @endif
                        </div>
                        <div class="text-xs text-ink-500">{{ $u->email }}</div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <form method="POST" action="{{ route('admin.users.role', $u) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="rounded-lg border border-line px-2.5 py-1.5 text-xs">
                                @foreach(\App\Models\User::ROLES as $roleKey => $roleLabel)
                                    <option value="{{ $roleKey }}" @selected($u->role === $roleKey)>{{ $roleLabel }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="rounded-lg border border-line px-2.5 py-1.5 text-xs font-semibold">Ubah</button>
                        </form>
                        @if(auth()->id() !== $u->id)
                            <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">
                                    {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
