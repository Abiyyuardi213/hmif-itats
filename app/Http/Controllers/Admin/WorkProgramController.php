<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Period;
use App\Models\WorkProgram;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WorkProgramController extends Controller
{
    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $divisions = Division::query()->with('period')->orderBy('sort_order')->get();
        $programs = WorkProgram::query()->with(['period', 'division'])->latest('id')->get();

        return view('admin.proker.index', compact('periods', 'divisions', 'programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'division_id' => ['required', 'exists:divisions,id'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['required', Rule::in(array_keys(WorkProgram::STATUSES))],
            'target_date' => ['nullable', 'date'],
            'realized_at' => ['nullable', 'date'],
            'target_participants' => ['nullable', 'integer', 'min:1', 'max:50000'],
        ]);

        $validated['slug'] = $this->uniqueSlug((int) $validated['period_id'], $validated['title']);
        $program = WorkProgram::create($validated);

        AuditLogger::record('proker.created', "Menambahkan program kerja {$program->title}", $program);

        return redirect()->route('admin.proker.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(WorkProgram $proker): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $divisions = Division::query()->with('period')->orderBy('sort_order')->get();

        return view('admin.proker.edit', compact('proker', 'periods', 'divisions'));
    }

    public function update(Request $request, WorkProgram $proker): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'division_id' => ['required', 'exists:divisions,id'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['required', Rule::in(array_keys(WorkProgram::STATUSES))],
            'target_date' => ['nullable', 'date'],
            'realized_at' => ['nullable', 'date'],
            'target_participants' => ['nullable', 'integer', 'min:1', 'max:50000'],
        ]);

        if ($proker->title !== $validated['title']) {
            $validated['slug'] = $this->uniqueSlug((int) $validated['period_id'], $validated['title'], $proker->id);
        }

        $proker->update($validated);
        AuditLogger::record('proker.updated', "Memperbarui program kerja {$proker->title}", $proker);

        return redirect()->route('admin.proker.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(WorkProgram $proker): RedirectResponse
    {
        $title = $proker->title;
        $proker->delete();

        AuditLogger::record('proker.deleted', "Menghapus program kerja {$title}");

        return redirect()->route('admin.proker.index')->with('success', 'Program kerja berhasil dihapus.');
    }

    private function uniqueSlug(int $periodId, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (
            WorkProgram::query()
                ->where('period_id', $periodId)
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
