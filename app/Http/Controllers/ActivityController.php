<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('kategori');
        $search = trim((string) $request->query('q', ''));

        $categories = Activity::query()
            ->published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $activities = Activity::query()
            ->published()
            ->with(['period', 'workProgram'])
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest('event_date')
            ->paginate(9)
            ->withQueryString();

        return view('pages.kegiatan.index', compact('activities', 'categories', 'category', 'search'));
    }

    public function show(string $slug): View
    {
        $activity = Activity::query()
            ->published()
            ->with(['period', 'workProgram.division'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Activity::query()
            ->published()
            ->whereKeyNot($activity->id)
            ->latest('event_date')
            ->limit(3)
            ->get();

        return view('pages.kegiatan.show', compact('activity', 'related'));
    }
}
