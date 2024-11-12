@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @if(getInfoLogin()->hasRole('Mahasiswa') || getInfoLogin()->hasRole('Developer'))
            <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="d-block d-sm-none"><i class="mdi mdi-book-open"></i></span>
                        <span class="d-none d-sm-block">Tawaran Tugas Akhir</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apps.topik-yang-diambil') }}">
                        <span class="d-block d-sm-none"><i class="mdi mdi-note-plus-outline"></i></span>
                        <span class="d-none d-sm-block">Tugas Akhir Diambil</span>
                    </a>
                </li>
            </ul>
            @endif
            <div class="card-body">
                @if(session('switchRoles') == 'Dosen')
                @can('create-rekomendasi-topik')
                <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                <hr>
                @endcan
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
                                <th width="5%"> No</th>
                                <th width="30%">Topik</th>
                                <th width="20%" style="white-space: nowrap">Jenis Penyelesaian</th>
                                <th style="white-space: nowrap">Jenis Topik</th>
                                @if(in_array(session('switchRoles'), ['Dosen','Developer']))
                                    @if(getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Developer'))
                                    <th>Pengambil:</th>
                                    @endif
                                @endif
                                @if(in_array(session('switchRoles'), ['Mahasiswa','Developer', 'Kaprodi','Kajur']))
                                <th style="white-space: nowrap">Nama Dosen</th>
                                @endif
                                @if(getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Developer') || getInfoLogin()->hasRole('Kaprodi'))
                                <th>Status:</th>
                                @endif
                                @if(session('switchRoles') !== 'Kajur')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if(in_array(session('switchRoles'), ['Dosen']))
                                        <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small mb-1">{{ $item->program_studi->nama }}</span></p>
                                    @endif
                                    <p class="fw-bold m-0" style="text-align: justify">{{ $item->judul }}</p>
                                    <p class="m-0 text-muted small" style="text-align: justify"><strong>Deskripsi :</strong> {{ $item->deskripsi ?? '-' }}</p>
                                    @if($item->catatan != null)
                                    <p class="m-0 text-muted small">Catatan : <span class="text-danger"> {{ $item->catatan }}</span></p>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <span class="badge rounded-pill bg-dark-subtle text-body small mb-1">{{ $item->tipe }}</span>
                                            <p class="m-0 p-0 text-muted small">Jumlah Kuota : {{ $item->ambilTawaran()->where('status', 'Disetujui')->count() }}/{{$item->kuota}}</p>
                                            <p class="m-0 p-0 text-muted small">Jumlah Pengambil : {{$item->ambilTawaran()->where('status', '!=', 'Ditolak')->count()}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><p class="small">{{ $item->jenisTa->nama_jenis }}</p></td>
                                @if(in_array(session('switchRoles'), ['Dosen','Developer']))
                                    @if(getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Developer'))
                                    <td>
                                        @if($item->ambilTawaran->isEmpty())
                                        -
                                        @else
                                        <ul>
                                            @foreach ($item->ambilTawaran()->where('status','!=','Ditolak')->get() as $tawaran)
                                            <li class="small">{{ $tawaran->mahasiswa->nama_mhs }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </td>
                                    @endif
                                @endif
                                @if(in_array(session('switchRoles'), ['Mahasiswa','Developer', 'Kaprodi','Kajur']))
                                <td><p class="small">{{ $item->dosen->name}}</td></p>
                                @endif
                                @if(getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Developer') || getInfoLogin()->hasRole('Kaprodi'))
                                <td><span class="badge small {{ isset($item->status) ? ($item->status == 'Menunggu' ? 'bg-dark-subtle text-body' : ($item->status == 'Disetujui' ? 'badge-soft-success' : 'badge-soft-danger')) : '-'}}">{{ $item->status ?? '-' }}</span></td>
                                @endif
                                @if(session('switchRoles') !== 'Kajur') 
                                <td>
                                    @if (session('switchRoles') === 'Dosen')
                                        @if (getInfoLogin()->hasRole('Dosen') || getInfoLogin()->hasRole('Developer'))
                                            @can('update-rekomendasi-topik')
                                                <button onclick="editData('{{ $item->id }}', '{{route('apps.rekomendasi-topik.show', $item->id)}}')" class="btn btn-outline-primary btn-sm mx-1 my-1" title="Edit"><i class="bx bx-edit-alt"></i></button>
                                            @endcan
                                            @can('delete-rekomendasi-topik')
                                                <button onclick="hapusRekomendasi('{{ $item->id }}', '{{ route('apps.rekomendasi-topik.delete', $item->id) }}')" class="btn btn-outline-dark btn-sm mx-1 my-1" title="Hapus"><i class="bx bx-trash"></i></button>
                                            @endcan
                                            <a href="{{ route('apps.rekomendasi-topik.detail', $item->id) }}" class="btn btn-outline-warning btn-sm mx-1 my-1" title="Detail"><i class="bx bx-show"></i></a>
                                        @endif
                                    @endif
                                    @if(getInfoLogin()->hasRole('Mahasiswa') || getInfoLogin()->hasRole('Developer'))
                                        <button class="btn btn-outline-success btn-sm mx-1 my-1" data-toggle="get-topik" data-id="{{ $item->id }}" title="Ambil Topik"><i class="bx bx-check-circle"></i></button>
                                    @endif
                                    @if (session('switchRoles') === 'Kaprodi')
                                        @if(getInfoLogin()->hasRole('Kaprodi') || getInfoLogin()->hasRole('Developer'))
                                            @if($item->status !== 'Disetujui')
                                            <button class="btn btn-outline-success btn-sm mx-1 my-1" data-toggle="acc" data-url="{{ route('apps.rekomendasi-topik.acc', $item->id) }}" title="Setujui"><i class="bx bx-check-circle"></i></button>
                                            <button class="btn btn-outline-danger btn-sm mx-1 my-1" data-toggle="reject-topik" data-url="{{ route('apps.rekomendasi-topik.rejcet-topik', $item->id) }}" title="Tolak"><i class="bx bx-x"></i></button>
                                            @else
                                            -
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                @endif
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
 <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="myModalAccLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0"></h5>
            </div>
            <form action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Catatan</label>
                        <textarea name="catatan" class="form-control"></textarea>
                        <i>Silahkan tuliskan catatan (opsional):</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
