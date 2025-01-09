@extends('layout.app')

@section('content')
<section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center" style="background: url('{{ asset('storage/images/settings/' . getSetting('app_bg')) }}') center center; width: 100%; min-height: 100vh; background-size: cover; padding: 120px 0 60px;"  >
  <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
      <h2 class="text-white text-center">{{ getSetting('app_name') }}</h2>
  </div>
</section>

<section id="jadwal" class="jadwal" style="padding: 60px 0 100px 0">
  <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Jadwal Mahasiswa</h5>
      <ul class="nav nav-pills w-100 mb-2">
          <li class="flex-fill">
              <a  class="nav-link text-center fw-bold {{ $activeTab === 'pra_seminar' ? 'active' : '' }}"   href="{{ url()->current() }}?active_tab=pra_seminar&tanggal={{ $tanggal }}"  style="color: var(--primary-color)">
                  Akan Seminar
              </a>
          </li>
          <li class="flex-fill">
              <a class="nav-link text-center fw-bold {{ $activeTab === 'pra_sidang' ? 'active' : '' }}" href="{{ url()->current() }}?active_tab=pra_sidang&tanggal={{ $tanggal }}" style="color: var(--primary-color)">
                  Akan Sidang
              </a>
          </li>
      </ul>

      <ul class="nav nav-pills w-100 mb-3">
          @foreach ($tanggalTabs as $tabTanggal)
              <li class="flex-fill">
                  <a class="nav-link text-center {{ $tabTanggal === $tanggal ? 'active' : '' }}" style="font-size: 14px; color: var(--primary-color)"  href="{{ url()->current() }}?active_tab={{ $activeTab }}&tanggal={{ $tabTanggal }}">
                      {{ $tabTanggal }}
                  </a>
              </li>
          @endforeach
      </ul>

      @forelse ($jadwal as $key => $item)
          <div class="row p-1 mt-3 g-0 mb-3 align-items-center" style="max-width: 750px;">
              <div class="col-md-2">
                  <img id="modal-image-{{ $key }}" src="{{ $item->poster == null ? 'https://ui-avatars.com/api/?background=random&name='. urlencode($item->nama) : asset('storage/files/pemberkasan/' . $item->poster) }}" alt="Poster" class="img-fluid" style="width: 120px; height: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imagePreviewModal-{{ $key }}">
                  <div class="modal fade" id="imagePreviewModal-{{ $key }}" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5);">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <div class="modal-body p-0">
                                  <img id="preview-image-{{ $key }}" src="{{ $item->poster == null ? 'https://ui-avatars.com/api/?background=random&name='. urlencode($item->nama) : asset('storage/files/pemberkasan/' . $item->poster) }}" alt="Preview Poster" class="img-fluid preview-image">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-10">
                  <div class="ps-3">
                      <p class="m-0">{{ $item->jam }} WIB</p>
                      <h6 class="m-0"><b>{{ $item->judul_ta }}</b></h6>
                      <p class="m-0">
                          <span class="badge me-2" style="background-color: #dfdfdf; color:var(--primary-color); letter-spacing: 1px">{{ $item->tipe }}</span> |
                          <span class="ms-2">{{ $item->topik }}</span>
                      </p>
                      <p class="m-0 fw-bold" style="font-size: 16px">{{ $item->nama }}</p>
                      <p class="text-muted small m-0" style="font-size: 14px">
                          Pembimbing: <span class="me-2">{{ $item->pembimbing_1 }}</span> /
                          <span class="ms-2">{{ $item->pembimbing_2 }}</span>
                      </p>
                      <p class="text-muted small m-0" style="font-size: 14px">
                          Penguji: <span class="me-2">{{ $item->penguji_1 }}</span> /
                          <span class="ms-2">{{ $item->penguji_2 }}</span>
                      </p>
                  </div>
              </div>
          </div>
      @empty
          <p class="text-center " style="color: #aeaeae">Belum ada data</p>
      @endforelse

      <div class="d-flex justify-content-center mt-5">
        @if ($jadwal->hasPages())
          <nav>
              <ul class="pagination justify-content-center">
                  @if ($jadwal->onFirstPage())
                      <li class="page-item disabled"><span class="page-link"> < </span></li>
                  @else
                      <li class="page-item"><a class="page-link" href="{{ $jadwal->previousPageUrl() }}"> < </a></li>
                  @endif
                  @foreach ($jadwal->getUrlRange(1, $jadwal->lastPage()) as $page => $url)
                      @if ($page == 1 || $page == $jadwal->lastPage() || abs($page - $jadwal->currentPage()) <= 1)
                          @if ($page == $jadwal->currentPage())
                              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                          @else
                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                          @endif
                      @elseif ($loop->iteration == 2 || $loop->iteration == ($jadwal->lastPage() - 1))
                          <li class="page-item disabled"><span class="page-link">...</span></li>
                      @endif
                  @endforeach
                  @if ($jadwal->hasMorePages())
                      <li class="page-item"><a class="page-link" href="{{ $jadwal->nextPageUrl() }}"> > </a></li>
                  @else
                      <li class="page-item disabled"><span class="page-link"> > </span></li>
                  @endif
              </ul>
          </nav>
      @endif
      </div>
  </div>
