@extends('layout.auth-main')
@section('content')

<style>
    body {
      background-color: #f8f9fa;
    }
    
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    
    .card-title {
      margin-bottom: 0.5rem;
    }
    
    .card-icon {
      font-size: 3rem;
      color: #6c757d;
    }
</style>

<div class="home-btn d-none d-sm-block">
    {{-- <a href="index.html" class="text-reset"><i class="fas fa-home h2"></i></a> --}}
</div>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            @if ((isset($data[0])) && $data[0] == 'admin' || (isset($data[1])) && $data[1] == 'admin' || (isset($data[2])) && $data[2] == 'admin' || (isset($data[3])) && $data[3] == 'admin') 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Admin</h5>
                      <p class="card-text">Masuk sebagai admin.</p>
                      <a href="{{route('admin.switcher', ['role' => 'admin'])}}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif
            @if ((isset($data[0])) && $data[0] == 'kaprodi' || (isset($data[1])) && $data[1] == 'kaprodi' || (isset($data[2])) && $data[2] == 'kaprodi' || (isset($data[3])) && $data[3] == 'kaprodi') 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Kaprodi</h5>
                      <p class="card-text">Masuk sebagai kaprodi.</p>
                      <a href="{{route('admin.switcher', ['role' => 'kaprodi'])}}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif
            @if ((isset($data[0])) && $data[0] == 'dosen' || (isset($data[1])) && $data[1] == 'dosen' || (isset($data[2])) && $data[2] == 'dosen' || (isset($data[3])) && $data[3] == 'dosen') 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Dosen</h5>
                      <p class="card-text">Masuk sebagai dosen.</p>
                      <a href="{{route('admin.switcher', ['role' => 'dosen'])}}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif
            @if ((isset($data[0])) && $data[0] == 'mahasiswa' || (isset($data[1])) && $data[1] == 'mahasiswa' || (isset($data[2])) && $data[2] == 'mahasiswa' || (isset($data[3])) && $data[3] == 'mahasiswa') 
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                      <i class="fas fa-user-tie card-icon"></i>
                      <h5 class="card-title mt-3">Mahasiswa</h5>
                      <p class="card-text">Masuk sebagai mahasiswa.</p>
                      <a href="{{route('admin.switcher', ['role' => 'mahasiswa'])}}" class="btn btn-primary">Masuk</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
