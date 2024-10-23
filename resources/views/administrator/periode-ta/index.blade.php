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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <th>Nama</th>
                                <th>Pendaftaran</th>
                                <th>Seminar Proposal</th>
                                <th>Sidang Akhir</th>
                                <th>Pemberkasan</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periode as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>
                                    {{ $item->mulai_daftar ? \Carbon\Carbon::parse($item->mulai_daftar)->format('d/m/Y') : '-' }}
                                    -
                                    {{ $item->akhir_daftar ? \Carbon\Carbon::parse($item->akhir_daftar)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $item->mulai_seminar ? \Carbon\Carbon::parse($item->mulai_seminar)->format('d/m/Y') : '-' }}
                                    -
                                    {{ $item->akhir_seminar ? \Carbon\Carbon::parse($item->akhir_seminar)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $item->mulai_sidang ? \Carbon\Carbon::parse($item->mulai_sidang)->format('d/m/Y') : '-' }}
                                    -
                                    {{ $item->akhir_sidang ? \Carbon\Carbon::parse($item->akhir_sidang)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    {{ $item->akhir_pemberkasan ? \Carbon\Carbon::parse($item->akhir_pemberkasan)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="isActivePeriode" onchange="changeIsActive('{{route('apps.periode.change', $item->id)}}', '{{$item->is_active}}')" @if ($item->is_active == 1) checked @endif >
                                    </div>
                                </td>
                                <td>
                                    <button onclick="editData('{{ $item->id }}', '{{route('apps.periode.show', $item->id)}}')" class="btn btn-outline-primary btn-sm mx-1 my-1" title="Edit"><i class="bx bx-edit-alt"></i></button>
                                    <button class="btn btn-outline-dark btn-sm mx-1 my-1" onclick="editData('{{ $item->id }}', '{{route('apps.periode.delete', $item->id)}}')" title="Hapus"><i class="bx bx-trash"></i></button>
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

@include('administrator.periode-ta.partials.modal')

@endsection
