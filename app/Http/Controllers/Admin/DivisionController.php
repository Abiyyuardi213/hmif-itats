<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Period;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $divisions = Division::query()->with('period')->withCount(['members', 'workPrograms'])->orderByDesc('period_id')->orderBy('sort_order')->get();

        return view('admin.divisions.index', compact('periods', 'divisions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'code' => ['required', 'string', 'max:16'],
            'name' => ['required', 'string', 'max:120'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $division = Division::create($validated);

        AuditLogger::record('division.created', "Menambahkan divisi {$division->name}", $division);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Division $division): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();

        return view('admin.divisions.edit', compact('division', 'periods'));
    }

    public function update(Request $request, Division $division): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'code' => ['required', 'string', 'max:16'],
            'name' => ['required', 'string', 'max:120'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $division->update($validated);

        AuditLogger::record('division.updated', "Memperbarui divisi {$division->name}", $division);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division): RedirectResponse
    {
        $name = $division->name;
        $division->delete();

        AuditLogger::record('division.deleted', "Menghapus divisi {$name}");

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
