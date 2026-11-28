<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Election;
use App\Models\Period;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activePeriod = Period::current();

        $metrics = [
            'period_name' => $activePeriod?->name ?? '-',
            'divisions' => $activePeriod ? $activePeriod->divisions()->count() : 0,
            'members' => $activePeriod ? $activePeriod->boardMembers()->count() : 0,
            'programs' => $activePeriod ? $activePeriod->workPrograms()->count() : 0,
            'activities' => Activity::query()->count(),
            'announcements' => Announcement::query()->count(),
            'unread_messages' => ContactMessage::query()->where('status', 'unread')->count(),
        ];

        $latestElection = Election::query()->latest('id')->first();
        $recentLogs = ActivityLog::query()->with('user')->latest('created_at')->limit(12)->get();

        return view('admin.dashboard', compact('activePeriod', 'metrics', 'latestElection', 'recentLogs'));
    }
}
