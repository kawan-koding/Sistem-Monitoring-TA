@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @can('read-daftar-bimbingan')
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.daftar-bimbingan')) active @endif"
                            href="{{ route('apps.daftar-bimbingan') }}">
                            <span class="d-block d-sm-none"><i class="bx bx-timer"></i></span>
                            <span class="d-none d-sm-block">Mahasiswa Bimbing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.daftar-bimbingan', ['status' => 'mahasiswa_uji'])) active @endif"
                            href="{{ route('apps.daftar-bimbingan', ['status' => 'mahasiswa_uji']) }}">
                            <span class="d-block d-sm-none"><i class="bx bx-list-check"></i></span>
                            <span class="d-none d-sm-block">Mahasiswa Uji</span>
                        </a>
                    </li>
                </ul>
            @endcan
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th >Judul</th>
                                <th>Mahasiswa</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="m-0"><strong>{{ $item->tugas_akhir->judul }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} - {{ $item->tugas_akhir->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>
                                        <p class="m-0"><strong>{{ $item->tugas_akhir->mahasiswa->nama_mhs }}/{{ $item->tugas_akhir->mahasiswa->kelas }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->tugas_akhir->mahasiswa->programStudi->nama }}</p>
                                    </td>
                                    <td>
                                        {{ $item->tugas_akhir->periode_ta->nama }}
                                    </td>
                                    <td>
                                        <span class="badge {{
                                            isset($item->tugas_akhir->status_sidang) ?
                                                ($item->tugas_akhir->status_sidang == 'acc' ? 'badge-soft-success' : 
                                                ($item->tugas_akhir->status_sidang == 'revisi' ? 'badge-soft-warning' : 
                                                ($item->tugas_akhir->status_sidang == 'reject' ? 'badge-soft-danger' : 
                                                ($item->tugas_akhir->status_sidang == 'filing' ? 'badge-soft-info' : 'badge-soft-secondary'))))
                                            :
                                            (isset($item->tugas_akhir->status_seminar) ? 
                                                ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : 
                                                ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-warning' : 
                                                ($item->tugas_akhir->status_seminar == 'reject' ? 'badge-soft-danger' : 
                                                ($item->tugas_akhir->status_seminar == 'filing' ? 'badge-soft-info' : 'badge-soft-secondary'))))
                                            : 
                                            (isset($item->tugas_akhir->status) ? 
                                                ($item->tugas_akhir->status == 'acc' ? 'badge-soft-info' : 
                                                ($item->tugas_akhir->status == 'draft' ? 'badge-soft-dark' : 
                                                ($item->tugas_akhir->status == 'reject' ? 'badge-soft-danger' : 
                                                ($item->tugas_akhir->status == 'cancel' ? 'badge-soft-danger' : 'badge-soft-secondary'))))
                                                : 'badge-soft-secondary'
                                            ))
                                        }} small mb-1">
                                            {{
                                                isset($item->tugas_akhir->status_sidang) ? 
                                                    ($item->tugas_akhir->status_sidang == 'acc' ? 'Proses pemberkasan' : 
                                                    ($item->tugas_akhir->status_sidang == 'revisi' ? 'Proses revisi laporan' : 
                                                    ($item->tugas_akhir->status_sidang == 'reject' ? 'Sidang ditolak' : 
                                                    ($item->tugas_akhir->status_sidang == 'filing' ? 'Selesai' : '-'))))
                                                :
                                                (isset($item->tugas_akhir->status_seminar) ? 
                                                    ($item->tugas_akhir->status_seminar == 'acc' ? 'Proses pemberkasan' : 
                                                    ($item->tugas_akhir->status_seminar == 'revisi' ? 'Proses revisi proposal' : 
                                                    ($item->tugas_akhir->status_seminar == 'reject' ? 'Seminar ditolak' : 
                                                    ($item->tugas_akhir->status_seminar == 'filing' ? 'Proses penyusunan laporan' : '-'))))
                                                :
                                                (isset($item->tugas_akhir->status) ? 
                                                    ($item->tugas_akhir->status == 'acc' ? 'Proses penyusunan proposal' : 
                                                    ($item->tugas_akhir->status == 'draft' ? 'Proses pengajuan' : 
                                                    ($item->tugas_akhir->status == 'reject' ? 'Topik ditolak' : 
                                                    ($item->tugas_akhir->status == 'cancel' ? 'Tidak dilanjutkan' : '-'))))
                                                    : '-'
                                                ))
                                            }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('apps.daftar-bimbingan.show', $item->id)}}" class="btn btn-sm btn-outline-warning mb-3" title="Detail"><i class="bx bx-show"></i></a>
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

@endsection
