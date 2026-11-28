<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Period;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $announcements = Announcement::query()->with('period')->orderByDesc('is_pinned')->latest('published_at')->get();

        return view('admin.pengumuman.index', compact('periods', 'announcements'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['nullable', 'exists:periods,id'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:64'],
            'published_at' => ['nullable', 'date'],
            'excerpt' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string', 'max:15000'],
        ]);

        $announcement = Announcement::create([
            'period_id' => $validated['period_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'category' => $validated['category'],
            'published_at' => $validated['published_at'] ?? now(),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'is_pinned' => $request->boolean('is_pinned'),
            'is_published' => $request->boolean('is_published', true),
        ]);

        AuditLogger::record('announcement.created', "Menerbitkan pengumuman {$announcement->title}", $announcement);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $pengumuman): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();

        return view('admin.pengumuman.edit', compact('pengumuman', 'periods'));
    }

    public function update(Request $request, Announcement $pengumuman): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['nullable', 'exists:periods,id'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:64'],
            'published_at' => ['nullable', 'date'],
            'excerpt' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string', 'max:15000'],
        ]);

        $pengumuman->update([
            'period_id' => $validated['period_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $pengumuman->title !== $validated['title'] ? $this->uniqueSlug($validated['title'], $pengumuman->id) : $pengumuman->slug,
            'category' => $validated['category'],
            'published_at' => $validated['published_at'] ?? $pengumuman->published_at ?? now(),
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'is_pinned' => $request->boolean('is_pinned'),
            'is_published' => $request->boolean('is_published'),
        ]);

        AuditLogger::record('announcement.updated', "Memperbarui pengumuman {$pengumuman->title}", $pengumuman);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $pengumuman): RedirectResponse
    {
        $title = $pengumuman->title;
        $pengumuman->delete();

        AuditLogger::record('announcement.deleted', "Menghapus pengumuman {$title}");

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (Announcement::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
