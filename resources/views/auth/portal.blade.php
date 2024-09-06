@extends('layout.auth-main')
@section('content')

<div class="home-btn d-none d-sm-block">
    <a href="{{route('login')}}" class="text-reset"><i class="fas fa-home h2"></i></a>
</div>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <center><h4 style="color: white;">Jadwal Seminar</h4></center>
            </div>
            <div class="card-body">
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped"  id="datatable">
                        <thead>
                            <tr class="bg-primary">
                                <th style="color: white;">No</th>
                                <th style="color: white;">NIM</th>
                                <th style="color: white;">Nama</th>
                                <th style="color: white;">Judul</th>
                                <th style="color: white;">Status</th>
                                <th style="color: white;">Dosen</th>
                                <th style="color: white;">Tanggal</th>
                                <th style="color: white;">Jam Mulai</th>
                                <th style="color: white;">Jam Selesai</th>
                                <th style="color: white;">Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;

                                // Set locale ke Bahasa Indonesia
                                Carbon::setLocale('id');

                                // Format tanggal dengan Carbon
                                
                            @endphp
                            @foreach ($jadwal as $i)
                            @if (date('Y-m-d') < $i->tanggal || (date('Y-m-d') == $i->tanggal && date('H:i:s') < $i->jam_selesai)) 
                            @php
                                        $item_pemb_1 = null;
                                        $item_peng_1 = null;
                                        $item_pemb_2 = null;
                                        $item_peng_2 = null;
                                    @endphp
                                    @foreach ($i->tugas_akhir->bimbing_uji as $bimuj)
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
                                <td>{{$i->tugas_akhir->mahasiswa->nim}}</td>
                                <td>{{$i->tugas_akhir->mahasiswa->nama_mhs}}</td>
                                <td>{{$i->tugas_akhir->judul}}</td>
                                <td>{{$i->tugas_akhir->tipe == 'K' ? 'Kelompok' : 'Individu'}}</td>
                                <td>
                                    Pembimbing 1 : {{$item_pemb_1 ?? '-'}}<br>
                                    Pembimbing 2 : {{$item_pemb_2 ?? '-'}}<br>
                                    Penguji 1 : {{$item_peng_1 ?? '-'}}<br>
                                    Penguji 2 : {{$item_peng_2 ?? '-'}}<br>
                                </td>
                                @php
                                    $tanggal_data = Carbon::parse($i->tanggal)->translatedFormat('l, d F Y');
                                @endphp
                                <td>{{$tanggal_data}}</td>
                                <td>{{$i->jam_mulai}}</td>
                                <td>{{$i->jam_selesai}}</td>
                                <td>{{$i->ruangan->nama_ruangan}}</td>
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

@endsection
