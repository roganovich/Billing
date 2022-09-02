<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Frontend -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/cabinet.scss', 'resources/js/cabinet.js'])

</head>
<body class="d-flex flex-column h-100">
    <div class="container py-3">
        <header>
            <div class="d-flex flex-column flex-md-row pb-2 align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img alt="{{ config('app.name', 'Home') }}"
                         title="{{ config('app.name', 'Home') }}"
                         height="25"
                         class="d-inline-block align-text-top"
                         src="/logo.png"/>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <nav class="d-flex justify-content-start">
                    <a class="nav-link" aria-current="page" href="/">{{ __('default.home') }}</a>
                    <span class="px-1"></span>
                    <a class="nav-link" aria-current="page"
                       href="{{ route('wikipages.index') }}">{{ __('wikipages.index') }}</a>
                </nav>
                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                        @endif

                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                        @endif
                    @else
                        <span class="px-1">
                                {{ Auth::user()->name }}
                            </span>
                        <span class="px-1">
                                        {{ Auth::user()->email }}
                                    </span>
                        <span class="px-1">
                                        |
                                    </span>

                        @if (Auth::user()->isAdmin)
                            <a class="ps-1 pe-3" href="{{ route('admin') }}">{{ __('admin.index') }}</a>
                        @endif
                        @if (Auth::user()->isClient)
                            <a class="ps-1 pe-3" href="{{ route('cabinet') }}">{{ __('cabinet.index') }}</a>
                        @endif

                        <a class="ps-1 pe-3" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('auth.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </nav>
            </div>
        </header>
        @if (Auth::check())
            @php
                $user_auth_data = [
                    'isLoggedin' => true,
                    'user' =>  Auth::user()
                ];
            @endphp
        @else
            @php
                $user_auth_data = [
                    'isLoggedin' => false
                ];
            @endphp
        @endif
        <script>
            window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
        </script>

        <main id="cabinet" class="py-4 flex-shrink-0">
            @yield('content')
        </main>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md">
                    <small class="d-block mb-3 text-muted">© {{ date('Y') }} R/R Company, Inc. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
