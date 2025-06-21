<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coming Soon</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">

                        <div class="card-body">

                            <div class="text-center p-3">

                                <div class="img">
                                    <img src="{{ asset('assets/images/coming-soon.png')}}" class="img-fluid" alt="">
                                </div>

                                <h1 class="error-page mt-5" style="font-size: 34px!important"><span>Coming Soon</span></h1>
                                <p class="mb-4 w-75 mx-auto">Mohon maaf, sistem masih dalam Perbaikan dan akan tersedia dalam.</p>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h3 class="mb-0 days-display">0</h3>
                                                    <p class="mb-0 small">Hari</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h3 class="mb-0 hours-display">0</h3>
                                                    <p class="mb-0 small">Jam</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h3 class="mb-0 minutes-display">0</h3>
                                                    <p class="mb-0 small">Menit</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h3 class="mb-0 seconds-display">0</h3>
                                                    <p class="mb-0 small">Detik</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- App js -->
    {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}
    <script>
    $(document).ready(function () {
        // Dapatkan waktu sekarang
        var now = new Date();

        // Buat target date: hari ini jam 23:59:59
        var target_date = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate(),
            23, 59, 59, 999
        ).getTime();

        var interval = setInterval(function () {
            var now = new Date().getTime();
            var distance = target_date - now;

            if (distance < 0) {
                clearInterval(interval);
                $(".days-display").text(0);
                $(".hours-display").text(0);
                $(".minutes-display").text(0);
                $(".seconds-display").text(0);
                return;
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $(".days-display").text(days);
            $(".hours-display").text(hours);
            $(".minutes-display").text(minutes);
            $(".seconds-display").text(seconds);
        }, 1000);
    });
    </script>
</body>
</html>
