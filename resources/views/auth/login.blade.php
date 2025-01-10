@extends('administrator.layout.base')
@section('app')

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-login text-center">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">{{ getSetting('app_name') }}</h5>
                            <p class="text-white-50 mb-0">Politeknik Negeri Banyuwangi</p>
                            <a href="#" class="logo logo-admin mt-4">
                                <img src="{{ asset('storage/images/settings/' . getSetting('app_logo') )}}" alt="" height="60">
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
                        @if ($errors->any())
                            <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
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
                                <div class="form-group position-relative">
                                    <label>Password </label>
                                    <input class="form-control" name="password" id="passwordInput" type="password" placeholder="Enter Password"/>
                                    <span id="togglePassword" class="profile-views bx bx-show-alt position-absolute" style="font-size: 16px; right: 10px; top: 50px; transform: translateY(-50%); cursor: pointer" ></span>
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
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('passwordInput');
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        this.classList.toggle('bx-show-alt');
        this.classList.toggle('bx-hide');
    });
</script>
@endsection