<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (is_null(auth('sanctum')->user()) || !auth('sanctum')->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
