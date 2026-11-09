<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $unreadNotificationCount = 0;

            if (Auth::check() && Auth::user()->role === 'user') {
                $unreadNotificationCount = Notification::where(
                    'user_id',
                    Auth::id()
                )
                ->where('is_read', false)
                ->count();
            }

            $view->with(
                'unreadNotificationCount',
                $unreadNotificationCount
            );
        });
    }
}
