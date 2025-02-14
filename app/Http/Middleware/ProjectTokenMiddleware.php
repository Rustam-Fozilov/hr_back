<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = 'Bearer qkQrdDmP7hPpfQVHtNVqZJrIvDUQkEgE4ewcAqQPeHuteRjFU4';
        if ($request->header('Authorization') !== $token) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
