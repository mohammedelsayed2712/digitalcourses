<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        // Global View
        // View::share('name', 'custom');
        // view()->share('name', 'custom');

        // Composer View
        // View::composer(
        //     ['*'],
        //     function ($view) {
        //         $view->with('name', 'custom');
        //     }
        // );

        View::composer('home', function ($view) {
            $view->with('name', 'custom');
        });
    }
}
