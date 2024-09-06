@extends('layout.auth-main')
@section('content')

<div class="home-btn d-none d-sm-block">
    {{-- <a href="index.html" class="text-reset"><i class="fas fa-home h2"></i></a> --}}
</div>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-login text-center">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">Sistem Monitoring Tugas Akhir</h5>
                            <p class="text-white-50 mb-0">Politeknik Negeri Banyuwangi</p>
                            <a href="index.html" class="logo logo-admin mt-4">
                                <img src="{{asset('images/POLIWANGI.png')}}" alt="" height="60">
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="p-2">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif

                            <form class="form-horizontal" method="post" action="{{ route('login.process') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter username">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="userpassword">Password</label>
                                    <input type="password" name="password" class="form-control" id="userpassword"
                                    placeholder="Enter password">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                        In</button>
                                    <a href="{{route("oauth.redirect")}}" class="btn btn-light w-100 waves-effect waves-light mt-3">Login With SSO</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    {{-- <p>Don't have an account ? <a href="pages-register.html"
                            class="fw-medium text-primary"> Signup now </a> </p> --}}
                    {{-- <p>©
                        <script>document.write(new Date().getFullYear())</script>. Crafted with <i
                            class="mdi mdi-heart text-danger"></i> by Themesbrand
                    </p> --}}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
