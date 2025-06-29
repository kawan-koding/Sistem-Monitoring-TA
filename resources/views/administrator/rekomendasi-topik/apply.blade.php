@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @if(auth()->user()->hasRole('Mahasiswa') || auth()->user()->hasRole('Developer'))
            <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apps.rekomendasi-topik') }}">
                        <span class="d-block d-sm-none"><i class="mdi mdi-book-open"></i></span>
                        <span class="d-none d-sm-block">Tawaran Tugas Akhir</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="d-block d-sm-none"><i class="mdi mdi-note-plus-outline"></i></span>
                        <span class="d-none d-sm-block">Tugas Akhir Diambil</span>
                    </a>
                </li>
            </ul>
            @endif
            <div class="card-body">
                @if($message)
                <div class="alert alert-info alert-dismissible fade show mb-2" role="alert">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>{{ $message }}
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
                                <th>Judul Topik</th>
                                <th>Deskripsi</th>
                                <th>Dosen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->rekomendasiTopik->judul ?? '-'}}</td>
                                <td>{{ $item->description ?? '-'}}</td>
                                <td>{{ $item->rekomendasiTopik->dosen->name ?? "-"}}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'Menunggu' ? 'bg-warning' : ($item->status == 'Disetujui' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->status == 'Menunggu')
                                    <button title="Edit" class="btn btn-outline-primary btn-sm mx-1 my-1" onclick="editTopikTerkait('{{ $item->id }}', '{{ route('apps.edit-topik-terkait', $item->id) }}')"><i class="bx bx-edit-alt"></i></button>
                                    <button title="Hapus" class="btn btn-outline-dark btn-sm mx-1 my-1" onclick="hapusTopikTerkait('{{ $item->id }}', '{{ route('apps.hapus-topik-yang-diambil', $item->id) }}')"><i class="bx bx-trash"></i></button>
                                    @else
                                    -
                                    @endif
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

@include('administrator.rekomendasi-topik.partials.modal-apply')

@endsection