@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @if(auth()->user()->hasRole('Mahasiswa') || auth()->user()->hasRole('Developer'))
            <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Rekomendasi Topik</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apps.topik-yang-diambil') }}">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Topik Yang Anda Ambil</span>
                    </a>
                </li>
            </ul>
            @endif
            <div class="card-body">
                @if (!auth()->user()->hasRole('Mahasiswa'))
                <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
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
                                <th >Judul Topik</th>
                                <th>Jenis Penyelesaian</th>
                                <th>Jenis Topik</th>
                                @if(auth()->user()->hasRole('Dosen') || auth()->user()->hasRole('Developer'))
                                <th>Pengambil:</th>
                                @endif
                                @if(auth()->user()->hasRole('Mahasiswa') || auth()->user()->hasRole('Developer'))
                                <th>Nama Dosen</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                            <div>
                                                <span class="badge rounded-pill bg-dark-subtle text-body small mb-1">{{ $item->tipe }}</span>
                                                <p class="m-0 p-0 text-muted">Jumlah Kuota : {{$item->kuota}}</p>
                                            </div>
                                        </div>
                                </td>
                                <td>{{ $item->jenisTa->nama_jenis }}</td>
                                @if(auth()->user()->hasRole('Dosen') || auth()->user()->hasRole('Developer'))
                                <td>
                                    @if($item->ambilTawaran->isEmpty())
                                        -
                                    @else
                                        <ul>
                                            @foreach ($item->ambilTawaran as $tawaran)
                                                <li>{{ $tawaran->mahasiswa->nama_mhs }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                @endif
                                @if(auth()->user()->hasRole('Mahasiswa') || auth()->user()->hasRole('Developer'))
                                <td>{{ $item->dosen->name}}</td>
                                @endif
                                <td>
                                    @if (auth()->user()->hasRole('Dosen') || auth()->user()->hasRole('Developer'))
                                        @can('update-rekomendasi-topik')
                                        <button onclick="editData('{{ $item->id }}', '{{route('apps.rekomendasi-topik.show', $item->id)}}')" class="btn btn-primary btn-sm mx-1 my-1" title="Edit"><i class="bx bx-edit-alt"></i></button>
                                        @endcan
                                        @can('delete-rekomendasi-topik')
                                        <button class="btn btn-danger btn-sm mx-1 my-1" data-toggle="delete" data-url="{{ route('apps.program-studi.delete', $item->id) }}" title="Hapus"><i class="bx bx-trash"></i></button>
                                        @endcan
                                        <a href="{{ route('apps.rekomendasi-topik.detail', $item->id) }}" class="btn btn-success btn-sm mx-1 my-1" title="Detail"><i class="bx bx-detail"></i></a>
                                    @endif

                                    @if(auth()->user()->hasRole('Mahasiswa') || auth()->user()->hasRole('Developer'))
                                        <button class="btn btn-success btn-sm mx-1 my-1" data-toggle="get-topik" data-id="{{ $item->id }}" title="Ambil Topik"><i class="bx bx-check-circle"></i></button>
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
@include('administrator.rekomendasi-topik.partials.modal')
@include('administrator.rekomendasi-topik.partials.modal-apply')
@endsection