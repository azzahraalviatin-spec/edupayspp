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
            // Cek dulu apakah kolom is_dibaca ada, kalau tidak ada pakai read_at
            try {
                $hasIsDibaca = Schema::hasColumn('notifications', 'is_dibaca');

                if ($hasIsDibaca) {
                    $notifDatabase = DB::table('notifications')
                        ->where('is_dibaca', false)
                        ->orderBy('created_at', 'desc')
                        ->get();
                } else {
                    $notifDatabase = DB::table('notifications')
                        ->whereNull('read_at')
                        ->orderBy('created_at', 'desc')
                        ->get();
                }
            } catch (\Exception $e) {
                $notifDatabase = collect();
            }

            $view->with('notifDatabase', $notifDatabase);
        });
    }
}