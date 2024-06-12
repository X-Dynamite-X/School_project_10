<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:3', 'confirmed'],
    //     ], [
    //         'name.required' => 'The name field is required',
    //         'email.required' => 'The email field is required',
    //         'email.unique' => 'The email field is already exist',
    //         'password.confirmed' => 'The password confirmation does not match.',
    //     ]);
    // }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     $user=  User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // $user->givePermissionTo("notActev");
    // $user->assignRole('user');

    //     return $user;
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ], [
            'name.required' => 'The name field is required',
            'email.required' => 'The email field is required',
            'email.unique' => 'The email field is already exist',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_token' => sha1(time()),
        ]);

        Auth::logout();
        Mail::send('emails.verify', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Email Verification');
        });

        return redirect()->route('check.email');
    }
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect('/waiting/verify')->with('error', 'Invalid verification token.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->givePermissionTo("notActev");
        $user->assignRole('user');
        $user->save();

        return redirect('/login')->with('message', 'Your email has been verified. You can now login.');
    }
    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return redirect('/login')->with('message', 'This email is already verified. Please login.');
        }

        $verificationToken = sha1(time());
        $user->verification_token = $verificationToken;
        $user->save();

        Mail::send('emails.verify', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Email Verification');
        });

        return redirect()->route('check.email')->with('message', 'Verification email has been resent.');
    }
}
