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

                <div>
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Sudah Terbagi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Belum Terbagi</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="home1" role="tabpanel">

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Mahasiswa</th>
                                        <th>Jenis</th>
                                        <th>Topik</th>
                                        <th>Status</th>
                                        <th>Periode</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTA as $item)
                                        @php
                                            $item_pemb_1 = null;
                                            $item_peng_1 = null;
                                            $item_pemb_2 = null;
                                            $item_peng_2 = null;
                                        @endphp
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
                                    @if (isset($item_peng_1))
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->judul}}</td>
                                        <td>{{$item->mahasiswa->nama_mhs}}</td>
                                        <td>{{$item->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->topik->nama_topik}}</td>
                                        <td>
                                            @if ($item->status == 'draft')
                                                <span class="badge bg-primary">Draft</span>
                                            @elseif($item->status == 'acc')
                                                <span class="badge bg-success">Acc</span>
                                            @else
                                                <span class="badge bg-danger">Reject</span>
                                            @endif
                                        </td>
                                        <td>
                                            Awal : {{$item->periode_mulai}} <br>
                                            Akhir : {{$item->periode_akhir}}
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('kaprodi.pembagian-dosen.edit', ['id' => $item->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>

                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane" id="profile1" role="tabpanel">

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Mahasiswa</th>
                                        <th>Jenis</th>
                                        <th>Topik</th>
                                        <th>Status</th>
                                        <th>Periode</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTA as $item)
                                        @php
                                            $item_pemb_1 = null;
                                            $item_peng_1 = null;
                                            $item_pemb_2 = null;
                                            $item_peng_2 = null;
                                        @endphp
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
                                    @if (!isset($item_peng_1))

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->judul}}</td>
                                        <td>{{$item->mahasiswa->nama_mhs}}</td>
                                        <td>{{$item->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->topik->nama_topik}}</td>
                                        <td>
                                            @if ($item->status == 'draft')
                                                <span class="badge bg-primary">Draft</span>
                                            @elseif($item->status == 'acc')
                                                <span class="badge bg-success">Acc</span>
                                            @else
                                                <span class="badge bg-danger">Reject</span>
                                            @endif
                                        </td>
                                        <td>
                                            Awal : {{$item->periode_mulai}} <br>
                                            Akhir : {{$item->periode_akhir}}
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('kaprodi.pembagian-dosen.edit', ['id' => $item->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>

                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
