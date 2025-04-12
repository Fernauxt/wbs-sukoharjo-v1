<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!session()->has('admin_id')) {
            // Redirect to the login page if not authenticated
            return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
