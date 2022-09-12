<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    @client
    @vite('main')
    <!-- Frontend -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="d-flex flex-column h-100">
    <header class="p-3 bg-dark-gray text-white">
        <div class="container">
            <nav class="navbar navbar-expand-lg d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <a class="navbar-brand pe-1" href="{{ url('/') }}">
                    ООО "КОМФОРТ"
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="currentColor" class="bi bi-list text-light" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>

                <div class="navbar-collapse collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Главная</a>
                        </li>
                        @foreach (Menu::getList() as $link)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page"
                                   href="{{ route('wikipages.show', ['slug' =>$link->slug ]) }}">{{ $link->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="navbar-nav d-flex">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item px-1 "> <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a> </li>
                            @endif
                             <span class="px-1 pt-3"></span>
                            @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a></li>
                            @endif
                        @else
                            <li class="nav-item px-1 pt-3">
                                    {{ Auth::user()->name }}</li>
                            <li class="nav-item px-1 pt-3">
                                            {{ Auth::user()->email }}</li>

                        <li class="nav-item px-1 pt-3">
                            <span>
                            |
                            </span>
                        </li>
                            @if (Auth::user()->isAdmin)
                                <li class="nav-item px-1 pt-3"> <a class="" href="{{ route('admin') }}">{{ __('admin.index') }}</a></li>
                            @endif
                            @if (Auth::user()->isClient)
                                <li class="nav-item px-1 pt-3"> <a class="" href="{{ route('cabinet') }}">{{ __('cabinet.index') }}</a></li>
                            @endif
                            <li class="nav-item px-1 pt-3"><a class="" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('auth.logout') }}
                                </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <div class="container">
        <main class="py-4 flex-shrink-0">
            @yield('content')
        </main>
    </div>
    @include('footer')
</body>
</html>
