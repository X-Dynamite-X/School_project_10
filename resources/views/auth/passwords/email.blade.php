@extends('layouts.app')

@section('content')





<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto  rounded-full" src="{{ asset('log.png') }}" alt="Your Company">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account
        </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <label for="email"
                    class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email Address') }}</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="email"
                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                        class="block px-3 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    @error('email')
                        <span class="text-red-500" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="text-lg text-center text-green-500" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

            </div>

            <div>
                <button type="submit"
                    class="flex w-full my-3 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send Password Reset Link</button>
            </div>
        </form>
    </div>
</div>










@endsection
