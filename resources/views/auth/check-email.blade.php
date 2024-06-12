@extends('layouts.app')

@section('content')

<main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="text-center bg-gray-200 p-5">
        <p class="text-base font-semibold text-indigo-600">{{ __('Verify Your Email Address') }}</p>

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

            <div class="mt-10 flex items-center justify-center gap-x-6 my-5">
                <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</a>
            </div>

            <form id="resend-form" action="{{ route('resend.verification') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">
                <button id="resend-button" type="submit" class="mt-3 rounded-md bg-gray-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600" disabled>{{ __('Resend Verification Email') }}</button>
            </form>

            <p id="resend-wait" class="text-base leading-7 text-gray-600 mt-5">
                {{ __('Please wait') }} <span id="countdown">60</span> {{ __('seconds before resending the verification email.') }}
            </p>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resendButton = document.getElementById('resend-button');
        const resendWait = document.getElementById('resend-wait');
        const countdown = document.getElementById('countdown');

        let timeLeft = 60;

        const timer = setInterval(() => {
            timeLeft--;
            countdown.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                resendButton.disabled = false;
                resendWait.classList.add('hidden');
            }
        }, 1000);

        document.getElementById('resend-form').addEventListener('submit', function (event) {
            event.preventDefault();

            resendButton.disabled = true;
            resendWait.classList.remove('hidden');
            timeLeft = 60;
            countdown.textContent = timeLeft;

            setTimeout(() => {
                resendButton.disabled = false;
                resendWait.classList.add('hidden');
            }, 60000); // 60000 milliseconds = 1 minute

            this.submit();
        });
    });
</script>

@endsection
