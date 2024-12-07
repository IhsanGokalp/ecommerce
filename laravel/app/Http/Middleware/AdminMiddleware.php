<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user() && auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect('home')->with('error', 'You do not have admin access');
    }
}