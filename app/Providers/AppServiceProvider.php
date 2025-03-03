<?php
namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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

        Facades\View::composer('*', function (View $view) {
            $cart = Cart::with('courses')->where('session_id', session()->getId())->first();
            $view->with('cart', $cart);
        });
    }
}
