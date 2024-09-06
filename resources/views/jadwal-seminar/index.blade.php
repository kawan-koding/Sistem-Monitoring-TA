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
                    <form action="{{route('admin.jadwal-seminar')}}" method="get">
                        <div class="row">
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <label for="">Filter Tanggal</label>
                                <div data-repeater-item="" class="inner mb-3 row">
                                    <div class="col-md-10 col-8">
                                        <input type="date" name="tanggal" class="inner form-control" placeholder="">
                                    </div>
                                    <div class="col-md-2 col-4">
                                        <button type="submit" class="btn btn-primary w-100 inner">Filter</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Belum Terjadwal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Sudah Terjadwal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Telah Diseminarkan</span>
                        </a>
                    </li>
                </ul>
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
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataMyTa as $item)
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
                                    @php
                                        $jadwal_sem = \App\Models\JadwalSeminar::where('tugas_akhir_id', $item->id)->first();
                                    @endphp
                                    @if (!isset($jadwal_sem))
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->judul}}</td>
                                        <td>{{$item->mahasiswa->nama_mhs}}</td>
                                        <td>{{$item->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->topik->nama_topik}}</td>
                                        <td>
                                            @if (isset($jadwal_sem))
                                                <span class="badge bg-primary">Sudah Terjadwal</span>
                                            @else
                                                <span class="badge bg-secondary">Belum Terjadwal</span>
                                            @endif
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.jadwal-seminar.tambahkan-jadwal', ['id' => $item->id])}}" class="btn btn-sm btn-primary acc_ta mb-3"><i class="fas fa-calendar-day"></i></a>
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
                                    @if (now()->format('Y-m-d') < $item->tanggal || (now()->format('Y-m-d') == $item->tanggal && now()->format('H:i:s') < $item->jam_selesai))
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->mahasiswa->nama_mhs}}</td>
                                        <td>{{$item->tugas_akhir->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->tugas_akhir->topik->nama_topik}}</td>
                                        <td>

                                                <span class="badge bg-primary">Sudah Terjadwal</span>

                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.jadwal-seminar.tambahkan-jadwal', ['id' => $item->tugas_akhir_id])}}" class="btn btn-sm btn-primary acc_ta mb-3"><i class="fas fa-calendar-day"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile2" role="tabpanel">
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
                                        <th>Dosen</th>
                                        {{-- <th>Aksi</th> --}}
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
                                    @if (now()->format('Y-m-d') > $item->tanggal || (now()->format('Y-m-d') == $item->tanggal && now()->format('H:i:s') > $item->jam_selesai))
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->mahasiswa->nama_mhs}}</td>
                                        <td>{{$item->tugas_akhir->jenis_ta->nama_jenis}}</td>
                                        <td>{{$item->tugas_akhir->topik->nama_topik}}</td>
                                        <td>

                                                <span class="badge bg-primary">Sudah Diseminarkan</span>

                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        {{-- <td>
                                            <a href="{{route('admin.jadwal-seminar.tambahkan-jadwal', ['id' => $item->tugas_akhir_id])}}" class="btn btn-sm btn-primary acc_ta mb-3"><i class="fas fa-calendar-day"></i></a>
                                        </td> --}}
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
