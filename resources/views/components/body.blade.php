<!DOCTYPE html>
<!-- language -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- title -->
    <title>{{ $title }}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('dist/assets/compiled/svg/favicon.svg') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/iconly.css') }}" />
    @stack('costum-css')
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="header-top-left">
                            <div class="avatar avatar-md2">
                                <img src="{{ asset('assets/image/logo-ajisaka.png') }}" alt="Logo">
                                <h4 class="align-items-center m-2">PT. AJISAKA</h4>
                            </div>
                        </div>
                        <div class="header-top-right">
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    @role('keuangan')
                                        <div class="avatar avatar-md2">
                                            <img src="{{ asset('assets/image/pic-cewe.png') }}" alt="Avatar">
                                        </div>
                                    @endrole
                                    @role('teknik')
                                        <div class="avatar avatar-md2">
                                            <img src="{{ asset('assets/image/pic-cowo.png') }}" alt="Avatar">
                                        </div>
                                    @endrole
                                    <div class="text">
                                        <h6 class="user-dropdown-name">{{ $user->name }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted">
                                            Staff {{ $user->getRoleNames()->first() }}</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    aria-labelledby="topbarUserDropdown">
                                    <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="auth-login.html">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="content-wrapper container">
                {{ $slot }}
            </div>
        </div>
        <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
        <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

        <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>

        <!-- Need: Apexcharts -->
        <script src="{{ asset('dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('dist/assets/static/js/pages/dashboard.js') }}"></script>
        <!-- untuk tempat sisipkan script javascript -->
        @stack('costum-script')
        @stack('scripts')
</body>
