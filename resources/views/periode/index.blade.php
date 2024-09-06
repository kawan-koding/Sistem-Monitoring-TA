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
                                <th>Mulai Daftar</th>
                                <th>Akhir Daftar</th>
                                <th>Mulai Seminar</th>
                                <th>Akhir Seminar</th>
                                <th>Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPeriod as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->mulai_daftar}}</td>
                                <td>{{$item->akhir_daftar}}</td>
                                <td>{{$item->mulai_seminar}}</td>
                                <td>{{$item->akhir_seminar}}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isActivePeriode" onchange="changeIsActive('{{route('admin.periode.change', ['id' => $item->id])}}', '{{$item->is_active}}')" @if ($item->is_active == 1) checked @endif >
                                    </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" onclick="editData('<?= $item->id?>', '{{route('admin.periode.show', ['id' => $item->id])}}')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="hapusData('<?= $item->id?>', '{{route('admin.periode.delete', ['id' => $item->id])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

@include('periode.form')
<script>
    const formUrlCreate = "{{route('admin.periode.store')}}"
    const formUrlUpdate = "{{route('admin.periode.update')}}"
</script>
@endsection
