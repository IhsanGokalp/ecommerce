<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->id);
        Cart::add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'attributes' => array()
        ));

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        $cartItems = Cart::getContent();
        return view('cart.index', compact('cartItems'));
    }

    public function remove(Request $request)
    {
        Cart::remove($request->id);
        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    public function update(Request $request)
    {
        Cart::update($request->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function clear()
    {
        Cart::clear();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}