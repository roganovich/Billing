<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthenticationException;

class Jwt
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        $section_name = $request->header('Section');

        $user = DB::table('personal_access_tokens')
            ->select('tokenable_id')
            ->where('tokenable_type', '=', User::class)
            ->where('name', '=', $section_name)
            ->where('token', '=', $token)
            ->first();

        if ($user) {
            Auth::loginUsingId($user->tokenable_id);
            return $next($request);
        }

        throw new AuthenticationException();
    }
}
