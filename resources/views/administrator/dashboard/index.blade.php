@extends('administrator.layout.main')
@section('content')

@if(getInfoLogin()->hasRole('Mahasiswa'))

    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card text-center border-{{ 
                isset($dataMahasiswa['tugasAkhir']) ? 
                ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'accept' : 
                ($dataMahasiswa['tugasAkhir']->status == 'draft' ? 'draft' : 'reject')) 
                : 'draft' 
            }}">
                <div class="card-body">
                    <p class="mb-2 fs-5">Pengajuan Tugas Akhir</p>
                    <i class="bx bx-{{ 
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'check-circle' : 
                        ($dataMahasiswa['tugasAkhir']->status == 'draft' ? 'timer' : 'x-circle')) 
                        : 'timer' 
                    }} text-{{ 
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'success' : 
                        ($dataMahasiswa['tugasAkhir']->status == 'draft' ? 'dark' : 'danger')) 
                        : 'dark' 
                    }}" style="font-size: 50px"></i>
                    <h5 class="mb-0 text-{{
                        isset($dataMahasiswa['tugasAkhir']) ? 
                        ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'success' : 
                        ($dataMahasiswa['tugasAkhir']->status == 'draft' ? 'dark' : 
                        ($dataMahasiswa['tugasAkhir']->status == 'reject' ? 'danger' : 'danger'))) 
                        : 'dark' 
                    }}">
                        {{
                            isset($dataMahasiswa['tugasAkhir']) ? 
                            ($dataMahasiswa['tugasAkhir']->status == 'acc' ? 'Disetujui' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'draft' ? 'Menunggu' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'reject' ? 'Ditolak' : 
                            ($dataMahasiswa['tugasAkhir']->status == 'cancel' ? 'Tidak Dilanjutkan' : 'Menunggu')))) 
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
                    <div class="text-center">
                        {{-- <p class="mb-2">Seminar Proposal</p>
                        <p class="m-0"><strong>Rabu, 31 Januari 2025</strong></p>
                        <p><strong>10.00 - 12.00</strong></p>
                        <p class="mt-2 mb-0">
                            Ruangan : Lab Basis Data
                        </p> --}}
                        <h5>Segera Hadir...</h5>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card" style="border-radius: 15px">
                <div class="card-body">
                    <h4 class="card-title">Tawaran Topik</h4>
                    <hr>
                    <ul class="inbox-wid list-unstyled">
                        @foreach ($dataMahasiswa['topik'] as $item)
                        <li class="inbox-list-item">
                            <a>
                                <div class="d-flex align-items-start">
                                    <div class="flex-1 overflow-hidden">
                                        <h6 class="m-0"><b>{{ $item->judul }}</b></h4>
                                        <p class="m-0" style="font-size: 14px">{{ Str::limit($item->deskripsi, 150) }}</p>
                                        <p class="text-muted small m-0"><span class="me-2"><i class="bx bx-user me-1"></i> {{ $item->dosen->name }}</span> <i class="bx bx-group me-1"></i>{{ $item->ambilTawaran()->count() }}/{{ $item->kuota }} Kuota</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @if($dataMahasiswa['topik']->count() !== 0)
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
    <div class="col-lg-3">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Tawaran Topik Yang Belum Divalidasi</p>
                <h4 class="mb-0">{{ $kaprodi['belumAcc']->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Tawaran Topik Yang Sudah Divalidasi</p>
                <h4 class="mb-0">{{ $kaprodi['sudahAcc']->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Pengajuan TA Yang Belum Divalidasi</p>
                <h4 class="mb-0">{{ $kaprodi['taDraft']->count() }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Pengajuan TA Yang Sudah Divalidasi</p>
                <h4 class="mb-0">{{ $kaprodi['taAcc']->count() }}</h4>
            </div>
        </div>
    </div>
</div>
@endif



@if(getInfoLogin()->hasRole('Admin'))
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card text-center" style="border-radius: 15px">
            <div class="card-body">
                <p class="mb-2 fs-5">Total Dosen</p>
                <h4 class="mb-0">{{ $admin['dosen']->count() }} </h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
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
                <h4 class="mb-0">50</h4>
            </div>
        </div>
    </div>
</div>
@endif

@endsection