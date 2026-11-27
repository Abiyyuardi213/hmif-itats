<?php

namespace App\Providers;

use App\Models\Election;
use App\Models\OrganizationSetting;
use App\Models\Period;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.*', 'partials.*'], function ($view): void {
            $settings = [];
            $activePeriod = null;
            $openElection = null;

            try {
                if (Schema::hasTable('organization_settings')) {
                    $settings = OrganizationSetting::allCached();
                }
                if (Schema::hasTable('periods')) {
                    $activePeriod = Period::current();
                }
                if (Schema::hasTable('elections')) {
                    $openElection = Election::query()
                        ->where('status', Election::STATUS_OPEN)
                        ->where('starts_at', '<=', now())
                        ->where('ends_at', '>=', now())
                        ->latest('id')
                        ->first();
                }
            } catch (Throwable) {
                // Keep view rendering resilient if database is not yet initialized.
            }

            $view->with([
                'orgSettings' => $settings,
                'activePeriod' => $activePeriod,
                'openElection' => $openElection,
            ]);
        });
    }
}
