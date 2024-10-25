@extends('administrator.layout.main')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-g-12">
            <div class="card">
                <div class="card-body">
                    @can('create-jurusan')
                    <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                    <hr>
                    @endcan
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
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    @if(session('switchRoles') !== 'Kajur')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programStudi as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->kode}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{$item->nama}}</strong>
                                                <p class="m-0 p-0 text-muted small">Jurusan {{ $item->jurusan->nama}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    @if(session('switchRoles') !== 'Kajur')
                                    <td>
                                        @can('update-program-studi')
                                        <button onclick="editData('{{ $item->id }}', '{{route('apps.program-studi.show', $item->id)}}')" class="btn btn-outline-primary btn-sm mx-1 my-1" title="Edit"><i class="bx bx-edit-alt"></i></button>
                                        @endcan
                                        @can('delete-program-studi')
                                        <button class="btn btn-outline-dark btn-sm mx-1 my-1" onclick="hapusProdi('{{ $item->id }}', '{{ route('apps.program-studi.delete', $item->id) }}')" title="Hapus"><i class="bx bx-trash"></i></button>                                        
                                        @endcan
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

@include('administrator.program-studi.partials.modal')
@endsection
