<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\AllPatient;
use App\Models\Patient;
use App\Models\User;
use App\Models\Usertype;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('files', function ($app) {
            return new Filesystem;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            // التحقق من وجود الجدول والبيانات
            try {
                if (!Usertype::exists() || Usertype::count() === 0) {
                    Artisan::call('migrate:fresh --seed');
                }
            } catch (\Exception $e) {
                Artisan::call('migrate:fresh --seed');
            }
        }

        View::composer('*', function ($view) {
            $todayCount = AllPatient::whereDate('created_at', Carbon::today())->count();
            $totalPatients = AllPatient::count();

            $view->with('todayCount', $todayCount);
            $view->with('totalPatients', $totalPatients);
        });

        Paginator::useBootstrap();

        $waitingListCount = Patient::count();
        View::share('waitingListCount', $waitingListCount); 
    }
}
