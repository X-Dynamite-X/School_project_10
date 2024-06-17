<?php

namespace App\Http\Middleware;

use App\Events\UserOnline as EventsUserOnline;
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
            if($auth->status == 0){
                event($auth->id,1);
            }
   
            $auth->status = true;
            $auth->save();

        }
        return $next($request);
    }
}
