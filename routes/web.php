<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\BoardMemberController as AdminBoardMemberController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\ElectionController as AdminElectionController;
use App\Http\Controllers\Admin\PeriodController as AdminPeriodController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WorkProgramController as AdminWorkProgramController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WorkProgramController;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/home', '/', 301);

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/struktur', [HomeController::class, 'struktur'])->name('struktur');

Route::get('/divisi', [DivisionController::class, 'index'])->name('divisi.index');
Route::get('/divisi/{slug}', [DivisionController::class, 'show'])->name('divisi.show');

Route::get('/proker', [WorkProgramController::class, 'index'])->name('proker.index');
Route::redirect('/program', '/proker', 301);

Route::get('/kegiatan', [ActivityController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{slug}', [ActivityController::class, 'show'])->name('kegiatan.show');

Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [AnnouncementController::class, 'show'])->name('pengumuman.show');

Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('kontak.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Public E-Voting Routes (Token-Verified & Anonymous Ballot)
Route::prefix('pemilu')->name('pemilu.')->group(function (): void {
    Route::get('/', [ElectionController::class, 'index'])->name('index');
    Route::post('/request-token', [ElectionController::class, 'requestToken'])
        ->middleware('throttle:6,1')
        ->name('request-token');
    Route::get('/ballot/{token}', [ElectionController::class, 'showBallot'])->name('ballot');
    Route::post('/ballot/{token}', [ElectionController::class, 'castVote'])
        ->middleware('throttle:10,1')
        ->name('cast');
    Route::get('/receipt', [ElectionController::class, 'receipt'])->name('receipt');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::redirect('/login-guest', '/login', 301);
Route::post('/login', [LoginController::class, 'authenticate'])
    ->middleware('throttle:6,1')
    ->name('login.attempt');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Admin Console Routes (RBAC Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:super_admin,admin_sekretariat')->group(function (): void {
        Route::get('/periods', [AdminPeriodController::class, 'index'])->name('periods.index');
        Route::post('/periods', [AdminPeriodController::class, 'store'])->name('periods.store');
        Route::get('/periods/{period}/edit', [AdminPeriodController::class, 'edit'])->name('periods.edit');
        Route::put('/periods/{period}', [AdminPeriodController::class, 'update'])->name('periods.update');
        Route::post('/periods/{period}/activate', [AdminPeriodController::class, 'activate'])->name('periods.activate');

        Route::resource('divisions', AdminDivisionController::class)->except(['create', 'show']);
        Route::resource('members', AdminBoardMemberController::class)->except(['create', 'show']);
        Route::resource('proker', AdminWorkProgramController::class)->except(['create', 'show']);
    });

    Route::middleware('role:super_admin,admin_sekretariat,admin_kominfo')->group(function (): void {
        Route::resource('kegiatan', AdminActivityController::class)->except(['create', 'show']);
        Route::resource('pengumuman', AdminAnnouncementController::class)->except(['create', 'show']);

        Route::get('/pesan', [AdminContactMessageController::class, 'index'])->name('pesan.index');
        Route::post('/pesan/{pesan}/read', [AdminContactMessageController::class, 'markRead'])->name('pesan.read');
        Route::delete('/pesan/{pesan}', [AdminContactMessageController::class, 'destroy'])->name('pesan.destroy');
    });

    Route::middleware('role:super_admin,panitia_pemilu')->group(function (): void {
        Route::get('/pemilu', [AdminElectionController::class, 'index'])->name('pemilu.index');
        Route::post('/pemilu', [AdminElectionController::class, 'store'])->name('pemilu.store');
        Route::get('/pemilu/{pemilu}', [AdminElectionController::class, 'show'])->name('pemilu.show');
        Route::patch('/pemilu/{pemilu}/status', [AdminElectionController::class, 'updateStatus'])->name('pemilu.status');
        Route::post('/pemilu/{pemilu}/candidates', [AdminElectionController::class, 'storeCandidate'])->name('pemilu.candidates.store');
        Route::post('/pemilu/{pemilu}/voters-import', [AdminElectionController::class, 'importVoters'])->name('pemilu.voters.import');
        Route::get('/pemilu/{pemilu}/export', [AdminElectionController::class, 'exportAuditCsv'])->name('pemilu.export');
    });

    Route::middleware('role:super_admin')->group(function (): void {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');
        Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])->name('users.toggle');

        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
