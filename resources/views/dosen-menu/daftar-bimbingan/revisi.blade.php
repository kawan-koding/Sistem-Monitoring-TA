@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
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

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th>Uraian Revisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->uraian}}</td>
                                        <td>{{$item->status == 1 ? '"Valid"' : "Belum Valid"}}</td>
                                        <td>
                                            <a href="{{route('dosen.daftar_bimbingan.status_revisi', ['id' => $item->id])}}?status_revisi=1" class="btn btn-sm btn-primary mb-3"><i class="fas fa-check-square"></i></a>
                                            <a href="{{route('dosen.daftar_bimbingan.status_revisi', ['id' => $item->id])}}?status_revisi=0" class="btn btn-sm btn-danger mb-3"><i class="fas fa-times"></i></a>
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
@include('dosen-menu.daftar-bimbingan.form-status')
@endsection
