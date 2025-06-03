<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CenterDetails;
use App\Models\deduction;
use App\Models\Permission;
use App\Models\Vacation;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('center', CenterDetails::first());
        });

        // تنبيه اذن العمل
        View::composer('*', function ($view) {
            $hasUnsignedPermissions = Permission::whereNull('signature')->exists();
            $view->with('hasUnsignedPermissions', $hasUnsignedPermissions);
        });

        // تنبية اجازة العمل
        View::composer('*', function ($view) {
            $hasUnsignedVacations = Vacation::whereNull('signature')->exists();
            $view->with('hasUnsignedVacations', $hasUnsignedVacations);
        });

        // تنبية خصومات العمل
        View::composer('*', function ($view) {
            $hasUnsigneddeductions = deduction::whereNull('signature_objection_admin')->exists();
            $view->with('hasUnsigneddeductions', $hasUnsigneddeductions);
        });
    }
}
