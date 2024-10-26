@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
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
                                <th>Nama</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRumpunIlmu as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="edit('<?= $item->id?>', '{{route('dosen.rumpun-ilmu.show', ['id' => $item->id])}}')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="hapus('<?= $item->id?>', '{{route('dosen.rumpun-ilmu.delete', ['id' => $item->id])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

@include('rumpunilmu.form')
<script>
    const formUrlCreate = "{{route('dosen.rumpun-ilmu.store')}}"
    const formUrlUpdate = "{{route('dosen.rumpun-ilmu.update')}}"
</script>
@endsection
