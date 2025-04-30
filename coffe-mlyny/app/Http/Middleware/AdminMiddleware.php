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
     * @param  Request  $request
     * @param  \Closure(Request): (Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
