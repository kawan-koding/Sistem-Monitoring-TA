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
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Ruangan</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataUji as $item)
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
                                        <td>{{$item->ruangan->nama_ruangan}}</td>
                                        <td>{{$item->tanggal}}</td>
                                        <td>
                                            Mulai : {{$item->jam_mulai}}
                                            <br>
                                            Selesai : {{$item->jam_selesai}}
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('mahasiswa.jadwal-seminar.show', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-search"></i></a>
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
@include('dosen-menu.jadwal-uji.form-status')
@endsection
