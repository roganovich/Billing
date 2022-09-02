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
<div id="app">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img alt="{{ config('app.name', 'Home') }}"
                         title="{{ config('app.name', 'Home') }}"
                         height="25"
                         class="d-inline-block align-text-top"
                         src="/logo.jpg"/>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">


                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
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
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
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

    <div id="admin" class="container-fluid">
        @yield('content')
    </div>

    <main id="cabinet" class="py-4 flex-shrink-0 mt-5">
        @yield('content')
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between py-4 mt-4 border-top">
                <p>© {{ date('Y') }} R/R Company, Inc. All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-dark" href="#">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#twitter"></use>
                            </svg>
                        </a></li>
                    <li class="ms-3"><a class="link-dark" href="#">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#instagram"></use>
                            </svg>
                        </a></li>
                    <li class="ms-3"><a class="link-dark" href="#">
                            <svg class="bi" width="24" height="24">
                                <use xlink:href="#facebook"></use>
                            </svg>
                        </a></li>
                </ul>
                <div></div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
