<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where(function($query) {
            $query->where('session_id', session('cart_session_id'))
                  ->orWhere('user_id', auth()->id());
        })->with('product')->get();

        $cartCount = Cart::where(function($query) {
            $query->where('session_id', session('cart_session_id'))
                  ->orWhere('user_id', auth()->id());
        })->sum('quantity');

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'cartCount' => $cartCount,
            'stripeKey' => env('STRIPE_KEY')
        ]);
    }

    public function process(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Calculate total
            $total = Cart::where(function($query) {
                $query->where('session_id', session('cart_session_id'))
                      ->orWhere('user_id', auth()->id());
            })->join('products', 'carts.product_id', '=', 'products.id')
              ->selectRaw('SUM(carts.quantity * products.price) as total')
              ->value('total');

            if (!$request->stripeToken) {
                throw new \Exception('No payment token provided.');
            }

            // Create the charge on Stripe's servers
            $charge = Charge::create([
                'amount' => (int)($total * 100), // amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Order payment from ' . (auth()->user() ? auth()->user()->email : 'guest'),
            ]);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'paid',
                'stripe_payment_id' => $charge->id,
            ]);

            // Clear the cart
            Cart::where(function($query) {
                $query->where('session_id', session('cart_session_id'))
                      ->orWhere('user_id', auth()->id());
            })->delete();

            return redirect()->route('home')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}