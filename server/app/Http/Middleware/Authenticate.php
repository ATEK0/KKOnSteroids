<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function checkLogin(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            $token = JWTAuth::getToken();
            JWTAuth::parseToken()->authenticate();
            
            return $next($request);
        } catch (\Throwable $th) {
            return false;
        }

    }
}
