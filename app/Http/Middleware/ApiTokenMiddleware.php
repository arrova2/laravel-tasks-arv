<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        $token = $request->bearerToken()
            ?? $request->header('X-API-KEY')
            ?? (
                $authHeader && str_starts_with($authHeader, 'Bearer ')
                    ? substr($authHeader, 7)
                    : $authHeader
            )
            ?? $request->query('api_token');

        $valid = (string) config('app.api_token');

        \Log::debug('AUTH', [
        'bearer' => $request->bearerToken(),
        'auth'   => $request->header('Authorization'),
        'xkey'   => $request->header('X-API-KEY'),
        'valid'  => config('app.api_token'),
        ]);

        if (!$token || !hash_equals($valid, (string) $token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
