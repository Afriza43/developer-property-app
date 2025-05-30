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
    @stack('scripts')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"> --}}
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>
</head>

<body>
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div class="px-5">
            <header class="mb-5">

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

    @push('scripts')
        <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Format semua input dengan class equipment-cost-input
                $('.equipment-cost-input').mask('000.000.000', {
                    reverse: true
                });

                // Saat form disubmit, salin value yang sudah dibersihkan ke input hidden
                $('form').on('submit', function() {
                    $(this).find('.wage-input').each(function() {
                        const formatted = $(this).val();
                        const cleaned = formatted.replace(/\./g, '');
                        const hiddenInputId = $(this).attr('id').replace('format', 'asli');
                        $('#' + hiddenInputId).val(cleaned);
                    });
                });
            });
        </script>
    @endpush
    <!-- untuk tempat sisipkan script javascript -->
    @stack('costum-script')
</body>

</html>
