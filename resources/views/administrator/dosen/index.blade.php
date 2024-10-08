@extends('administrator.layout.main')
@section('content')

{{-- <style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table thead th {
        white-space: nowrap;
    }

    .table tbody td {
        white-space: nowrap;
    }

    @media (min-width: 992px) {
        
    }

</style> --}}

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                <a href="javascript:void(0);" onclick="importData()" class="btn btn-success"><i class="fa fa-file-excel"></i> Import</a>
                {{-- <a href="{{route('apps.dosen.tarik-data')}}" class="btn btn-secondary"><i class="fas fa-hand-paper"></i> Tarik Data</a> --}}
                <hr>
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
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>NIP/NIPPPK/NIK</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jenis Kelamin</th>
                                <th>Program Studi</th>
                                <th>Bidang Keahlian</th>
                                <th>Tanda Tangan</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDosen as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nip ?? '-'}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <strong>{{ucfirst($item->name)}}</strong>
                                            <p class="m-0 p-0 text-muted small">NIDN : {{$item->nidn}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-fex align-items-center">
                                        <div class="">
                                            <strong>{{ucfirst($item->email)}}</strong>
                                            <p class="m-0 p-0 text-muted small">{{$item->telp}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item->jenis_kelamin == 'L' ? 'Laki-laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : '-')}}</td>
                                <td class="text-center">{{$item->programStudi->nama ?? '-'}}</td>
                                <td class="text-center">{{$item->bidang_keahlian ??  '-'}}</td>
                                <td class="text-center">
                                    @if (isset($item->ttd))
                                    <a href="{{asset('storage/images/dosen/' .  $item->ttd)}}" target="_blank"><i class="bx bx-file"></i> Lihat</a>
                                    {{-- <img src="{{asset('storage/images/dosen/' .  $item->ttd)}}" width="100px" class="rounded-circle"> --}}
                                    @else
                                    <span> - </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button onclick="editData('{{ $item->id }}', '{{route('apps.dosen.show', $item->id)}}')" class="btn btn-primary btn-sm"><i class="bx bx-edit-alt"></i></a>
                                    <button class="btn btn-danger btn-sm mx-1 my-1" data-toggle="delete" data-url="{{ route('apps.dosen.delete', $item->id) }}"><i class="bx bx-trash"></i></button>
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

@include('administrator.dosen.partials.modal')

@endsection
