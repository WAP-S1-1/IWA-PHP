<?php

namespace App\Http\Middleware;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Niet ingelogd.');
        }

        // Use the new hasRole method from User model
        if (!$user->hasRole(...$roles)) {
            abort(403, 'Geen toegang.');
        }

        return $next($request);
    }
}
