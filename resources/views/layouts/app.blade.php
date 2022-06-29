@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') · {{ config('app.name', 'CARE Iraq') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="app">

    <nav id="main-menu" class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="logo d-print-none" src="{{ asset('img/logo.png') }}"/>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            @include('layouts.partials.main_menu')

            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto d-flex">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('users.profile') }}" role="button" aria-haspopup="true">
                                Hello, {{ Auth::user()->first_name }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="nav-link">
                                <a class="text-danger" style="text-shadow: 0 0 5px #e5e5e5;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="material-icons">logout</span> Logout
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

    <main class="m-3">
        <div id="breadcrumb" class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
    </main>

    <main class="pt-4">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h1 class="display-6">
                        @yield('title')
                    </h1>
                </div>
                <div class="col-6 d-flex flex-row-reverse">
                    <ul class="list-unstyled">
                        @yield('heading-navbar')
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <main class="mb-3">
        <div class="container">
            @yield('primary_menu')
        </div>
    </main>

    <main class="py-1" style="min-height: 450px;">
        @yield('content')
    </main>

    <main id="footnote" class="mt-5">
        <div class="container">
            @yield('footnote')
        </div>
    </main>

    <br/>
    <main>
        @include('layouts.footer')
    </main>
</div>


<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

@yield('scripts')

</body>
</html>
