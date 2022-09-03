<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->isAdmin) {
                return $next($request);
            }
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
