@extends('layout.base')
@section('app')
    <header id="header" class="header fixed-top" data-scrollto-offset="0">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home')}}" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
                <img src="{{ asset('storage/images/settings/' . getSetting('app_logo'))}}" alt="">
            </a>
            <nav id="navbar" class="navbar">
                <ul>
                  <li><a class="nav-link scrollto {{ request()->is('') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                  <li><a class="nav-link scrollto {{ request()->is('tawaran-topik') ? 'active' : '' }}" href="{{ route('guest.rekomendasi-topik') }}">Tawaran Topik</a></li>
                  <li><a class="nav-link scrollto {{ request()->is('tugas-akhir') ? 'active' : '' }}" href="{{ route('guest.judul-tugas-akhir') }}">Tugas Akhir</a></li>
                  <li><a class="nav-link scrollto {{ request()->is('jadwal') ? 'active' : '' }}" href="{{ route('guest.jadwal') }}">Jadwal</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle d-none"></i>
            </nav>
            <a class="btn-getstarted scrollto" href="{{ route('login')}}">Login</a>
        </div>
    </header>
    
    <main id="main">
        @yield('content')
    </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-content">
      <div class="container">
        <div class="row">

          <div class="col-lg-6 col-md-6">
            <div class="footer-info">
              <div class="" style="width: 60px; height: 60px; overflow: hidden;">
                <img src="{{ asset('storage/images/settings/' . getSetting('app_logo'))}}" alt="" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">
              </div>
              <p>
                {{ getSetting('app_address')}} 
                <br><br>
                <strong>Telp:</strong> {{ getSetting('app_phone') }}<br>
                <strong>Email:</strong> {{ getSetting('app_email') }}<br>
              </p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 footer-links">
            <h4>Halaman</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#hero-fullscreen">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#tawaran-topik">Tawaran Topik</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#judul-tugas-akhir">Tugas Akhir</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#jadwal">Jadwal</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="footer-legal text-center">
      <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div class="copyright">
            {{ getSetting('app_copyright')}}
          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="{{ getSetting('app_youtube')}}" class="youtube"><i class="bi bi-youtube"></i></a>
          <a href="{{ getSetting('app_facebook')}}" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="{{ getSetting('app_instagram')}}" class="instagram"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div>
  </footer>
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
@endsection