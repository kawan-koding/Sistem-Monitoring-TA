@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex flex-column flex-md-row justify-content-start align-items-center gap-2">
                    <label for="filter" class="mb-0">Filter Berdasarkan:</label>
                    <form action="" method="GET">
                        <div class="d-flex gap-2 flex-column flex-md-row">
                            <!-- Hidden Input -->
                            <input name="is_completed" type="hidden" value="{{ request('is_completed', 1) }}">
                
                            <!-- Select Input -->
                            <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                                <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>Semua Jenis Penyelesaian</option>
                                <option value="I" {{ $filter == 'I' ? 'selected' : '' }}>Individu</option>
                                <option value="K" {{ $filter == 'K' ? 'selected' : '' }}>Kelompok</option>
                            </select>
                        </div>
                    </form>
                </div>
                
                @can('read-pembagian-dosen')
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if(url()->full() == route('apps.pembagian-dosen')) active @endif" href="{{ route('apps.pembagian-dosen')}}">
                            <span class="d-block d-sm-none"><i class="mdi mdi-check-circle-outline"></i></span>
                            <span class="d-none d-sm-block">Sudah Dibagi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(url()->full() == route('apps.pembagian-dosen', ['is_completed' => false])) active @endif" href="{{ route('apps.pembagian-dosen', ['is_completed' => false]) }}">
                            <span class="d-block d-sm-none"><i class="mdi mdi-av-timer"></i></span>
                            <span class="d-none d-sm-block">Belum Dibagi</span>
                        </a>
                    </li>
                </ul>
                @endcan
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
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Mahasiswa</th>
                                <th width="40%">Judul</th>
                                <th>Dosen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            {{-- @dd($item->where('is_completed', false)->first()) --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="small fw-bold m-0">{{ $item->mahasiswa->nama_mhs }}</p>
                                        <p class="m-0 p-0 text-muted small">NIM : {{$item->mahasiswa->nim}}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-soft-primary small mb-1 fw-bold">{{ $item->tipe == 'I' ? 'Individu' : 'Kelompok' }}</span>
                                        <p class="m-0 small font-size-14"><strong>{{ $item->judul }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->topik->nama_topik }} - {{ $item->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold small m-0">Pembimbing</p>
                                        <ol>
                                        @for ($i = 0; $i < 2; $i++)
                                            @if ($item->bimbing_uji()->where('jenis', 'pembimbing')->count() > $i)
                                                @foreach ($item->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 1 && $i == 0)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 2 && $i == 1)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif
                                        @endfor
                                        </ol>
                                        <p class="fw-bold small m-0">Penguji</p>
                                        <ol>
                                        @for ($i = 0; $i < 2; $i++)
                                            @if ($item->bimbing_uji()->where('jenis', 'penguji')->count() > $i)    
                                                @foreach ($item->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 1 && $i == 0)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 2 && $i == 1)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif
                                        @endfor
                                        </ol>
                                    </td>
                                    <td>
                                    <div class="badge {{ $item->is_completed ? 'badge-soft-success' : 'badge-soft-dark' }}">{{ $item->is_completed ? 'Sudah Dibagi' : 'Belum Dibagi' }}</div>
                                    </td>
                                    <td>
                                        @can('update-pembagian-dosen')
                                        <a href="{{ route('apps.pembagian-dosen.edit', $item)}}" class="btn btn-sm btn-outline-primary mx-1 my-1" title="Edit"><i class="bx bx-edit-alt"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>  
</div>

@endsection