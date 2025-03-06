<?php
namespace App\Http\Controllers;

use App\Models\Cart;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart   = Cart::session()->first();
        $prices = $cart->courses->pluck('stripe_price_id')->toArray();
        dd($prices);
        return view('checkout.index');
    }
}
