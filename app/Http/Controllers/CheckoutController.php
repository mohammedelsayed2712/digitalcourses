<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart   = Cart::session()->first();
        $prices = $cart->courses->pluck('stripe_price_id')->toArray();

        $sessionOptions = [
            // 'success_url' => route('home', ['message' => 'payment success']),
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('home', ['message' => 'payment canceled']),
            'metadata'    => [
                'cart_id' => $cart->id,
                'user_id' => Auth::user()->id,
            ],
        ];

        $customerOptions = [
            'email' => Auth::user()->email,
        ];

        return Auth::user()->checkout($prices, $sessionOptions, $customerOptions);
    }

    public function success(Request $request)
    {
        // dd($request->get('session_id'));
        $session = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        dd($session);

        // $cart = Cart::find($session->metadata->cart_id);

        // $cart->update([
        //     'session_id' => $session->id,
        //     'user_id'    => $session->metadata->user_id,
        // ]);
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
