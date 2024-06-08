<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('log.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    @yield('css')


</head>

<body>
    <div id="app">

        @include('layouts.nav')
        <div class="notification" id="notification" style="display: none;"></div>
        @yield('content')

    </div>
    @auth
        <script>
            var userId = '{{ auth()->user()->id }}';
            var csrf_token = "{{ csrf_token() }}";
        </script>
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
        <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
        <script src="{{ asset('js/message/reseveMessage.js') }}"></script>
        <script src="{{ asset('js/session/auth.js') }}"></script>
        <script src="{{ asset('js/style.js/nav.js') }}"></script>
    @endauth


    @yield('js')

</body>


</html>
