<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('session_id', session()->getId())->first();
        return view('cart.index', get_defined_vars());
        // return view('cart.index', compact('cart'));
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