</section>

<section id="mahasiswa" class="mahasiswa" style="padding: 60px 0 100px 0">
  <div class="container">
      <h5 class="font-size-24 text-center m-0 fw-bold mb-1">Daftar Mahasiswa</h5>
      <ul class="nav nav-pills w-100 mb-5">
          <li class="flex-fill">
              <a class="nav-link {{ $tabs === 'seminar' ? 'active' : '' }} text-center fw-bold"  href="{{ url()->current() . '?tabs=seminar' }}" style="color: var(--primary-color)">
                  Sudah Seminar
              </a>
          </li>
          <li class="flex-fill">
              <a class="nav-link {{ $tabs === 'sidang' ? 'active' : '' }} text-center fw-bold"  href="{{ url()->current() . '?tabs=sidang' }}" style="color: var(--primary-color)">
                  Sudah Sidang
              </a>
          </li>
      </ul>
      
      @foreach ($completed as $key => $item)
          <div class="row p-1 mt-3 g-0 mb-3 align-items-center" style="max-width: 750px;">
              <div class="col-md-2">
                  <img id="modal-image-{{ $key }}" src="{{ $item->poster == null ? 'https://ui-avatars.com/api/?background=random&name='. urlencode($item->nama) : asset('storage/files/pemberkasan/' . $item->poster) }}"
                  alt="Poster" class="img-fluid" style="width: 120px; height: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imagePreviewModal-{{ $key }}">
                  <div class="modal fade" id="imagePreviewModal-{{ $key }}" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.5);">
                      <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <div class="modal-body p-0">
                                  <img id="preview-image-{{ $key }}" src="{{ $item->poster == null ? 'https://ui-avatars.com/api/?background=random&name='. urlencode($item->nama) : asset('storage/files/pemberkasan/' . $item->poster) }}" alt="Preview Poster" class="img-fluid preview-image">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-10">
                  <div class="ps-3">
                      <h6 class="m-0"><b>{{ $item->judul_ta ?? '-' }}</b></h6>
                      <p class="m-0">
                          <span class="badge me-2" style="background-color: #dfdfdf; color:var(--primary-color); letter-spacing: 1px">{{ $item->tipe ?? '-' }}</span> |
                          <span class="ms-2">{{ $item->topik ?? '-' }}</span>
                      </p>
                      <p class="m-0 fw-bold" style="font-size: 16px">{{ $item->nama ?? '-' }}</p>
                      <p class="text-muted small m-0" style="font-size: 14px">
                          Pembimbing: <span class="me-2">{{ $item->pembimbing_1 ?? '-' }}</span> /
                          <span class="ms-2">{{ $item->pembimbing_2 ?? '-' }}</span>
                      </p>
                      <p class="text-muted small m-0" style="font-size: 14px">
                          Penguji: <span class="me-2">{{ $item->penguji_1 ?? '-' }}</span> /
                          <span class="ms-2">{{ $item->penguji_2 ?? '-' }}</span>
                      </p>
                  </div>
              </div>
          </div>
      @endforeach
  </div>
  <div class="d-flex justify-content-center mt-5">
    @if ($completed->hasPages())
      <nav>
          <ul class="pagination justify-content-center">
              @if ($completed->onFirstPage())
                  <li class="page-item disabled"><span class="page-link"> < </span></li>
              @else
                  <li class="page-item"><a class="page-link" href="{{ $completed->previousPageUrl() }}"> < </a></li>
              @endif
              @foreach ($completed->getUrlRange(1, $completed->lastPage()) as $page => $url)
                  @if ($page == 1 || $page == $completed->lastPage() || abs($page - $completed->currentPage()) <= 1)
                      @if ($page == $completed->currentPage())
                          <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                      @else
                          <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                      @endif
                  @elseif ($loop->iteration == 2 || $loop->iteration == ($completed->lastPage() - 1))
                      <li class="page-item disabled"><span class="page-link">...</span></li>
                  @endif
              @endforeach
              @if ($completed->hasMorePages())
                  <li class="page-item"><a class="page-link" href="{{ $completed->nextPageUrl() }}"> > </a></li>
              @else
                  <li class="page-item disabled"><span class="page-link"> > </span></li>
              @endif
          </ul>
      </nav>
  @endif
  </div>
</section>

@endsection