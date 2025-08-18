<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
        if (Auth::check()) {
            $menuOptions = DB::select('CALL obtener_botones(?)', [Auth::id()]);
        } else {
            $menuOptions = [];
        }
        $view->with('menuOptions', $menuOptions);
    });
    }
}
