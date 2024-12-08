<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::random(40)]);
        }
        return session('cart_session_id');
    }

    public function index()
    {
        $cartItems = Cart::where(function($query) {
            $query->where('session_id', $this->getSessionId())
                  ->orWhere('user_id', auth()->id());
        })->with('product')->get();

        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = Cart::where('product_id', $product->id)
            ->where(function($query) {
                $query->where('session_id', $this->getSessionId())
                      ->orWhere('user_id', auth()->id());
            })->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'session_id' => $this->getSessionId(),
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Product $product)
    {
        Cart::where('product_id', $product->id)
            ->where(function($query) {
                $query->where('session_id', $this->getSessionId())
                      ->orWhere('user_id', auth()->id());
            })->delete();

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function update(Request $request)
    {
        $cart = Cart::where('product_id', $request->id)
            ->where(function($query) {
                $query->where('session_id', $this->getSessionId())
                      ->orWhere('user_id', auth()->id());
            })->first();

        if ($cart) {
            $cart->update(['quantity' => $request->quantity]);
        }

        return redirect()->back();
    }

    public function clear()
    {
        Cart::where(function($query) {
            $query->where('session_id', $this->getSessionId())
                  ->orWhere('user_id', auth()->id());
        })->delete();

        return redirect()->back()->with('success', 'Cart cleared!');
    }
}