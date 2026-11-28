@extends('layouts.admin')

@section('title', 'Pengaturan Portal')
@section('page_title', 'Pengaturan Umum Portal')
@section('page_subtitle', 'Tautan sosial media yang dikosongkan otomatis disembunyikan dari footer agar tidak memunculkan link mati.')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl rounded-2xl border border-line bg-white p-6 space-y-5">
        @csrf
        @method('PUT')
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold mb-1">Nama Organisasi</label>
                <input type="text" name="org_name" value="{{ old('org_name', $settings['org_name'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Singkatan</label>
                <input type="text" name="org_short_name" value="{{ old('org_short_name', $settings['org_short_name'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Nama Kampus</label>
            <input type="text" name="campus_name" value="{{ old('campus_name', $settings['campus_name'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold mb-1">Email Resmi</label>
                <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Alamat Sekretariat</label>
            <input type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold mb-1">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">GitHub Organization URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $settings['github_url'] ?? '') }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="w-full rounded-lg border border-line px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Headline Hero Beranda</label>
            <input type="text" name="hero_headline" value="{{ old('hero_headline', $settings['hero_headline'] ?? '') }}" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Subjudul Hero Beranda</label>
            <textarea name="hero_subtitle" rows="3" required class="w-full rounded-lg border border-line px-3 py-2 text-sm">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
        </div>
        <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white">Simpan Pengaturan</button>
    </form>
@endsection
