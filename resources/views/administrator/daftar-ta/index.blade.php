@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @if (in_array(session('switchRoles'), ['Admin','Developer','Kajur']))
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <a href="{{ route('apps.daftar-ta.export') }}" target="_blank" class="btn btn-primary mb-3 mb-md-0" style="max-width: 150px;">
                        <i class="fa fa-file-excel"></i> Export Data
                    </a>
                        {{-- <form method="GET" action="{{ route('apps.daftar-ta') }}" class="d-flex align-items-center">
                            <div class="input-group">
                                <select name="tipe" id="tipe" class="form-control" onchange="this.form.submit()">
                                    <option disabled selected hidden>Filter Berdasarkan Program Studi : </option>
                                    <option value="Semua" {{ request('tipe') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id }}" {{ request('tipe') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form> --}}
                        <form action="" >
                            <div class="d-flex gap-2 flex-column flex-md-row">
                                <select name="program_studi" id="program_studi" class="form-control" onchange="this.form.submit()">
                                    <option selected disabled hidden>Filter Program Studi</option>
                                    <option value="semua" {{ request('program_studi') == 'semua' ? 'selected' : '' }}>Semua Program Studi</option>
                                    @foreach($prodi as $p)
                                        <option value="{{ $p->id }}" {{ request('program_studi') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                <select name="periode" id="periode" class="form-control" onchange="this.form.submit()">
                                    <option selected disabled hidden>Filter Periode</option>
                                    <option value="semua" {{ request('periode') == 'semua' ? 'selected' : '' }}>Semua Periode</option>
                                    @foreach($periode as $p)
                                        <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>{{ $p->nama }} - {{ 'Prodi' . ' ' . $p->programStudi->display }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                    </div>
                    <hr>
                @endif

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
                                <th width="20%">Mahasiswa</th>
                                <th width="40%">Judul</th>
                                <th width="20%">Dosen</th>
                                <th width="10%">Periode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="m-0 badge rounded-pill bg-primary-subtle text-primary small">{{ $item->mahasiswa->programStudi->display }}</p>                                            
                                        <p class="m-0 p-0 small fw-bold">{{ $item->mahasiswa->nama_mhs }}</p>
                                        <p class="m-0 p-0 text-muted small">NIM : {{$item->mahasiswa->nim}}</p>
                                    </td>
                                    <td>
                                        <span class="badge {{ isset($item->status) ? ($item->status == 'acc' ? 'badge-soft-success' : ($item->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : '-'}} small mb-1"> {{ ucfirst($item->status ?? '-')}} </span>
                                        <p class="m-0 small"><strong>{{ $item->judul }}</strong></p>
                                        <p class="m-0 text-muted font-size-15 small">{{ $item->topik->nama_topik }} - {{ $item->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-bold small m-0">Pembimbing</p>
                                        <ol>
                                            @foreach ($item->bimbing_uji->where('jenis', 'pembimbing')->sortBy('urut') as $pembimbing)
                                                <li class="small">{{ $pembimbing->dosen->name }}</li>
                                            @endforeach
                                        </ol>
                                        <p class="fw-bold small m-0">Penguji</p>
                                        <ol>
                                            @foreach ($item->bimbing_uji->where('jenis', 'penguji')->sortBy('urut') as $penguji)
                                                <li class="small">{{ $penguji->dosen->name }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td><p class="small">{{ $item->periode_ta->nama }}</p></td>
                                    <td>
                                        @can('update-daftar-ta')
                                        <a href="{{ route('apps.daftar-ta.edit', $item)}}" class="btn btn-sm btn-outline-primary mb-1" title="Edit"><i class="bx bx-edit-alt"></i></a>
                                        @endcan
                                        @can('read-daftar-ta')
                                        <a href="{{ route('apps.daftar-ta.show', $item)}}" class="btn btn-sm btn-outline-warning mb-1" title="Detail"><i class="bx bx-show"></i></a>
                                        @endcan
                                        @can('delete-daftar-ta')
                                        <button onclick="hapusDaftarTa('{{ $item->id }}', '{{ route('apps.daftar-ta.delete', $item->id) }}')" class="btn btn-sm btn-outline-dark mb-3" title="Hapus"><i class="bx bx-trash"></i></button>
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
