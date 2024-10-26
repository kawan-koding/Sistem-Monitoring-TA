@extends('layout.admin-main')
@section('content')



<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            <div class="card-body">
                @if (!isset($dataTA[0]['id']))
                <a href="{{route('mahasiswa.pengajuan-ta.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                <hr>
                @endif
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
                <a href="https://drive.google.com/file/d/1ldapUYIdj04TKkkUG4hRfzaa4oSxJ05r/view?usp=sharing" target="_blank" class="btn btn-primary"><i class="far fa-file-alt"></i> Template Persetujuan Pemb 1</a>
                <a href="https://drive.google.com/file/d/1CF7BnMwtpPVVmo3fkdBsJztGabu_I3FE/view?usp=sharing" target="_blank" class="btn btn-secondary"><i class="far fa-file-alt"></i> Template Ringkasan</a>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="2%">No</th>
                                <th min-width="150px">Judul</th>
                                <th>Jenis</th>
                                <th>Topik</th>
                                <th>Status</th>
                                <th min-width="300px">Dosen</th>
                                <th min-width="200px">Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataTA as $item)
                                @foreach ($item->bimbing_uji as $bimuj)
                                    @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 1)
                                        @php
                                            $item_pemb_1 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 2)
                                        @php
                                            $item_pemb_2 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 1)
                                        @php
                                            $item_peng_1 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                    @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 2)
                                        @php
                                            $item_peng_2 = $bimuj->dosen->name;
                                        @endphp
                                    @endif
                                @endforeach
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->judul}}</td>
                                <td>{{$item->jenis_ta->nama_jenis}}</td>
                                <td>{{$item->topik->nama_topik}}</td>
                                <td>
                                    @if ($item->status == 'acc')
                                    <span class='badge rounded-pill badge-soft-primary font-size-11'>{{ucfirst($item->status)}}</span>
                                    @else
                                    <span class='badge rounded-pill badge-soft-secondary font-size-11'>{{ucfirst($item->status)}}</span>
                                    @endif
                                </td>
                                <td>
                                    Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                    Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                    Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                    Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                </td>
                                <td>{{$item->catatan}}</td>
                                <td>
                                    <a href="{{route('mahasiswa.pengajuan-ta.edit', ['id' => $item->id])}}" class="btn btn-sm btn-primary mb-3" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="{{route('mahasiswa.pengajuan-ta.show', ['id' => $item->id])}}" class="btn btn-sm btn-primary mb-3" title="Detail"><i class="fas fa-search"></i></a>
                                    <a href="javascript:void(0);" data-url="{{route('mahasiswa.pengajuan-ta.unggah-berkas', ['id' => $item->id])}}" class="btn btn-sm btn-secondary unggah-berkas mb-3" title="Unggah Berkas"><i class="far fa-file-alt"></i></a>

                                    @if ($timer == 'selesai')

                                    <a href="{{route('mahasiswa.pengajuan-ta.print_nilai', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Nilai"><i class="fas fa-file-alt"></i></a>
                                    <a href="{{route('mahasiswa.pengajuan-ta.print_rekap', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Rekapitulasi"><i class="far fa-file-alt"></i></a>
                                    <a href="{{route('mahasiswa.pengajuan-ta.print_revisi', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Revisi"><i class="fas fa-file-invoice"></i></a>
                                    @endif
                                    @if (isset($item_pemb_1))
                                    <a href="{{route('mahasiswa.pengajuan-ta.print_pemb1', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Print Persetujuan Dosen"><i class="fas fa-file-invoice"></i></a>
                                    @endif
                                    @if (isset($item_pemb_2))
                                    <a href="{{route('mahasiswa.pengajuan-ta.print_pemb2', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Print Persetujuan Dosen"><i class="fas fa-file-invoice"></i></a>
                                    @endif
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


@include('mahasiswa-menu.pengajuan.modal-unggah')
@endsection
