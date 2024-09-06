@extends('layout.admin-main')
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
                <a href="{{route('admin.dosen.tarik-data')}}" class="btn btn-secondary"><i class="fas fa-hand-paper"></i> Tarik Data</a>
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
                                <th>NIDN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Telp.</th>
                                <th>TTD.</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDosen as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nip}}</td>
                                <td>{{$item->nidn}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'}}</td>
                                <td>{{$item->telp}}</td>
                                <td>
                                    @if (isset($item->ttd))
                                    <img src="{{asset('images/'.$item->ttd)}}" width="100px">
                                    @else
                                    <span>*Belum memiliki gambar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0);" onclick="editData('<?= $item->id?>', '{{route('admin.dosen.show', ['id' => $item->id])}}')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="hapusData('<?= $item->id?>', '{{route('admin.dosen.delete', ['id' => $item->id])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

@include('dosen.form')
@include('dosen.import')
<script>
    const formUrlCreate = "{{route('admin.dosen.store')}}"
    const formUrlUpdate = "{{route('admin.dosen.update')}}"
    const formUrlImport = "{{route('admin.dosen.import')}}"
</script>
@endsection
