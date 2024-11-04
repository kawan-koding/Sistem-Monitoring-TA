@extends('layout.app')
@section('content')
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;"  >
  <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
      <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
      <div class="d-flex justify-content-center" style="width: 100%; max-width: 500px">
        <form class="search-bar {{ request('search') ? 'has-value' : '' }}" action="{{ route('guest.judul-tugas-akhir')}}" method="GET">
          <input type="text" placeholder="Cari Judul..." value="{{ request('search') }}" name="search">
          @if(request('search'))
              <a href="{{ route('guest.judul-tugas-akhir') }}" title="Reset" class="btn btn-link text-dark" style="padding: 0;">
                  <i class="bx bx-x"></i>
              </a>
          @endif
          <button type="submit" title="Cari"><i class="bx bx-search"></i></button>
        </form>
      </div>
  </div>
</section>

<section style="padding: 60px 0 100px 0">
  <div class="container">
    <div class="text-center mb-5">
      <h5 class="font-size-24  m-0 fw-bold" style="color: var(--primary-color)">Judul Tugas Akhir Yang Disetujui</h5>
    </div>
    @forelse ($query as $item)
    <div class="info-item d-flex mb-4">
        <div>
            <p class="m-0"><span class="badge" style="background-color: #AFB0DA; color:var(--primary-color); letter-spacing: 1px">{{ $item->tipe == 'I' ? 'Individu' : 'Kelompok' }}</span></p>
            <h6 class="m-0 "><b>{{ $item->judul }}</b></h4>
            <p class="m-0">{{ $item->mahasiswa->nama_mhs }}</p>
            <p class="m-0">{{ $item->jenis_ta->nama_jenis}} - {{ $item->topik->nama_topik }}</p>
            <p class="text-muted small m-0"><span class="me-2">
                @foreach ($item->bimbing_uji()->where('jenis', 'pembimbing')->orderBy('urut','asc')->get() as $dosen)
                <i class="bx bx-user me-1"></i> {{ $dosen->dosen->name }} 
                @if(!$loop->last)/@endif
                @endforeach
                </span> 
            </p>
        </div>
    </div>
    @if(!$loop->last)
    <hr>
    @endif
    @empty
      <p class="text-center" style="color: #aeaeae">Data tidak ditemukan</p>
    @endforelse
  </div>
</section>

@endsection