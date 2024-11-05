@extends('administrator.layout.main')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
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
                                <th>Kode</th>
                                <th>Nama Ruangan</th>
                                <th>Lokasi</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRuangan as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama_ruangan}}</td>
                                <td>{{$item->lokasi}}</td>
                                <td>
                                    <button onclick="editData('{{ $item->id }}', '{{route('apps.ruangan.show', $item->id)}}')" title="Edit" class="btn btn-outline-primary btn-sm mx-1 my-1"><i class="bx bx-edit-alt"></i></button>
                                    <button onclick="hapusRuangan('{{ $item->id }}', '{{route('apps.ruangan.delete', $item->id)}}')" title="Hapus" class="btn btn-outline-dark btn-sm mx-1 my-1"><i class="bx bx-trash"></i></button>
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
@include('administrator.ruangan.partials.modal')
@endsection