@extends('administrator.layout.main')
@section('content')

<style>
    .card {
        position: relative;
        overflow: hidden;
    }

    .card-icon {
        position: absolute;
        top: 0;
        right: -2%;
        transform: translateY(-50%);
        font-size: 5rem;
        opacity: 0.3;
        transform: rotate(25deg);
    }
</style>

@if(getInfoLogin()->hasRole('Mahasiswa'))
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card text-center border-{{ 
                isset($dataMahasiswa['tugasAkhir']) ? 
                ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'accept' : 
                (in_array($dataMahasiswa['tugasAkhir']->status, ['draft', 'pengajuan ulang']) ? 'draft' : 'reject')) 
                : 'draft' 
            }}">
                <div class="card-body">
                    <p class="mb-2 fs-5">Pengajuan Tugas Akhir</p>
                    <i class="bx bx-{{ 
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'check-circle' : 
                        (in_array($dataMahasiswa['tugasAkhir']->status, ['draft', 'pengajuan ulang']) ? 'timer' : 'x-circle')) 
                        : 'timer' 
                    }} text-{{ 
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'success' : 
                        (in_array($dataMahasiswa['tugasAkhir']->status, ['draft', 'pengajuan ulang']) ? 'dark' : 'danger')) 
                        : 'dark' 
                    }}" style="font-size: 50px"></i>
                    <h5 class="mb-0 text-{{
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'success' : 
                        (in_array($dataMahasiswa['tugasAkhir']->status, ['draft', 'pengajuan ulang']) ? 'dark' : 
                        ($dataMahasiswa['tugasAkhir']->status == 'reject' ? 'danger' : 'danger'))) 
                        : 'dark' 
                    }}">
                        {{
                            isset($dataMahasiswa['tugasAkhir']) ? 
                            ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'Disetujui' : 
                            (in_array($dataMahasiswa['tugasAkhir']->status, ['draft', 'pengajuan ulang']) ? 'Menunggu' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'reject' ? 'Ditolak' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'revisi' ? 'Revisi' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'cancel' ? 'Tidak Dilanjutkan' : 'Menunggu'))))) 
                            : 'Belum Diajukan' 
                        }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-center border-draft">
                <div class="card-body">
                    <p class="mb-2 fs-5">Seminar Proposal</p>
                    <i class="bx bx-code" style=" font-size: 50px"></i>
                    <h5 class="mb-0">Segera Hadir...</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-center border-draft">
                <div class="card-body">
                    <p class="mb-2 fs-5">Sidang Akhir</p>
                    <i class="bx bx-code" style="font-size: 50px"></i>
                    <h5 class="mb-0">Segera Hadir...</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card " style="border-radius: 15px"> 
                <div class="card-body"> 
                    <h5 class="card-title">Jadwal</h5>
                    <hr>
                    <h5 class="text-center">Segera Hadir...</h5>
                </div> 
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card" style="border-radius: 15px">
                <div class="card-body">
                    <h4 class="card-title">Tawaran Topik</h4>
                    <hr>
                    <ul class="inbox-wid list-unstyled">
                        @forelse ($dataMahasiswa['topik'] as $item)
                        <li class="inbox-list-item">
                            <a>
                                <div class="d-flex align-items-start">
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="m-0"><b>{{ $item->judul }}</b></h4>
                                        <p class="m-0" style="font-size: 14px">{{ Str::limit($item->deskripsi, 150) }}</p>
                                        <p class="text-muted small m-0"><span class="me-2"><i class="bx bx-user me-1"></i> {{ $item->dosen->name }}</span> <i class="bx bx-group me-1"></i>{{ $item->ambilTawaran()->where('status','Disetujui')->count() }}/{{ $item->kuota }} Kuota | Jumlah Pengambil : {{$item->ambilTawaran()->where('status', '!=', 'Ditolak')->count()}}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>
                            <h5 class="text-center">Belum ada tawaran topik</h5>
                        </li>
                        @endforelse
                    </ul>
                    @if($dataMahasiswa['topik']->count() > 2)
                    <div class="text-center">
                        <a href="{{ route('apps.rekomendasi-topik')}}" class="btn btn-primary btn-sm">Lihat Selengkapnya...</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

{{-- <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Mahasiswa Bimbingan</p>
                <h4 class="mb-0">50</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Mahasiswa Uji</p>
                <h4 class="mb-0">50</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Telah Seminar Proposal</p>
                <h4 class="mb-0">50</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Telah Sidang Akhir</p>
                <h4 class="mb-0">50</h4>
            </div>
        </div>
    </div> --}}
{{-- </div> --}}

@if(getInfoLogin()->hasRole('Kaprodi') && session('switchRoles') == 'Kaprodi')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="mdi mdi-alert-decagram"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $kaprodi['belumAcc']->count() }} </h3>
                <p class="mb-0">Tawaran Topik Yang Belum Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="mdi mdi-file-check"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $kaprodi['sudahAcc']->count() }} </h3>
                <p class="mb-0">Tawaran Topik Yang Sudah Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-clock"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $kaprodi['taDraft']->count() }} </h3>
                <p class="mb-0">Pengajuan TA Yang Belum Divalidasi</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $kaprodi['taAcc']->count() }} </h3>
                <p class="mb-0">Pengajuan TA Yang Sudah Divalidasi</p>
            </div>
        </div>
    </div>
</div>
@endif

@if(getInfoLogin()->hasRole('Admin'))
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-user"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $admin['dosen']->count() }} </h3>
                <p class="mb-0">Total Dosen</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $admin['mhs']->count() }} </h3>
                <p class="mb-0">Total Mahasiswa</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-book-open"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $admin['ta']->count() }} </h3>
                <p class="mb-0">Total Tugas Akhir</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-clock"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $admin['topik']->count() }} </h3>
                <p class="mb-0">Total Topik Belum Disetujui</p>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-3 col-md-6">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Mahasiswa</p>
                <h4 class="mb-0">{{ $admin['mhs']->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Tugas Akhir</p>
                <h4 class="mb-0">{{ $admin['ta']->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Topik Belum Disetujui</p>
                <h4 class="mb-0">{{ $admin['topik']->count() }}</h4>
            </div>
        </div>
    </div> --}}
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card" style="height: 100%; min-height: 400px;">
            <div class="card-body">
                <h4 class="card-title mb-1">Chart</h4>
                <div id="column_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card" style="height: 100%; min-height: 400px;">
            <div class="card-body">
                <h4 class="card-title mb-1">Chart</h4>
                <div id="donut_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

@endif

@if(getInfoLogin()->hasRole('Dosen') && session('switchRoles') == 'Dosen')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $dosen['bimbing']->count() }} </h3>
                <p class="mb-0">Total Mahasiswa Bimbingan</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $dosen['uji']->count() }} </h3>
                <p class="mb-0">Total Mahasiswa Uji</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-pencil-alt"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">{{ $dosen['kuota']->sum('pembimbing_1')  ?? 0}} </h3>
                <p class="mb-0">Jumlah Kuota Pembimbing 1</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card shadow-sm border-primary" style="border-width: 0px 0px 0px 3px;">
            <div class="card-icon">
                <i class="fa fa-edit"></i>
            </div>
            <div class="card-body">
                <h3 class="mb-2">
                    {{ $dosen['sisaKuota'] ?? 0}}
                </h3>
                <p class="mb-0">Sisa Kuota Pembimbing 1</p>
            </div>
        </div>
    </div>
</div>
@endif

@endsection