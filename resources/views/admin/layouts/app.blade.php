<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.layouts.partials.html_head')
</head>
<body>
<div id="app">

    <div class="position-absolute ib-top-band">
        <div class="ib-logo d-none d-sm-block">
            <a class="navbar-brand d-flex justify-content-center align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}"/>
            </a>
        </div>
        <div class="top-nav-menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown" id="quick-add">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-icons">add_circle</span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="row row-cols-3" style="margin: 0 !important;">
                                        {{--                                    @foreach($top_band_dropdown_items as $top_band_dropdown)--}}
                                        <div class="col" style="padding: 5px 0 !important;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="text-muted">
                                                        {{--                                                        <span class="material-icons icon">{{ $top_band_dropdown['icon'] }}</span>--}}
                                                        {{--                                                        <span class="menu-header">{{ $top_band_dropdown['name'] }}</span>--}}
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-unstyled">
                                                        {{--                                                        @foreach($top_band_dropdown['children'] as $link)--}}
                                                        {{--                                                            <li>--}}
                                                        {{--                                                                <a href="{{ route( $link['url'] ) }}">--}}
                                                        {{--                                                                    <span class="material-icons icon">{{ $link['icon'] }}</span>--}}
                                                        {{--                                                                    <span class="menu-item">{{ $link['title'] }}</span>--}}
                                                        {{--                                                                </a>--}}
                                                        {{--                                                            </li>--}}
                                                        {{--                                                        @endforeach--}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                    @endforeach--}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown" id="top-band-help">
                                <button type="button" class="btn text-white">
                                    <span class="material-icons">help_outline</span>
                                </button>
                            </li>
                            <li class="nav-item dropdown" id="top-band-help">
                                <a class="btn btn-sm" href="{{ route('users.profile') }}">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="position-absolute ib-navbar ib-navbar-open">
        @include('admin.layouts.partials.navbar')
    </div>

    {{--    Content    --}}
    <div class="position-absolute d-flex ib-content ib-content-open">
        {{--    Content Header    --}}

        <div class="position-relative ib-content-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center justify-content-start ib-content-header-title ms-3">
                    <h1 class="lead fs-2 mb-0">{{ $title }}</h1>
                </div>
                <div class="d-flex align-items-center justify-content-end ib-content-header-actions pe-3">
                    <ul class="list-unstyled mb-0">
                        @yield('ib-header-actions')
                    </ul>
                </div>
            </div>
        </div>
        @hasSection('ib-content-actions')
            <div class="position-absolute ib-content-actions ps-3">
                @yield('ib-content-actions')
            </div>
        @endif

        <div class="position-absolute ib-content-body">
            @yield('ib-content-body')
        </div>

        @hasSection('ib-content-footer')
            <div class="position-absolute ib-content-footer d-flex align-items-center ms-3">
                @yield('ib-content-footer')
            </div>
        @endif
    </div>

    {{--  Title  --}}
    {{--    <div class="page-header d-flex justify-content-center align-items-center">--}}
    {{--        <div class="row">--}}
    {{--
    {{--            <div id="page-quick-links" class="col-6 d-flex justify-content-end">--}}
    {{--                @yield('page-quick-links')--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div class="position-absolute page-actions">--}}
    {{--        @yield('page_actions')--}}
    {{--    </div>--}}

    {{--    <div id="page-content">--}}
    {{--        --}}{{--  Content  --}}
    {{--        <div id="content">--}}
    {{--            @yield('content')--}}
    {{--        </div>--}}

    {{--        --}}{{--  Footnote  --}}
    {{--        <div id="footnote">--}}
    {{--            @yield('footnote')--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>

@include('admin.layouts.partials.html_footer')
</body>
</html>
