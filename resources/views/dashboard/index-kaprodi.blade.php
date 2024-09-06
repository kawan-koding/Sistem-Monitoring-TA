@extends('layout.admin-main')
@section('content')

<div class="row">

    <div class="col-xl-4">
        <a href="{{route('kaprodi.daftar-ta')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Total Pengajuan Judul</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalPengajuan}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="{{route('kaprodi.pembagian-dosen')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Total Disetujui</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalACC}}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4">
        <a href="{{route('kaprodi.pembagian-dosen')}}" class="text-dark">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="avatar-sm font-size-20 me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <div class="font-size-16 mt-2">Total Di Tolak</div>
    
                        </div>
                    </div>
                    <h4 class="mt-4">{{$totalReject}}</h4>
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
