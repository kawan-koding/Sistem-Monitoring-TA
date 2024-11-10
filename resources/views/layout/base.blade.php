<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="shortcut icon" href="{{ asset('storage/images/settings/' . getSetting('app_favicon')) }}">
    <title> {{ $title ?? 'unknown'}} | {{ getSetting('app_name') }}</title>
    <!-- Favicons -->
    <link href="{{ asset('storage/images/settings/' . getSetting('app_favicon')) }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing-assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('landing-assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('landing-assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{ asset('landing-assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('landing-assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <!-- Variables CSS Files. Uncomment your preferred color scheme -->
    <link href="{{ asset('landing-assets/css/variables.css')}}" rel="stylesheet">
     <!-- Icons Css -->
    <link href="{{ asset('landing-assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Template Main CSS File -->
    <link href="{{ asset('landing-assets/css/main.css')}}" rel="stylesheet">
</head>
<body>
    <div class="preloader">
        <img class="preloader__image" width="60" src="{{ asset('storage/images/settings/' . getSetting('app_favicon'))}}" alt="" />
    </div>
    @yield('app')

    <!-- Vendor JS Files -->
    <script src="{{ asset('landing-assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('landing-assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('landing-assets/vendor/php-email-form/validate.js')}}"></script>
    <!-- Apexcharts -->
    <script src="{{ asset('landing-assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('landing-assets/js/apexcharts.init.js')}}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('landing-assets/js/main.js')}}"></script>
    @yield('scripts')
</body>
</html>