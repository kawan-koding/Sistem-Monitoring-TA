@extends('layout.app')
@section('content')
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;"  >
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
    <div class="info" id="info">
      @forelse ($tawaran as $item)
      <div class="info-item d-flex">
        <div class="row w-100">
          <div class="col-lg-12">
            <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small mb-1">{{ $item->program_studi->nama }}</span></p>
            <h6 class="m-0"><b>{{ $item->judul }}</b></h4>
            <p class="m-0" style="font-size: 14px">
              <span class="short-description">{{ Str::limit($item->deskripsi, 200) }}</span>
              <span class="full-description d-none">{{ $item->deskripsi }}</span>
              @if(strlen($item->deskripsi) > 200)<a href="javascript:void(0);" class="read-more" onclick="toggleDescription(this)">Selengkapnya</a>@endif
            </p>
            <p class="text-muted small m-0 info-details">
                <span class="dosen-info"><i class="bx bx-user me-1"></i>{{ $item->dosen->name }}</span>
                <span class="kuota-group">
                    <span class="kuota-info"><i class="bx bx-group me-1"></i>{{ $item->ambilTawaran()->where('status', 'Disetujui')->count() }}/{{ $item->kuota }} Kuota</span>
                    <span class="diambil-oleh-info">| Diambil oleh {{ $item->ambilTawaran()->where('status', '!=', 'Ditolak')->count() }} Mahasiswa</span>
                </span>
            </p>
          </div>
        </div>
      </div>
      @empty
      <p class="text-center " style="color: #aeaeae">Tidak ada tawaran</p>
      @endforelse
    </div>
  </div>
  <div class="d-flex justify-content-center mt-5">
    {{ $tawaran->links() }}
  </div>
</section>


@endsection