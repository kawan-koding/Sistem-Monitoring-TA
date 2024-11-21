@extends('administrator.layout.main')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-g-12">
            <div class="card">
                <div class="card-body">
                    @can('create-jenis-dokumen')
                        <button onclick="tambahData()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                        <hr>
                    @endcan
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
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
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Maks. Ukuran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p>
                                            <span class="badge bg-primary">
                                                {{ 
                                                    $item->jenis === 'pra_seminar' ? 'Pra Seminar' : 
                                                    ($item->jenis === 'seminar' ? 'Seminar' : 
                                                    ($item->jenis === 'pra_sidang' ? 'Pra Sidang' : 
                                                    ($item->jenis === 'sidang' ? 'Sidang' :
                                                    ($item->jenis === 'pendaftaran' ? 'Pendaftaran' : '-' )))) 
                                                }}
                                            </span> <br>
                                            {{ $item->nama }}
                                        </p>
                                    </td>                                    
                                    <td>{{ strtoupper($item->tipe_dokumen) }}</td>
                                    <td>{{ $item->max_ukuran }} KB</td>
                                    <td>
                                        @can('update-jenis-dokumen')
                                            <button onclick="editData('{{ $item->id }}', '{{ route('apps.jenis-dokumen.show', $item->id) }}')" class="btn btn-outline-primary btn-sm mx-1 my-1"><i class="bx bx-edit-alt"></i></button>
                                        @endcan
                                        @can('delete-jenis-dokumen')
                                            <button onclick="hapusJenisDokumen('{{ $item->id }}', '{{ route('apps.jenis-dokumen.delete', $item->id) }}')" class="btn btn-outline-dark btn-sm mx-1 my-1" title="Hapus"><i class="bx bx-trash"></i></button>
                                        @endcan
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

    @include('administrator.jenis-dokumen.partials.modal')
@endsection
