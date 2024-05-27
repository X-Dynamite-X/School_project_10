@extends('layouts.app')

@section('content')


<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8  ">
    <div class="text-center bg-gray-200 p-5 ">
        <p class="text-base font-semibold text-indigo-600 ">{{ __('Verify Your Email Address') }}</p>


        <div class="mt-10">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <p class="text-base leading-7 text-gray-600">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6 my-5 ">
                <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</a>
            </div>

        </div>
    </div>
</main>

@endsection
