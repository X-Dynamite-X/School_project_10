<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChackIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::check() && !Auth::user()->hasDirectPermission('isActev'));
        if (Auth::check() && !Auth::user()->hasDirectPermission('isActev')) {
            Auth::logout();
            return redirect('/waiting')->with('error', 'Your account is not activated. Please contact support.');
        }
        return $next($request);

    }
}