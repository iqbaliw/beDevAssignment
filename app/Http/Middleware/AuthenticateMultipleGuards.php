<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class AuthenticateMultipleGuards
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            Auth::shouldUse('api');
            return $next($request);
        }

        if (Auth::guard('client')->check()) {
            Auth::shouldUse('client');
            return $next($request);
        }

        return ApiResponse::forbidden("Anda tidak memiliki akses.");
    }
}
