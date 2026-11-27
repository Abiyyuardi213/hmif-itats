<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\BoardMember;
use App\Models\Election;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $period = Period::current();

        $stats = [
            'divisions' => $period ? $period->divisions()->count() : 0,
            'programs' => $period ? $period->workPrograms()->count() : 0,
            'completed_programs' => $period ? $period->workPrograms()->where('status', 'completed')->count() : 0,
            'activities' => Activity::query()->published()->count(),
        ];

        $divisions = $period
            ? $period->divisions()->withCount('workPrograms')->get()
            : collect();

        $latestActivities = Activity::query()
            ->published()
            ->latest('event_date')
            ->limit(3)
            ->get();

        $latestAnnouncements = Announcement::query()
            ->published()
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $openElection = Election::query()
            ->where('status', Election::STATUS_OPEN)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->latest('id')
            ->first();

        return view('pages.home', compact(
            'period',
            'stats',
            'divisions',
            'latestActivities',
            'latestAnnouncements',
            'openElection'
        ));
    }

    public function about(): View
    {
        $period = Period::current();
        $coreMembers = $period
            ? $period->boardMembers()->where('is_core', true)->get()
            : collect();
        $allPeriods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();

        return view('pages.about', compact('period', 'coreMembers', 'allPeriods'));
    }

    public function struktur(Request $request): View
    {
        $allPeriods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $requestedPeriod = $request->query('periode');

        $selectedPeriod = $requestedPeriod
            ? $allPeriods->firstWhere('name', $requestedPeriod)
            : null;
        $selectedPeriod ??= Period::current();

        $coreMembers = collect();
        $divisions = collect();

        if ($selectedPeriod) {
            $coreMembers = BoardMember::query()
                ->where('period_id', $selectedPeriod->id)
                ->where('is_core', true)
                ->orderBy('sort_order')
                ->get();

            $divisions = $selectedPeriod->divisions()
                ->with(['members' => fn ($q) => $q->orderBy('sort_order')])
                ->get();
        }

        return view('pages.struktur', compact(
            'allPeriods',
            'selectedPeriod',
            'coreMembers',
            'divisions'
        ));
    }
}
