@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Revisi</button>
              <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Nilai</button>
              <button class="nav-link" id="nav-rekap-tab" data-bs-toggle="tab" data-bs-target="#nav-rekap" type="button" role="tab" aria-controls="nav-rekap" aria-selected="false">Rekap</button>
            </div>
        </nav>
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

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="3">Revisi Penguji 1 ( {{$penguji1->dosen->name}} )</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Uraian</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revisi_penguji_1 as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->uraian}}</td>
                                            <td>{{$item->status == 0 ? 'Belum valid' : 'Valid'}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="3">Revisi Penguji 2 ( {{$penguji2->dosen->name}} )</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Uraian</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revisi_penguji_2 as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->uraian}}</td>
                                            <td>{{$item->status == 0 ? 'Belum valid' : 'Valid'}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

                        <div class="table-responsive">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Nilai Pembimbing 1</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Aspek</th>
                                        <th>Angka</th>
                                        <th>Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlah_pemb_1 = 0;
                                        $total_pemb_1 = 0;
                                    @endphp
                                    @foreach ($nilai_pemb_1 as $item)
                                    @php
                                        $jumlah_pemb_1 += 1;
                                        $total_pemb_1 += $item->angka;
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->aspek}}</td>
                                        <td>{{$item->angka}}</td>
                                        <td>{{$item->huruf}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Nilai Pembimbing 2</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Aspek</th>
                                        <th>Angka</th>
                                        <th>Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlah_pemb_2 = 0;
                                        $total_pemb_2 = 0;
                                    @endphp
                                    @foreach ($nilai_pemb_2 as $item)
                                    @php
                                        $jumlah_pemb_2 += 1;
                                        $total_pemb_2 += $item->angka;
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->aspek}}</td>
                                        <td>{{$item->angka}}</td>
                                        <td>{{$item->huruf}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Nilai Penguji 1</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Aspek</th>
                                        <th>Angka</th>
                                        <th>Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlah_peng_1 = 0;
                                        $total_peng_1 = 0;
                                    @endphp
                                    @foreach ($nilai_peng_1 as $item)
                                    @php
                                        $jumlah_peng_1 += 1;
                                        $total_peng_1 += $item->angka;
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->aspek}}</td>
                                        <td>{{$item->angka}}</td>
                                        <td>{{$item->huruf}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table-striped table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Nilai Penguji 2</th>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Aspek</th>
                                        <th>Angka</th>
                                        <th>Huruf</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlah_peng_2 = 0;
                                        $total_peng_2 = 0;
                                    @endphp
                                    @foreach ($nilai_peng_2 as $item)
                                    @php
                                        $jumlah_peng_2 += 1;
                                        $total_peng_2 += $item->angka;
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->aspek}}</td>
                                        <td>{{$item->angka}}</td>
                                        <td>{{$item->huruf}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="tab-pane fade show" id="nav-rekap" role="tabpanel" aria-labelledby="nav-rekap-tab" tabindex="0">

                        @php
                            $rekap_pemb_1 = $total_pemb_1 == 0 ? 0 : ($total_pemb_1/$jumlah_pemb_1);
                            $tertimbang_pemb_1 = $total_pemb_1 == 0 ? 0 : ( 20/100 * $rekap_pemb_1);
                            $rekap_pemb_2 = $total_pemb_2 == 0 ? 0 :($total_pemb_2/$jumlah_pemb_2);
                            $tertimbang_pemb_2 = $total_pemb_2 == 0 ? 0 : ( 20/100 * $rekap_pemb_2);
                            $rekap_peng_1 = $total_peng_1 == 0 ? 0 : ($total_peng_1/$jumlah_peng_1);
                            $tertimbang_peng_1 = $total_peng_1 == 0 ? 0 : ( 20/100 * $rekap_peng_1);
                            $rekap_peng_2 = $total_peng_2 == 0 ? 0 : ($total_peng_2/$jumlah_peng_2);
                            $tertimbang_peng_2 = $total_peng_2 == 0 ? 0 : ( 20/100 * $rekap_peng_2);

                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Penilai</th>
                                    <th>Nilai</th>
                                    <th>Nilai Tertimbang</th>
                                </tr>
                                <tr>
                                    <td>Pembimbing 1</td>
                                    <td>{{$rekap_pemb_1}}</td>
                                    <td>{{$tertimbang_pemb_1}}</td>
                                </tr>
                                <tr>
                                    <td>Pembimbing 2</td>
                                    <td>{{$rekap_pemb_2}}</td>
                                    <td>{{$tertimbang_pemb_2}}</td>
                                </tr>
                                <tr>
                                    <td>Penguji 1</td>
                                    <td>{{$rekap_peng_1}}</td>
                                    <td>{{$tertimbang_peng_1}}</td>
                                </tr>
                                <tr>
                                    <td>Penguji 2</td>
                                    <td>{{$rekap_peng_2}}</td>
                                    <td>{{$tertimbang_peng_2}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jumlah</td>
                                    <td>{{($tertimbang_pemb_1+$tertimbang_pemb_2+$tertimbang_peng_1+$tertimbang_peng_2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Nilai Angka</td>
                                    <td>{{($tertimbang_pemb_1+$tertimbang_pemb_2+$tertimbang_peng_1+$tertimbang_peng_2)}}</td>
                                </tr>
                                @php
                                    $totalRek = ($tertimbang_pemb_1+$tertimbang_pemb_2+$tertimbang_peng_1+$tertimbang_peng_2);
                                    if($totalRek >= 80){
                                        $nHuruf = 'A';
                                    }else if($totalRek >= 75){
                                        $nHuruf = 'AB';
                                    }else if($totalRek >= 65){
                                        $nHuruf = 'B';
                                    }else if($totalRek >= 60){
                                        $nHuruf = 'BC';
                                    }else if($totalRek >= 55){
                                        $nHuruf = 'C';
                                    }else if($totalRek >= 40){
                                        $nHuruf = 'D';
                                    }else if($totalRek < 40){
                                        $nHuruf = 'E';
                                    }
                                @endphp
                                <tr>
                                    <td colspan="2">Nilai Huruf</td>
                                    <td>{{($nHuruf)}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
@include('dosen-menu.jadwal-uji.form-status')
@endsection
