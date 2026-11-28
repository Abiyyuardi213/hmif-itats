<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\WorkProgram;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkProgramController extends Controller
{
    public function index(Request $request): View
    {
        $period = Period::current();
        $divisions = $period ? $period->divisions()->get() : collect();
        $selectedDivision = $request->query('divisi');
        $selectedStatus = $request->query('status');

        $programsQuery = WorkProgram::query()
            ->with('division')
            ->when($period, fn ($q) => $q->where('period_id', $period->id))
            ->when($selectedDivision, function ($q) use ($selectedDivision) {
                $q->whereHas('division', fn ($dq) => $dq->where('slug', $selectedDivision));
            })
            ->when(in_array($selectedStatus, array_keys(WorkProgram::STATUSES), true), function ($q) use ($selectedStatus) {
                $q->where('status', $selectedStatus);
            })
            ->orderByRaw("CASE status WHEN 'in_progress' THEN 1 WHEN 'planned' THEN 2 WHEN 'completed' THEN 3 ELSE 4 END")
            ->orderBy('target_date');

        $programs = $period ? $programsQuery->get() : collect();

        $summary = [
            'total' => $period ? $period->workPrograms()->count() : 0,
            'completed' => $period ? $period->workPrograms()->where('status', 'completed')->count() : 0,
            'in_progress' => $period ? $period->workPrograms()->where('status', 'in_progress')->count() : 0,
            'planned' => $period ? $period->workPrograms()->where('status', 'planned')->count() : 0,
        ];

        return view('pages.proker', compact(
            'period',
            'divisions',
            'programs',
            'summary',
            'selectedDivision',
            'selectedStatus'
        ));
    }
}
