<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;

class Jwt
{
    public function handle($request, Closure $next)
    {
        $request->validate([
            'user_id' => 'required',
            'accessToken' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->isAdmin) {
            $section_name = User::TOKEN_ADMIN;
        } else {
            $section_name = User::TOKEN_CABINET;
        }
        $user_token = $user->getAccessToken($section_name);

        if (strcmp($user_token, $request->accessToken) == 0) {
            return $next($request);
        }

        throw ValidationException::withMessages(['accessToken' => 'This value is incorrect']);
    }
}
