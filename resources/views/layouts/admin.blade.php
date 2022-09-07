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
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/sass/admin.scss', 'resources/js/admin.js'])

</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img alt="{{ config('app.name', 'Home') }}"
                         title="{{ config('app.name', 'Home') }}"
                         height="25"
                         class="d-inline-block align-text-top"
                         src="/logo_light.png"/>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="/">{{ __('default.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">{{ __('admin.index') }}</a>
                        </li>
                    </ul>

                    <div class="navbar-nav">
                        <div class="nav-item text-nowrap">
                            <span class="px-1 text-white">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="px-1 text-white">
                                {{ Auth::user()->email }}
                            </span>
                            <span class="px-1 text-white">
                                |
                            </span>
                            <a class="ps-1 pe-3 text-white"  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                </div>
            </div>
        </nav>
    </header>
    <script>
        window.Laravel = JSON.parse(atob('{{ AccountsUser::getVueAuth(\App\Models\User::TOKEN_ADMIN)}}'));
    </script>

    <main id="admin" class="container-fluid py-4 flex-shrink-0 mt-5">
        @yield('content')
    </main>

    <footer class="footer mt-auto bg-dark">
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
</body>
</html>

