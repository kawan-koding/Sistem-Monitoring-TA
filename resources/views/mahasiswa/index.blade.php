@extends('layout.admin-main')
@section('content')


<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                <a href="javascript:void(0);" onclick="importData()" class="btn btn-success"><i class="fa fa-file-excel"></i> Import</a>
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
                                <th>Kelas</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Telp.</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataMhs as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->kelas}}</td>
                                <td>{{$item->nim}}</td>
                                <td>{{$item->nama_mhs}}</td>
                                <td>{{$item->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'}}</td>
                                <td>{{$item->telp}}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="editData('<?= $item?>', '{{route('admin.mahasiswa.show', $item)}}')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="hapusData('<?= $item?>', '{{route('admin.mahasiswa.delete', ['id' => $item->id])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

@include('mahasiswa.form')
@include('mahasiswa.import')
<script>
    const formUrlCreate = "{{route('admin.mahasiswa.store')}}"
    const formUrlUpdate = "{{route('admin.mahasiswa.update')}}"
    const formUrlImport = "{{route('admin.mahasiswa.import')}}"
</script>
@endsection
