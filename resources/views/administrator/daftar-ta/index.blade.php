@extends('administrator.layout.main')
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
                                <th width="40%">Judul</th>
                                <th>Mahasiswa</th>
                                <th>Dosen</th>
                                <th>Periode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge {{ isset($item->status) ? ($item->status == 'acc' ? 'badge-soft-success' : ($item->status == 'draft' ? 'bg-dark-subtle text-body' : 'badge-soft-danger')) : '-'}} small mb-1"> {{ ucfirst($item->status ?? '-')}} </span>
                                        <p class="m-0"><strong>{{ $item->judul }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->topik->nama_topik }} - {{ $item->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>{{ $item->mahasiswa->nama_mhs }}</td>
                                    <td>
                                        <strong>Pembimbing</strong>
                                        <ol>
                                            @foreach ($item->bimbing_uji->where('jenis', 'pembimbing')->sortBy('urut') as $pembimbing)
                                                <li>{{ $pembimbing->dosen->name }}</li>
                                            @endforeach
                                        </ol>
                                        <strong>Penguji</strong>
                                        <ol>
                                          @foreach ($item->bimbing_uji->where('jenis', 'penguji')->sortBy('urut') as $penguji)
                                            <li>{{ $penguji->dosen->name }}</li>
                                        @endforeach
                                        </ol>
                                    </td>
                                    <td>{{ $item->periode_ta->nama }}</td>
                                    <td>
                                        @can('update-daftar-ta')
                                        <a href="{{ route('apps.daftar-ta.edit', $item)}}" class="btn btn-sm btn-outline-primary mb-3" title="Edit"><i class="bx bx-edit-alt"></i></a>
                                        @endcan
                                        @can('read-daftar-ta')
                                        <a href="{{ route('apps.daftar-ta.show', $item)}}" class="btn btn-sm btn-outline-warning mb-3" title="Detail"><i class="bx bx-show"></i></a>
                                        @endcan
                                        @can('delete-daftar-ta')
                                        <button type="button" data-url="{{ route('apps.daftar-ta.delete', $item)}}" class="btn btn-sm btn-outline-dark mb-3" data-toggle="delete" title="Hapus"><i class="bx bx-trash"></i></button>
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

@endsection
