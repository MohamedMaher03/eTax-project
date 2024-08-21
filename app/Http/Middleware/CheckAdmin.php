<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminRoleId = Role::where('name', 'admin')->first()->id;
        $userRoleId = auth()->user()->role_id;
        if($adminRoleId !== $userRoleId){
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized access'
            ], 403);
        }
        return $next($request);
    }
}
