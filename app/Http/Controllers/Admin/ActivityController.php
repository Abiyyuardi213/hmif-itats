<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Period;
use App\Models\WorkProgram;
use App\Services\AuditLogger;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function index(): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $programs = WorkProgram::query()->with('division')->latest('id')->get();
        $activities = Activity::query()->with(['period', 'workProgram'])->latest('event_date')->get();

        return view('admin.kegiatan.index', compact('periods', 'programs', 'activities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'work_program_id' => ['nullable', 'exists:work_programs,id'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:64'],
            'event_date' => ['required', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:2035-12-31'],
            'location' => ['nullable', 'string', 'max:180'],
            'summary' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string', 'max:15000'],
            'registration_url' => ['nullable', 'url', 'max:255'],
            'cover' => ['nullable', 'image', 'max:3072'],
        ]);

        $coverPath = $request->hasFile('cover')
            ? $this->media->storeImage($request->file('cover'), 'activities', 1400)
            : null;

        $activity = Activity::create([
            'period_id' => $validated['period_id'],
            'work_program_id' => $validated['work_program_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'category' => $validated['category'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? null,
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'registration_url' => $validated['registration_url'] ?? null,
            'cover_image' => $coverPath,
            'is_published' => $request->boolean('is_published', true),
        ]);

        AuditLogger::record('activity.created', "Menambahkan kegiatan {$activity->title}", $activity);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $kegiatan): View
    {
        $periods = Period::query()->orderByDesc('is_active')->orderByDesc('name')->get();
        $programs = WorkProgram::query()->with('division')->latest('id')->get();

        return view('admin.kegiatan.edit', compact('kegiatan', 'periods', 'programs'));
    }

    public function update(Request $request, Activity $kegiatan): RedirectResponse
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'work_program_id' => ['nullable', 'exists:work_programs,id'],
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:64'],
            'event_date' => ['required', 'date', 'after_or_equal:2020-01-01', 'before_or_equal:2035-12-31'],
            'location' => ['nullable', 'string', 'max:180'],
            'summary' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string', 'max:15000'],
            'registration_url' => ['nullable', 'url', 'max:255'],
            'cover' => ['nullable', 'image', 'max:3072'],
        ]);

        $coverPath = $kegiatan->cover_image;
        if ($request->hasFile('cover')) {
            $this->media->deleteIfManaged($kegiatan->cover_image);
            $coverPath = $this->media->storeImage($request->file('cover'), 'activities', 1400);
        }

        $kegiatan->update([
            'period_id' => $validated['period_id'],
            'work_program_id' => $validated['work_program_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $kegiatan->title !== $validated['title'] ? $this->uniqueSlug($validated['title'], $kegiatan->id) : $kegiatan->slug,
            'category' => $validated['category'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? null,
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'registration_url' => $validated['registration_url'] ?? null,
            'cover_image' => $coverPath,
            'is_published' => $request->boolean('is_published'),
        ]);

        AuditLogger::record('activity.updated', "Memperbarui kegiatan {$kegiatan->title}", $kegiatan);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $kegiatan): RedirectResponse
    {
        $title = $kegiatan->title;
        $this->media->deleteIfManaged($kegiatan->cover_image);
        $kegiatan->delete();

        AuditLogger::record('activity.deleted', "Menghapus kegiatan {$title}");

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (Activity::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
