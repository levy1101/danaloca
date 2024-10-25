<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Danaloca') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    {{-- custom --}}
    <link href="{{ asset('css/styleuser.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/raphael-min.js') }}"></script>
    <script src="{{ asset('js/morris.js') }}"></script>
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body>
    <div id="app">
        
        <nav>
            <div class="container" style="display:flex">
                {{-- <div class="row"> --}}

                <div class="me-auto">
                    <h2 class="log ">
                        Danaloca
                    </h2>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="btn btn-primary " href="{{ route('register') }}">{{ __('Register') }}</a>
                </div>
                {{-- </div> --}}
            </div>
        </nav>
    </div>
    <main class="auth">
        @yield('content')
    </main>
    </div>
</body>

</html>
