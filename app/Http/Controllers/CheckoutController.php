<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // checkout() initializes a Stripe checkout session and redirects the user to Stripe's payment page.
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

    public function enableCoupons()
    {
        $cart   = Cart::session()->first();
        $prices = $cart->courses->pluck('stripe_price_id')->toArray();

        $sessionOptions = [
            'success_url' => route('home', ['message' => 'Payment success']),
            'cancel_url'  => route('home', ['message' => 'Payment canceled']),
            // 'allow_promotion_codes' => true,
        ];

        return Auth::user()
        // ->allowPromotionCodes()
        // ->withCoupon('pCfmp7hD')
            ->withPromotionCode('promo_1R1ILK2KxKhpsanMor0BHwrT')
            ->checkout($prices, $sessionOptions);
    }

    // success() confirms payment, creates an order, assigns courses to the order, and deletes the cart.
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

    // cancel() retrieves the Stripe session when a checkout is canceled but does nothing further.
    public function cancel(Request $request)
    {
        $session = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
    }

    public function nonStripeProducts()
    {
        $cart   = Cart::session()->first();
        $amount = $cart->courses->sum('price');
        // dd($amount);
        $name = $cart->courses->pluck('name')->implode(', ');
        // dd($name);

        $sessionOptions = [
            'success_url' => route('home', ['message' => 'Payment success']),
            'cancel_url'  => route('home', ['message' => 'Payment canceled']),
        ];

        return Auth::user()->checkoutCharge($amount, $name, 1, $sessionOptions);
    }
}
