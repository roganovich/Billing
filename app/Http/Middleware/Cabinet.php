<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class Cabinet
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->isClient) {
                return $next($request);
            }
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
