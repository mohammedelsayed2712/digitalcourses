<?php
namespace App\Http\Controllers;

use App\Models\Cart;

class PaymentIntentController extends Controller
{
    public function index()
    {
        $amount  = Cart::session()->first()->courses->sum('price');
        $payment = auth()->user()->pay($amount);

        return view('checkout.payment-intent', compact('payment'));
    }
}
