<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function addToCart(Course $course)
    {
        $cart = Cart::firstOrCreate([
            'session_id' => session()->getId(),
        ]);

        $cart->courses()->syncWithoutDetaching($course);

        return redirect()->route('cart.index');
    }
}
