<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Cart;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function process(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => Cart::getTotal() * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Order payment',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => Cart::getTotal(),
            'status' => 'paid',
        ]);

        Cart::clear();

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}