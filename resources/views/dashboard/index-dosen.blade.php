@extends('layout.admin-main')
@section('content')

<div class="row">
    <div class="col-xl-4">
        <a href="{{route('dosen.daftar_bimbingan')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Mahasiswa Bimbingan</div>
                        </div>
                    </div>
                    <h4 class="mt-4">{{$mahasiswa}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="{{route('dosen.daftar_bimbingan')}}?jenis=uji" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Mahasiswa Uji</div>
                        </div>
                    </div>
                    <h4 class="mt-4">{{$mahasiswaUji}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="{{route('dosen.jadwal-uji')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Telah Seminar Proposal</div>
                        </div>
                    </div>
                    <h4 class="mt-4">{{$telahSidang}}</h4>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
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
