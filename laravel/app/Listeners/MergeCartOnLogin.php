<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;

class MergeCartOnLogin
{
    public function handle(Login $event)
    {
        if (session()->has('cart_session_id')) {
            Cart::where('session_id', session('cart_session_id'))
                ->update(['user_id' => $event->user->id]);
        }
    }
}