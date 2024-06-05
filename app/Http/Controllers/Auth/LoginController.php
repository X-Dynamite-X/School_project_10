<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserOnline;
use App\Events\UserOffline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }
    public function logout(Request $request)
    {
        event(new UserOffline(Auth::id()));
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    protected function authenticated(Request $request, $user)

    {

        if (auth()->check() && auth()->user()->email_verified_at != null && auth()->user()->hasDirectPermission('notActev')) {
            auth()->logout();
            return redirect('/waiting');
        }
        if (auth()->check() && auth()->user()->email_verified_at != null && auth()->user()->hasRole('admin')) {
            session()->put('user_id', Auth::id());
            return redirect('/admin/user');
        }
        session()->put('user_id', Auth::id());

        return redirect('/home');
    }
}
