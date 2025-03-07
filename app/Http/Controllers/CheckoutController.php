<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart   = Cart::session()->first();
        $prices = $cart->courses->pluck('stripe_price_id')->toArray();

        $sessionOptions = [
            'success_url' => route('home', ['message' => 'payment success']),
            'cancel_url'  => route('home', ['message' => 'payment canceled']),
            // 'billing_address_collection' => 'required',
            // 'phone_number_collection'    => ['enabled' => true],
        ];

        return Auth::user()->checkout($prices, $sessionOptions);
    }
}
