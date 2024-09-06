@extends('layout.admin-main')
@section('content')


<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link {{isset($jenis_) ? '' : 'active'}}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Daftar Mahasiswa Bimbingan</button>
              <button class="nav-link {{isset($jenis_) ? 'active' : ''}}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Daftar Uji</button>
            </div>
        </nav>
        <div class="card">
            <div class="card-body">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade {{isset($jenis_) ? '' : 'show active'}}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Topik</th>
                                        <th>Status</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataBimbingan as $item)
                                        @foreach ($item->tugas_akhir->bimbing_uji as $bimuj)
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
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->tugas_akhir->topik->nama_topik}}</td>
                                        <td>
                                            @if ($item->tugas_akhir->status == 'draft')
                                                <span class="badge bg-primary">Draft</span>
                                            @elseif($item->tugas_akhir->status == 'acc')
                                                <span class="badge bg-success">Acc</span>
                                            @else
                                                <span class="badge bg-danger">Reject</span>
                                            @endif
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('dosen.daftar_bimbingan.show_bimbingan', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade {{isset($jenis_) ? 'active show' : ''}}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Topik</th>
                                        <th>Status</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataUji as $item)
                                        @php
                                            $item_pemb_1 = null;
                                            $item_peng_1 = null;
                                            $item_pemb_2 = null;
                                            $item_peng_2 = null;
                                        @endphp
                                        @foreach ($item->tugas_akhir->bimbing_uji as $bimuj)
                                            @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 1)
                                                @php
                                                    $item__pemb_1 = $bimuj->dosen->name;
                                                @endphp
                                            @endif
                                            @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 2)
                                                @php
                                                    $item__pemb_2 = $bimuj->dosen->name;
                                                @endphp
                                            @endif
                                            @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 1)
                                                @php
                                                    $item__peng_1 = $bimuj->dosen->name;
                                                @endphp
                                            @endif
                                            @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 2)
                                                @php
                                                    $item__peng_2 = $bimuj->dosen->name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->tugas_akhir->topik->nama_topik}}</td>
                                        <td>
                                            @if ($item->tugas_akhir->status == 'draft')
                                                <span class="badge bg-primary">Draft</span>
                                            @elseif($item->tugas_akhir->status == 'acc')
                                                <span class="badge bg-success">Acc</span>
                                            @else
                                                <span class="badge bg-danger">Reject</span>
                                            @endif
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item__pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item__pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item__peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item__peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('dosen.daftar_bimbingan.show_uji', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-search"></i></a>
                                            <a href="{{route('dosen.daftar_bimbingan.show_revisi', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-warning mb-3"><i class="fas fa-book-reader"></i></a>
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
    </div>
</div>

@endsection
