@extends('layout.admin-main')
@section('content')

<div class="row">

    <div class="col-xl-3">
        <a href="{{route('admin.dosen')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Dosen</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalDosen}}</h4>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3">
        <a href="{{route('admin.mahasiswa')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Mahasiswa</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalMahasiswa}}</h4>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3">
        <a href="{{route('admin.jadwal-seminar')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Seminar Proposal Hari ini</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalJadwal}}</h4>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3">
        <a href="{{route('admin.daftarta')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Pengajuan Judul</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalPengajuan}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('admin.daftarta')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Judul Telah Disetujui Koordinator TA</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalACC}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('admin.daftarta')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Disetujui Dosen Pembimbing dan Penguji</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalDapatDospem}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('admin.jadwal-seminar')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Jadwal Seminar Proposal Terbit</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalJadwalSem}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a href="{{route('admin.jadwal-seminar')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Selesai Seminar Proposal</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalTelahSem}}</h4>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div style="width: 100%;">
                    <canvas id="myPolarAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $dtk = json_encode($dataChart);
@endphp
<script>
    var dataForChart = {!! $dtk !!}
</script>
@endsection
