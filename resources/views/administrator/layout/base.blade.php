<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> {{ $title ?? 'unknown'}} | Simonika Politeknik Negeri Banyuwangi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    @php
        $profil_icon = \App\Models\Setting::where('options', 'profile')->where('label', 'icon')->first();
    @endphp
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/' . $profil_icon->value) }}">
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Select 2  -->
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- Pace -->
    <link href="{{ asset('assets/css/pace-theme-minimal.css') }}" rel="stylesheet" type="text/css" />
    <!-- Filepond -->
    <link href="{{ asset('assets/libs/filepond/filepond.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <script>
        window.fetch = undefined;
        const BASE_URL = "{{ url('/') }}"
        const ASSET_URL = "{{ asset('/') }}"
        const LANG = 'id'
        window.translations = []
    </script>
    <style>
        .table-striped thead {
            background-color: #3b5de7;
            color: #ffffff;
        }
    </style>
</head>

<body data-layout="detached" data-topbar="colored">

    @yield('app')
    
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Pace  -->
    <script src="{{ asset('assets/js/pages/pace.min.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- select 2  -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- masonry-layout -->
    <script src="{{ asset('assets/libs/masonry-layout/masonry.pkgd.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
     <!-- filepond -->
    <script src='{{ asset('assets/libs/filepond/filepond.min.js') }}'></script>
    <script src='{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}'></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    {{-- @if (isset($jsInit))
        <script src="{{ asset('javascript/' . $jsInit) }}"></script>
    @endif --}}

    @if (isset($mods))
        @if (is_array($mods))
            @foreach ($mods as $mod)
                <script src="{{ asset('mods/mod_' . $mod . '.js') }}"></script>
            @endforeach
        @else
            <script src="{{ asset('mods/mod_' . $mods . '.js') }}"></script>
        @endif
    @endif
</body>

</html>
