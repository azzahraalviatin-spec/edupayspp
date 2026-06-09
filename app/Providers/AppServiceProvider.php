<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

 public function boot(): void
{
    View::composer('layouts.admin', function ($view) {
        try {
            if (auth()->check()) {
                $notifDatabase = auth()->user()->unreadNotifications;
            } else {
                $notifDatabase = collect();
            }
        } catch (\Exception $e) {
            $notifDatabase = collect();
        }

        $view->with('notifDatabase', $notifDatabase);
    });
}
}