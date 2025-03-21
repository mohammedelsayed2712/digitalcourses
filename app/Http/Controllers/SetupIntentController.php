<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupIntentController extends Controller
{
    public function index()
    {
        $setupIntent = auth()->user()->createSetupIntent();
        dd($setupIntent);

        return view('checkout.setup-intent', get_defined_vars());
    }

    public function post(Request $request)
    {
        $cart   = Cart::session()->first();
        $amount = Cart::session()->first()->courses->sum('price');

        $paymentIntentId = $request->payment_intent_id;
        $paymentIntent   = Auth::user()->findPayment($paymentIntentId);

        if ($paymentIntent->status == 'succeeded') {
            $order = Order::create([
                'user_id' => Auth::user()->id,
            ]);
            $order->courses()->attach($cart->courses->pluck('id')->toArray());
            $cart->delete();
            return redirect()->route('home', ['message' => 'Payment successful!']);
        }

    }
}
