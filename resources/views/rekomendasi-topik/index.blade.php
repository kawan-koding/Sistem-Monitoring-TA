@extends('layout.app')
@section('content')
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
  <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
      <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
      <div class="d-flex justify-content-center" style="width: 100%; max-width: 500px">
        <form class="search-bar {{ request('search') ? 'has-value' : '' }}" action="{{ route('guest.rekomendasi-topik')}}" method="GET">
          <input type="text" placeholder="Cari Judul..." value="{{ request('search') }}" name="search">
          @if(request('search'))
              <a href="{{ route('guest.rekomendasi-topik') }}" title="Reset" class="btn btn-link text-dark" style="padding: 0;">
                  <i class="bx bx-x"></i>
              </a>
          @endif
          <button type="submit" title="Cari"><i class="bx bx-search"></i></button>
        </form>
      </div>
  </div>
</section>

<section id="rekomendasi-topik" style="padding: 60px 0 100px 0" class="rekomendasi-topik">
  <div class="container">
    <div class="text-center mb-5">
      <h5 class="font-size-24  m-0 fw-bold" style="color: var(--primary-color)">Rekomendasi Topik Tugas Akhir</h5>
      <p class="text-muted"><span>Temukan topik yang sesuai dengan bidang keahlian kamu</span></p>
    </div>
    <div class="info">
      @forelse ($tawaran as $item)
      <div class="info-item d-flex">
        <div class="row w-100">
          <div class="col-lg-12">
            <h6 class="m-0"><b>{{ $item->judul }}</b></h4>
            <p class="m-0" style="font-size: 14px">{{ Str::limit($item->deskripsi, 150) }}</p>
            <p class="text-muted small m-0"><span class="me-2"><i class="bx bx-user me-1"></i> {{ $item->dosen->name }}</span> <i class="bx bx-group me-1"></i>{{ $item->ambilTawaran()->count() }}/{{ $item->kuota }} Kuota</p>
          </div>
        </div>
      </div>
      @empty
      <p class="text-center " style="color: #aeaeae">Tidak ada tawaran</p>
      @endforelse
    </div>
  </div>
</section>

@endsection