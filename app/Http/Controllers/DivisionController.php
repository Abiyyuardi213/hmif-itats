<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Period;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $period = Period::current();
        $divisions = $period
            ? $period->divisions()
                ->with(['members' => fn ($q) => $q->orderBy('sort_order')])
                ->withCount(['members', 'workPrograms'])
                ->get()
            : collect();

        return view('pages.divisi.index', compact('period', 'divisions'));
    }

    public function show(string $slug): View
    {
        $period = Period::current();

        $division = Division::query()
            ->when($period, fn ($q) => $q->where('period_id', $period->id))
            ->where('slug', $slug)
            ->with([
                'members' => fn ($q) => $q->orderBy('sort_order'),
                'workPrograms' => fn ($q) => $q->orderBy('target_date'),
            ])
            ->firstOrFail();

        return view('pages.divisi.show', compact('period', 'division'));
    }
}
