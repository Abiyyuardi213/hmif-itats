<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = OrganizationSetting::allCached();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'org_name' => ['required', 'string', 'max:160'],
            'org_short_name' => ['required', 'string', 'max:60'],
            'campus_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'hero_headline' => ['required', 'string', 'max:180'],
            'hero_subtitle' => ['required', 'string', 'max:320'],
        ]);

        OrganizationSetting::setMany(array_map(fn ($v) => $v ?? '', $validated));
        AuditLogger::record('settings.updated', 'Memperbarui pengaturan portal HMIF ITATS');

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan portal berhasil disimpan.');
    }
}
