<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Models\Division;
use App\Models\Period;
use App\Services\AuditLogger;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoardMemberController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $divisions = Division::query()->with('period')->orderBy('sort_order')->get();
        $members = BoardMember::query()->with(['period', 'division'])->orderByDesc('period_id')->orderBy('sort_order')->get();

        return view('admin.members.index', compact('periods', 'divisions', 'members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:120'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = $request->hasFile('photo')
            ? $this->media->storeImage($request->file('photo'), 'members', 600)
            : null;

        $member = BoardMember::create([
            'period_id' => $validated['period_id'],
            'division_id' => $validated['division_id'] ?? null,
            'name' => $validated['name'],
            'position' => $validated['position'],
            'is_core' => $request->boolean('is_core'),
            'photo_path' => $photoPath,
            'sort_order' => $validated['sort_order'],
        ]);

        AuditLogger::record('member.created', "Menambahkan pengurus {$member->name}", $member);

        return redirect()->route('admin.members.index')->with('success', 'Data pengurus berhasil ditambahkan (tanpa NPM publik).');
    }

    public function edit(BoardMember $member): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $divisions = Division::query()->with('period')->orderBy('sort_order')->get();

        return view('admin.members.edit', compact('member', 'periods', 'divisions'));
    }

    public function update(Request $request, BoardMember $member): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:120'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = $member->photo_path;
        if ($request->hasFile('photo')) {
            $this->media->deleteIfManaged($member->photo_path);
            $photoPath = $this->media->storeImage($request->file('photo'), 'members', 600);
        }

        $member->update([
            'period_id' => $validated['period_id'],
            'division_id' => $validated['division_id'] ?? null,
            'name' => $validated['name'],
            'position' => $validated['position'],
            'is_core' => $request->boolean('is_core'),
            'photo_path' => $photoPath,
            'sort_order' => $validated['sort_order'],
        ]);

        AuditLogger::record('member.updated', "Memperbarui pengurus {$member->name}", $member);

        return redirect()->route('admin.members.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(BoardMember $member): RedirectResponse
    {
        $name = $member->name;
        $this->media->deleteIfManaged($member->photo_path);
        $member->delete();

        AuditLogger::record('member.deleted', "Menghapus pengurus {$name}");

        return redirect()->route('admin.members.index')->with('success', 'Data pengurus berhasil dihapus.');
    }
}
