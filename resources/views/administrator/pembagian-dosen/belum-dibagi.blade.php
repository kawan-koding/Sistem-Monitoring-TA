@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @can('read-pembagian-dosen')
            <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apps.pembagian-dosen')}}">
                        <span class="d-block d-sm-none"><i class="mdi mdi-check-circle-outline"></i></span>
                        <span class="d-none d-sm-block">Sudah Terbagi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="d-block d-sm-none"><i class="mdi mdi-av-timer"></i></span>
                        <span class="d-none d-sm-block">Belum Terbagi</span>
                    </a>
                </li>
            </ul>
            @endcan

            <div class="card-body">
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
                                <th width="40%">Judul</th>
                                <th>Mahasiswa</th>
                                <th>Dosen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge {{ isset($item->status) ? ($item->status == 'acc' ? 'badge-soft-success' : ($item->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : '-'}} small mb-1"> {{ ucfirst($item->status ?? '-')}} </span>
                                        <p class="m-0"><strong>{{ $item->judul }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->topik->nama_topik }} - {{ $item->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>{{ $item->mahasiswa->nama_mhs }}</td>
                                    <td>
                                        <strong>Pembimbing</strong>
                                        <ol>
                                            @forelse ($item->bimbing_uji->where('jenis', 'pembimbing')->sortBy('urut') as $pembimbing)
                                                <li>{{ $pembimbing->dosen->name }}</li>
                                            @empty
                                                <li>-</li>
                                            @endforelse
                                        </ol>
                                        <strong>Penguji</strong>
                                        <ol>
                                            @forelse ($item->bimbing_uji->where('jenis', 'penguji')->sortBy('urut') as $penguji)
                                                <li>{{ $penguji->dosen->name }}</li>
                                            @empty
                                            <li>-</li>
                                            @endforelse
                                        </ol>
                                    </td>
                                    <td>
                                        <a href="{{ route('apps.pembagian-dosen.edit', $item)}}" class="btn btn-sm btn-outline-primary mb-3" title="Edit"><i class="bx bx-edit-alt"></i></a>
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