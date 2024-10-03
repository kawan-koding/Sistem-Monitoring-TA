@extends('administrator.layout.base')

@section('app')

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            @if (in_array('Admin', $roles)) 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Admin</h5>
                      <p class="card-text">Masuk sebagai admin.</p>
                      <a href="{{ route('apps.switcher', ['role' => 'Admin']) }}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif

            @if (in_array('Kaprodi', $roles)) 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Kaprodi</h5>
                      <p class="card-text">Masuk sebagai kaprodi.</p>
                      <a href="{{ route('apps.switcher', ['role' => 'Kaprodi']) }}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif

            @if (in_array('Dosen', $roles)) 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Dosen</h5>
                      <p class="card-text">Masuk sebagai dosen.</p>
                      <a href="{{ route('apps.switcher', ['role' => 'Dosen']) }}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif

            @if (in_array('Mahasiswa', $roles)) 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Mahasiswa</h5>
                      <p class="card-text">Masuk sebagai mahasiswa.</p>
                      <a href="{{ route('apps.switcher', ['role' => 'Mahasiswa']) }}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif

            @if (in_array('Developer', $roles)) 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-code card-icon"></i>
                      <h5 class="card-title mt-3">Developer</h5>
                      <p class="card-text">Masuk sebagai pengembang.</p>
                      <a href="{{ route('apps.switcher', ['role' => 'Developer']) }}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
