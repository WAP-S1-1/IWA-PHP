<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware('role:admin,manager')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !$user->role) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $userRole = $user->role->role;

        if (!in_array($userRole, $roles)) {
            return response()->json([
                'message' => 'Forbidden - insufficient role'
            ], 403);
        }

        return $next($request);
    }
}
