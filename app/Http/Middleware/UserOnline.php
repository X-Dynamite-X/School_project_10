<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UserOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $auth = User::find(Auth::user()->id);
            $expiresAt = now()->addMinutes(1);
            Cache::put('user-is-online-' . $auth->id, true, $expiresAt);
            $auth->last_seen_at = Carbon::now()->subMinutes(-1)->toDateTimeString();
            $auth->status = true;
            $auth->save();

        }
        return $next($request);
    }
}
