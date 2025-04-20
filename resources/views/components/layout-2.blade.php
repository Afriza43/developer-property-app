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
    <!-- untuk tempat sisipkan script css -->
    @stack('costum-css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"> --}}
</head>

<body>
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <!-- panggil file sidebar.blade.php di folder template -->
        <x-sidebar-2></x-sidebar-2>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <!-- untuk tempat sisipkan isi konten bersifat dinamis -->
            {{ $slot }}

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 © PT.AJISAKA</p>
                    </div>
                </div>
            </footer>
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
</body>

</html>
