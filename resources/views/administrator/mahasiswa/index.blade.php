@extends('administrator.layout.main')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-g-12">
            <div class="card">
                <div class="card-body">
                    @can('create-mahasiswa')
                    <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                    @endcan
                    @can('import-mahasiswa')
                    <button onclick="importData()" class="btn btn-success"><i class="fa fa-file-excel"></i> Import</button>
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
                                    <th>Kelas</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Program Studi</th>
                                    @if(session('switchRoles') !== 'Kajur')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mhs as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->kelas}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ucfirst($item->nama_mhs)}}</strong>
                                                <p class="m-0 p-0 text-muted small">NIM : {{$item->nim}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{$item->email}}</strong>
                                                <p class="m-0 p-0 text-muted small">{{$item->telp ?? '-'}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$item->jenis_kelamin == 'Laki-laki' ? 'Laki-Laki' : ($item->jenis_kelamin == 'Perempuan' ? 'Perempuan' : 'Lainnya')}}</td>
                                    <td>{{ $item->programStudi->nama ?? '' }}</td>
                                    @if(session('switchRoles') !== 'Kajur')
                                    <td>
                                        @can('update-mahasiswa')
                                        <button title="Edit" onclick="editData('{{ $item->id }}', '{{route('apps.mahasiswa.show', $item->id)}}')" class="btn btn-outline-primary btn-sm mx-1 my-1"><i class="bx bx-edit-alt"></i></button>
                                        @endcan
                                        @can('delete-mahasiswa')
                                        <button onclick="hapusMahasiswa('{{ $item->id }}', '{{ route('apps.mahasiswa.delete', $item->id) }}')" title="Hapus" class="btn btn-outline-dark btn-sm mx-1 my-1"><i class="bx bx-trash"></i></button>
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

@include('administrator.mahasiswa.partials.modal')
@endsection
