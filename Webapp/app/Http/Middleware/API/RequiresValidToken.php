<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class RequiresValidToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get user from token (also validates token)
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Invalid or missing token'
            ], 401);
        }

        return $next($request);
    }
}
