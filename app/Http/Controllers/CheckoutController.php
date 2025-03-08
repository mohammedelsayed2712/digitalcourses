<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
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
        $session = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));

        if ($session->payment_status == 'paid') {
            $cart = Cart::findOrFail($session->metadata->cart_id);

            $order = Order::create([
                'user_id' => $request->user()->id,
            ]);

            $order->courses()->attach($cart->courses->pluck('id')->toArray());

            $cart->delete();

            return redirect()->route('home', ['message' => 'Payment success']);
        }
    }

    public function cancel(Request $request)
    {
        $session = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
    }
}
