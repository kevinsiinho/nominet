<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        // Use a view composer to share the $usuario variable with specific views
        View::composer(['layouts.menu'], function ($view) {
            if (Auth::check()) {
                // Obtain the authenticated user
                $usuario = Auth::user();

                // Share the $usuario variable with the view
                $view->with('usuario', $usuario);
            }
        });
    }
}
