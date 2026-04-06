<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RedirectIfAuthenticatedJwt
{
    public function handle(Request $request, Closure $next)
    {
        //dd($request->cookies->all());
        $token = $request->cookie('jwt-token');
        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();
                if ($user) {
                    // User is logged in → redirect to dashboard
                    return redirect('/dashboard');
                }
            } catch (\Exception $e) {
                // Invalid token, do nothing → show login page
            }
        }

        return $next($request);
    }
}
