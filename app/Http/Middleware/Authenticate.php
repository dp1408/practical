<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Check the URL segment to determine the redirect URL
            if ($request->is('seller') || $request->is('seller/*')) {
                return route('seller.login');
            } elseif ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            } elseif ($request->is('home') || $request->is('home/*')) {
                return route('home.login');
            } else{
                return route('home.dashboard');
            }
        }
    }
}
