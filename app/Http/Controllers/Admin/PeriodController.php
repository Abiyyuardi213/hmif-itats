<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeriodController extends Controller
{
    public function index(): View
    {
        $periods = Period::query()->withCount(['divisions', 'boardMembers', 'workPrograms'])->latest('id')->get();

        return view('admin.periods.index', compact('periods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePeriod($request);

        $period = DB::transaction(function () use ($validated) {
            if ($validated['is_active']) {
                Period::query()->update(['is_active' => false]);
            }

            return Period::create($validated);
        });

        AuditLogger::record('period.created', "Menambahkan periode {$period->name}", $period);

        return redirect()->route('admin.periods.index')->with('success', 'Periode kepengurusan berhasil ditambahkan.');
    }

    public function edit(Period $period): View
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function update(Request $request, Period $period): RedirectResponse
    {
        $validated = $this->validatePeriod($request, $period->id);

        DB::transaction(function () use ($period, $validated): void {
            if ($validated['is_active']) {
                Period::query()->whereKeyNot($period->id)->update(['is_active' => false]);
            }

            $period->update($validated);
        });

        AuditLogger::record('period.updated', "Memperbarui periode {$period->name}", $period);

        return redirect()->route('admin.periods.index')->with('success', 'Periode kepengurusan berhasil diperbarui.');
    }

    public function activate(Period $period): RedirectResponse
    {
        DB::transaction(function () use ($period): void {
            Period::query()->update(['is_active' => false]);
            $period->update(['is_active' => true]);
        });

        AuditLogger::record('period.activated', "Mengaktifkan periode {$period->name}", $period);

        return redirect()->route('admin.periods.index')->with('success', "Periode {$period->name} kini menjadi periode aktif.");
    }

    private function validatePeriod(Request $request, ?int $ignoreId = null): array
    {
        $uniqueRule = 'unique:periods,name'.($ignoreId ? ",{$ignoreId}" : '');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:32', $uniqueRule],
            'cabinet_name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'vision' => ['required', 'string', 'max:2000'],
            'mission_text' => ['required', 'string', 'max:4000'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $missions = array_values(array_filter(
            array_map('trim', preg_split("/\r\n|\n|\r/", $data['mission_text']) ?: [])
        ));

        return [
            'name' => $data['name'],
            'cabinet_name' => $data['cabinet_name'],
            'tagline' => $data['tagline'] ?? null,
            'vision' => $data['vision'],
            'mission' => $missions,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
