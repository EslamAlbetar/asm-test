<?php

namespace App\Http;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('financial:update')->everyMinute(); // ممكن تخليها daily() لو حبيت
    }

    protected $routeMiddleware = [
        'check.page' => \App\Http\Middleware\CheckPage::class,
        'admin' => \App\Http\Middleware\Admin::class,
        // ... other middlewares
    ];
}
