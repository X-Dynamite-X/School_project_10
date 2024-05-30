<?php

namespace App\Http\Controllers;

use App\Events\UserOnline;
use App\Events\UserOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // عملية تسجيل الدخول
        // ...

        // بث الحدث عند تسجيل الدخول
        event(new UserOnline(Auth::id()));
    }

    public function logout()
    {
        // بث الحدث عند تسجيل الخروج
        event(new UserOffline(Auth::id()));

        // عملية تسجيل الخروج
        // ...
    }
}
