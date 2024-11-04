@extends('layout.app')

@section('content')

<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;"  >
  <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
      <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
      <p class="text-center text-white">Ajukan tugas akhir anda sekarang, explorasi ide-ide kreatif, dan bersama kita capai kesuksesan dalam perjalanan akademis yang luar biasa</p>
  </div>
</section>

<section id="tawaran-topik" style="padding: 60px 0 100px 0" class="rekomendasi-topik">
  <div class="container">
    <div class="text-center mb-5">
      <h5 class="font-size-24  m-0 fw-bold" style="color: var(--primary-color)">Tawaran Topik Tugas Akhir</h5>
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
      </div><!-- End Info Item -->
      @empty
      <p class="text-center " style="color: #aeaeae">Tidak ada tawaran</p>
      @endforelse
    </div>
    @if($tawaran->count() > 0)
    <div class="text-center mt-5">
      <a href="{{ route('guest.rekomendasi-topik')}}" style="color: var(--primary-color)">Lihat Lainnya <i class="bx bx-right-arrow-alt"></i></a>
    </div>
    @endif
  </div>
</section>

<section id="judul-tugas-akhir" style="padding: 60px 0 100px 0" class="judul-tugas-akhir">
  <div class="container">
    <h5 class="font-size-24 text-center m-0 fw-bold mb-5" style="color: var(--primary-color)">Judul Tugas Akhir Yang Disetujui</h5> 
      @forelse ($tugasAkhir as $item)
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
      @empty
      <p class="text-center " style="color: #aeaeae">Tidak ada tawaran</p>
      @endforelse

      @if($tugasAkhir->count() > 0)
        <div class="text-center mt-5">
          <a href="{{ route('guest.judul-tugas-akhir')}}" style="color: var(--primary-color)">Lihat Lainnya <i class="bx bx-right-arrow-alt"></i></a>
        </div>
      @endif
    </div>
  </section>
  
  <section id="jadwal" class="jadwal" style="padding: 60px 0 100px 0">
    <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Jadwal Mahasiswa</h5> 
      <ul class="nav nav-pills w-100 mb-1">
        <li class="flex-fill"><a class="nav-link active text-center fw-bold" data-bs-toggle="pill" href="#tab1" style="color: var(--primary-color)">Akan Seminar</a></li>
        <li class="flex-fill"><a class="nav-link text-center fw-bold" data-bs-toggle="pill" href="#tab2" style="color: var(--primary-color)">Akan Sidang</a></li>
      </ul>
      <ul class="nav nav-pills w-100 mb-3">
        <li class="flex-fill"><a class="nav-link active text-center" style="font-size: 14px; color: var(--primary-color)" data-bs-toggle="pill" href="#tab1">01 Januari 2024</a></li>
        <li class="flex-fill"><a class="nav-link text-center" style="font-size: 14px; color: var(--primary-color)" data-bs-toggle="pill" href="#tab2">02 Januari 2024</a></li class="flex-fill">
        <li class="flex-fill"><a class="nav-link text-center" style="font-size: 14px; color: var(--primary-color)" data-bs-toggle="pill" href="#tab2">03 Januari 2024</a></li class="flex-fill">
        <li class="flex-fill"><a class="nav-link text-center" style="font-size: 14px; color: var(--primary-color)" data-bs-toggle="pill" href="#tab2">04 Januari 2024</a></li>
        <li class="flex-fill"><a class="nav-link text-center" style="font-size: 14px; color: var(--primary-color)" data-bs-toggle="pill" href="#tab2">05 Januari 2024</a></li>
      </ul>

      <div class="row p-1 mt-3">
        <div class="col-lg-2">
          <p class="">11.00 - 11.00 WIB</p>
        </div>
        <div class="col-lg-10">
            <div>
              <h6 class="m-0 "><b>Sistem Informasi Manajemen Persuratan</b></h4>
              <p class="m-0"><span class="badge me-2" style="background-color: #AFB0DA; color:var(--primary-color); letter-spacing: 1px">Individu</span>|<span class="ms-2">Rancang Bangun - Penelitian</span></p>
              <p class="m-0 fw-bold" style="font-size: 16px">Rikiansyah Aris Kurniawan</p>
              <p class="text-muted small m-0" style="font-size: 14px">Pembimbing :<span class="me-2"> Dianni Yusuf, S.Kom., M.Kom</span>/<span class="ms-2"> Lutfi Hakim, S.Pd., M.T</span> </p>
              <p class="text-muted small m-0" style="font-size: 14px">Penguji :<span class="me-2"> Dianni Yusuf, S.Kom., M.Kom</span>/<span class="ms-2"> Lutfi Hakim, S.Pd., M.T</span> </p>
            </div>
        </div>
      </div>
      <div class="text-center mt-5">
        <a href="#" style="color: var(--primary-color)">Lihat Lainnya <i class="bx bx-right-arrow-alt"></i></a>
      </div>  
    </div>
  </section>

  <section id="mahasiswa" class="mahasiswa" style="padding: 60px 0 100px 0">
    <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Mahasiswa</h5> 
      <ul class="nav nav-pills w-100 mb-5">
        <li class="flex-fill"><a class="nav-link active text-center fw-bold" data-bs-toggle="pill" href="#tab1" style="color: var(--primary-color)">Sudah Seminar</a></li>
        <li class="flex-fill"><a class="nav-link text-center fw-bold" data-bs-toggle="pill" href="#tab2" style="color: var(--primary-color)">Sudah Sidang</a></li>
      </ul>
        <div class="row w-100 mb-4">
          <div class="col-lg-9">
            <h6 class="m-0"><b>Sistem Informasi Manajemen Persuratan</b></h4>
              <p class="m-0"><span class="badge me-2" style="background-color: #AFB0DA; color:var(--primary-color); letter-spacing: 1px">Individu</span>|<span class="ms-2">Rancang Bangun - Penelitian</span></p>
              <p class="m-0 fw-bold" style="font-size: 16px">Rikiansyah Aris Kurniawan</p>
              <p class="text-muted small m-0" style="font-size: 14px">Pembimbing :<span class="me-2"> Dianni Yusuf, S.Kom., M.Kom</span>/<span class="ms-2"> Lutfi Hakim, S.Pd., M.T</span> </p>
              <p class="text-muted small m-0" style="font-size: 14px">Penguji :<span class="me-2"> Dianni Yusuf, S.Kom., M.Kom</span>/<span class="ms-2"> Lutfi Hakim, S.Pd., M.T</span> </p>
          </div>
          <div class="col-lg-3 d-flex align-items-center justify-content-start mt-1 justify-content-lg-end">
            <button class="btn btn-sm btn-outline-primary"> Lihat Poster</button>
          </div>
        </div>
        <div class="text-center mt-5">
          <a href="#" class="">Lihat Lainnya <i class="bx bx-right-arrow-alt"></i></a>
        </div>  
    </div>
  </section>

  <section id="grafik" class="grafik" style="padding: 60px 0 100px 0">
    <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Statistik Tugas Akhir</h5>
      <div class="card mt-3">
        <div class="card-body">
          <div id="column_chart" class="apex-charts" dir="ltr"></div>
        </div>
      </div> 
    </div>
  </section>

@endsection