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
                            <form action="{{route('dosen.jadwal-uji')}}" method="get">
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
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Mahasiswa</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                        <th>Dosen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $dateHariIni = date('Y-m-d');
                                    @endphp
                                    @foreach ($dataUji as $item)
                                    @php
                                        $seminar = \App\Models\JadwalSeminar::where('tugas_akhir_id', $item->tugas_akhir->id);
                                        if(isset($tgl)){
                                            $seminar = $seminar->where('tanggal', $tgl);
                                        }
                                        $seminar = $seminar->first();
                                        if ($seminar) {
                                            $waktu_sekarang = date('H:i:s');
                                            $tgl_sekarang = date('Y-m-d');
                                            if ($waktu_sekarang >= $seminar->jam_mulai && $waktu_sekarang < $seminar->jam_selesai && $tgl_sekarang == $seminar->tanggal) {

                                                $waktu = 'berlangsung';

                                            } else if(($waktu_sekarang > $seminar->jam_selesai && $tgl_sekarang == $seminar->tanggal) || $tgl_sekarang > $seminar->tanggal) {

                                                $waktu = 'selesai';

                                            } else {
                                                $waktu = 'tidak berlangsung';
                                            }
                                        } else {
                                            $waktu = 'seminar tidak ditemukan';
                                        }
                                    @endphp
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
                                    @if (isset($tgl) AND $waktu != 'seminar tidak ditemukan')  
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->mahasiswa->nama_mhs}}</td>
                                        <td>
                                            @if (isset($seminar->tanggal))
                                                {{$seminar->tanggal}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($seminar->jam_mulai))
                                                {{$seminar->jam_mulai}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($seminar->jam_selesai))
                                                {{$seminar->jam_selesai}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->tugas_akhir->status_seminar))
                                                <span class="badge bg-primary">{{$item->tugas_akhir->status_seminar}}</span>
                                            @else
                                                <span class="badge bg-secondary">Belum diseminarkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            @if ($waktu == 'berlangsung' && $item->jenis == 'pembimbing' && $item->urut == 1)
                                            <a href="javascript:void(0);" data-status='{{$item->tugas_akhir->status_seminar}}' data-id="{{$item->tugas_akhir->id}}" class="btn btn-sm btn-primary mb-3 update-status-seminar"><i class="fas fa-edit"></i></a>
                                            @endif
                                            <a href="{{route('dosen.jadwal-uji.show', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @if (!isset($tgl))  
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->tugas_akhir->judul}}</td>
                                        <td>{{$item->tugas_akhir->mahasiswa->nama_mhs}}</td>
                                        <td>
                                            @if (isset($seminar->tanggal))
                                                {{$seminar->tanggal}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($seminar->jam_mulai))
                                                {{$seminar->jam_mulai}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($seminar->jam_selesai))
                                                {{$seminar->jam_selesai}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->tugas_akhir->status_seminar))
                                                <span class="badge bg-primary">{{$item->tugas_akhir->status_seminar}}</span>
                                            @else
                                                <span class="badge bg-secondary">Belum diseminarkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                            Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                            Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                            Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                        </td>
                                        <td>
                                            @if ($waktu == 'berlangsung' && $item->jenis == 'pembimbing' && $item->urut == 1)
                                            <a href="javascript:void(0);" data-status='{{$item->tugas_akhir->status_seminar}}' data-id="{{$item->tugas_akhir->id}}" class="btn btn-sm btn-primary mb-3 update-status-seminar"><i class="fas fa-edit"></i></a>
                                            @endif
                                            <a href="{{route('dosen.jadwal-uji.show', ['id' => $item->tugas_akhir->id])}}" class="btn btn-sm btn-primary mb-3"><i class="fas fa-search"></i></a>
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
@include('dosen-menu.jadwal-uji.form-status')
@endsection
