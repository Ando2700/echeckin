<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', 'Home title')</title>
    <link rel="icon" href="{{ asset('logo/e-checkin-logo.png') }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    {{-- Vendor --}}
    {{-- <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet"> --}}
    {{-- Vendor --}}

    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body class="sb-nav-fixed">
    <?php
    use Carbon\carbon;
    ?>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        {{-- nisy an'ity class ity pour un peu d'espace navbar-brand ps-3 --}}
        <a class="navbar-brand" href="{{ route('admin.index') }}" style="font-family: consolas"><img
                src="{{ asset('logo/e-checkin-logo.png') }}" alt="E-checkin-logo" width="57px">E-Checkin Event
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">

            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
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
    </nav>

    <aside class="sidebar">
        <div class="toggle">
            <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
        <div class="side-inner">

            <div class="logo-wrap">
                <div class="logo">
                    <img src="{{ asset('img/event.png') }}" width="40px" alt="Echeki-in Event">
                </div>
                <span class="logo-text">Echeck-in Event</span>
            </div>
            <div class="nav-menu">
                <ul>
                    <li class="active" title="Page d'accueil"><a href="{{ route('admin.index') }}"
                            class="d-flex align-items-center"><span class="wrap-icon icon-home2 mr-3"></span><span
                                class="menu-text">Home</span></a></li>
                    <li class="active" title="Creation de type d'événement"><a href="{{ route('eventtypes.index') }}"
                            class="d-flex align-items-center"><span class="wrap-icon fa-solid fa-map mr-3"></span><span
                                class="menu-text">Creation type événement</span></a>
                    </li>
                    <li class="active mb-2" title="Ajouter un lieu">
                        <a href="{{ route('places.index') }}" class="d-flex align-items-center"><span
                                class="wrap-icon fas fa-location-dot mr-3"></span><span class="menu-text">Ajouter un
                                lieu</span></a>
                    </li>
                    <li class="active mb-2" title="Ajouter un/des participant(s)">
                        <a href="{{ route('attendees.index') }}" class="d-flex align-items-center"><span
                                class="wrap-icon fa-solid fa-user mr-3"></span><span class="menu-text">Ajouter
                                participant(s)</span></a>
                    </li>
                    <li class="active mb-2" title="Creation d'événement">
                        <a href="{{ route('events.index') }}" class="d-flex align-items-center"><span
                                class="wrap-icon fas fa-calendar-check mr-3"></span><span class="menu-text">Creer un
                                événement</span></a>
                    </li>
                    <li title="Statistiques"><a href="#" class="d-flex align-items-center"><span
                                class="wrap-icon icon-pie-chart mr-3"></span><span
                                class="menu-text">Statistiques</span></a></li><br>
                    <li><a href="#" class="d-flex align-items-center"><span
                                class="wrap-icon icon-cog mr-3"></span><span class="menu-text">Settings</span></a>
                    </li><br>
                </ul>
            </div>
        </div>

    </aside>
    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/datatables-demo.js') }}"></script>
    <script src="{{ asset('js/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="{{ asset('dt/datatables.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/owl.popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#toggle").click(function() {
                $("body").toggleClass("toggle-sidebar")
            })
        })
    </script>
</body>

</html>
