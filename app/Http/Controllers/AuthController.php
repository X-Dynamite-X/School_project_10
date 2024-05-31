<?php

namespace App\Http\Controllers;

use App\Events\UserOnline;
use App\Events\UserOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // عملية تسجيل الدخول
        // ...

        // بث الحدث عند تسجيل الدخول
        Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));

        event(new UserOnline(Auth::id()));
    }

    public function logout()
    {
        // بث الحدث عند تسجيل الخروج
        Cache::forget('user-is-online-' . Auth::id());

        event(new UserOffline(Auth::id()));

        // عملية تسجيل الخروج
        // ...
    }
}
