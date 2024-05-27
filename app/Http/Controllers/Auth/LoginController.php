<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    protected function authenticated(Request $request, $user)

    {
        // dd(auth()->user()->hasRole('admin'));
        // dd(auth()->user()->email_verified_at != null);
        if (auth()->check() && auth()->user()->email_verified_at != null && auth()->user()->hasDirectPermission('notActev')) {
            auth()->logout(); // قم بتسجيل الخروج في حالة عدم تحقق الشرط
            return redirect('/waiting'); // يمكنك توجيه المستخدم إلى أي صفحة تحددها هنا


        }
        if (auth()->check() && auth()->user()->email_verified_at != null && auth()->user()->hasRole('admin')) {
            return redirect('/admin/user');
        }

        return redirect('/home');
    }
}
