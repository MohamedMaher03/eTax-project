<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized access'], 403);
        }

        // Check if the user has the specified role
        if (Auth::user()->role_id != $role) {
            return response()->json(['status' => 'failed', 'message' => 'Unauthorized access'], 403);
        }

        return $next($request);
    }
}
