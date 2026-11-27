<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('kategori');

        $categories = Announcement::query()
            ->published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $announcements = Announcement::query()
            ->published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('pages.pengumuman.index', compact('announcements', 'categories', 'category'));
    }

    public function show(string $slug): View
    {
        $announcement = Announcement::query()
            ->published()
            ->with('period')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.pengumuman.show', compact('announcement'));
    }
}
