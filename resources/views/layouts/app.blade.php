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
    <link href="{{ asset('css/fount.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('log.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('css/tailwindcss.css') }}"></script>

    @yield('css')


</head>

<body>
    <div id="app">

        @include('layouts.nav')
        <div class="notification" id="notification" style="display: none;"></div>
        @yield('content')
        <audio id="notification_sound" src="{{ asset('../sounds/massege_ting.mp3') }}" preload="auto"></audio>

    </div>

    @auth
        <script>
            var userId = '{{ auth()->user()->id }}';
            var csrf_token = "{{ csrf_token() }}";
        </script>
        <script type="text/javascript" charset="utf8" src="{{ asset('jquery/jquery_min.js') }}"></script>
        <script>
            $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
                const baseUrl = "{{ env('APP_URL') }}";
                const projectPrefix = "{{ env('SUB_DOMENE') }}";

                if (options.url.startsWith("/") && !options.url.startsWith(projectPrefix)) {
                    options.url = baseUrl + projectPrefix + options.url;
                } else if (options.url.startsWith(baseUrl) && !options.url.includes(projectPrefix)) {
                    options.url = options.url.replace(baseUrl, baseUrl + projectPrefix);
                }
            });
        </script>
        <script type="text/javascript" src="{{ asset('datatables/dataTables.js') }}"></script>
        <script src="{{ asset('pusher/pusher_min.js') }}"></script>
        <script src="{{ asset('js/session/pusher.js') }}"></script>
        <script src="{{ asset('js/session/auth.js') }}"></script>
        <script src="{{ asset('js/message/reseveMessage.js') }}"></script>
        <script src="{{ asset('js/style.js/nav.js') }}"></script>
    @endauth


    @yield('js')
    <script>
        $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            const baseUrl = "{{ env('APP_URL') }}";
            const projectPrefix = "{{ env('SUB_DOMENE') }}";

            // إذا كان الـ URL يبدأ بالـ baseUrl فقط (بدون SchoolProject10)
            if (options.url.startsWith(baseUrl) && !options.url.includes(projectPrefix)) {
                options.url = options.url.replace(baseUrl, baseUrl + projectPrefix);
            }
        });
    </script>
</body>


</html>
