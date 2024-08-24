<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access. Please log in to access this resource.',
                    'error_code' => 'UNAUTHORIZED_ACCESS'
                ], 401);
        }
        if (Auth::user()->is_admin== 1){
            return $next($request);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Access denied. You do not have the necessary permissions to access this resource.',
            'error_code' => 'FORBIDDEN_ACCESS'
        ], 403);
    }
}
