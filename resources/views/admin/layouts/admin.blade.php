<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="{{ asset('css/fount.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/fount.css') }}" rel="stylesheet">
    <script src="{{ asset('css/tailwindcss.css') }}"></script>
    @yield('css')
</head>

<body>
    <div class="admin" id="app">
        <div class="notification" id="notification" style="display: none;"></div>

        <div class=" width-100">
            @include('admin.layouts.nav')
        </div>
        <div class="notification" id="notification" style="display: none;"></div>

        <main class="flex ">
            @include('admin.layouts.sidebar')
            @yield('content_admin')
        </main>
        <audio id="notification_sound" src="{{ asset('../sounds/massege_ting.mp3') }}" preload="auto"></audio>

    </div>
    <script>
        var userId = '{{ auth()->user()->id }}';
        var csrf_token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript" charset="utf8" src="{{ asset('jquery/jquery_min.js') }}"></script>
    <script>
$.ajaxPrefilter(function(options, originalOptions, jqXHR) {
    const baseUrl = "https://reptile-pumped-bear.ngrok-free.app";
    const projectPrefix = "/SchoolProject10";

    if (options.url.startsWith("/") && !options.url.startsWith(projectPrefix)) {
        options.url = baseUrl + projectPrefix + options.url;
    }

    else if (options.url.startsWith(baseUrl) && !options.url.includes(projectPrefix)) {
        options.url = options.url.replace(baseUrl, baseUrl + projectPrefix);
    }
});
</script>
    <script type="text/javascript" src="{{ asset('datatables/dataTables.js') }}"></script>
    <script src="{{ asset('js/style.js/nav.js') }}"></script>
    <script src="{{ asset('pusher/pusher_min.js') }}"></script>
    <script src="{{ asset('js/session/pusher.js') }}"></script>
    <script src="{{ asset('js/session/auth.js') }}"></script>
    <script src="{{ asset('js/message/reseveMessage.js') }}"></script>

    @yield('js')

</body>

</html>
