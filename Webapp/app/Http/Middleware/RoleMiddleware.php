<?php

namespace App\Http\Middleware;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Geen toegang.');
        }

        return $next($request);
    }
}
