<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
</head>

<body>
    <div class="admin" id="app">
        <div class="notification" id="notification" style="display: none;"></div>

        <div class=" width-100">
            @include('admin.layouts.nav')
        </div>
        <main class="flex ">
            @include('admin.layouts.sidebar')
            @yield('content_admin')
        </main>
    </div>
    <script>
        var userId = '{{ auth()->user()->id }}';
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
    <script src="{{ asset('js/style.js/nav.js') }}"></script>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script src="{{ asset('js/session/auth.js') }}"></script>
    <script src="{{ asset('js/message/reseveMessage.js') }}"></script>


    @yield('js')

</body>

</html>
