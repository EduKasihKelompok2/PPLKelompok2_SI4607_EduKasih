<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EduKasih - @yield('title','Page')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #5D5FEF;">
            <div class="container">
                <a class="navbar-brand text-uppercase text-white fw-bold"
                    href="{{ Auth::check() && Auth::user()->hasRole('admin') ? route('admin.home') : route('home') }}">
                    EduKasih
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
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link active text-white d-flex align-items-center"
                                href="{{ Auth::check() && Auth::user()->hasRole('admin') ? route('admin.home') : route('home') }}">
                                <i class="bi bi-house-door me-2 me-lg-0"></i>
                                <span class="d-inline d-lg-none">Home</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white d-flex align-items-center"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                <div class="d-flex flex-column text-start text-lg-end align-items-lg-end me-2">
                                    <div class="fw-bold text-uppercase">{{ Auth::user()->nickname ?? Auth::user()->name
                                        }}</div>
                                    <span style="font-size: 10px;">{{Auth::user()->nisn ?? '-'}}</span>
                                </div>
                                <img src="{{ Auth::user()->photo ? asset('storage/profile_photos/' . Auth::user()->photo) : 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541' }}"
                                    alt="Profile Photo" class="rounded-circle ms-auto" width="40" height="40"
                                    style="object-fit: cover;">
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('profile')}}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Content --}}
        <main class="py-4">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-light text-center text-lg-start mt-auto">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © {{ date('Y') }} EduKasih. All rights reserved.
            </div>
        </footer>
    </div>

    <style>
        .navbar-nav .nav-link {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            height: 3rem;
            border-radius: 5px;
        }

        .navbar-nav .nav-link i {
            font-size: 1.25rem;
        }

        .navbar-nav .nav-link:hover {
            background-color: white;
            border-radius: 5px;
            color: #5D5FEF !important;
        }
    </style>

    @stack('scripts')
</body>

</html>