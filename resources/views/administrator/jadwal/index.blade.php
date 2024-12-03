@extends('administrator.layout.main')

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-g-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                        <li class="nav-item">
                            <a href="{{ route('apps.jadwal') }}"
                                class="nav-link @if (url()->full() == route('apps.jadwal')) active @endif">
                                <span class="d-block d-sm-none small">Mahasiswa Bimbing</span>
                                <span class="d-none d-sm-block fw-bold">Mahasiswa Bimbing</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('apps.jadwal', ['jenis' => 'penguji']) }}"
                                class="nav-link @if (url()->full() == route('apps.jadwal', ['jenis' => 'penguji'])) active @endif">
                                <span class="d-block d-sm-none small">Mahasiswa Uji</span>
                                <span class="d-none d-sm-block fw-bold">Mahasiswa Uji</span>
                            </a>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th>Judul</th>
                                    <th>Ruangan</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (!is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) && $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->status == 'belum_terjadwal')
                                                <span class="badge rounded-pill badge-soft-primary">Belum Terjadwal</span>
                                            @else
                                                @if (!is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) && $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->status == 'sudah_terjadwal')
                                                    <span class="badge rounded-pill badge-soft-primary">Sudah Terjadwal</span>
                                                @else
                                                    <span class="badge rounded-pill badge-soft-primary">Telah Seminar</span>
                                                @endif
                                            @endif
                                            <h5 class="font-size-14 mb-0">
                                                {{ $item->tugas_akhir->judul }}
                                            </h5>
                                            <p class="mt-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} -
                                                {{ $item->tugas_akhir->jenis_ta->nama_jenis }}</p>
                                            <p>{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p>
                                        </td>
                                        <td>
                                            <strong>{{ is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) || is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->ruangan) ? '-' : $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->ruangan->nama_ruangan }}</strong>
                                            <p class="mb-0 small">Tanggal:
                                                {{ is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) || is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->tanggal)? '-': \Carbon\Carbon::createFromFormat('Y-m-d', $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->tanggal)->locale('id')->translatedFormat('l, d M Y') }}
                                            </p>
                                            <p class="mb-0 small">Waktu:
                                                {{ !is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) ? $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->jam_mulai : '' }}
                                                -
                                                {{ !is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) ? $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->jam_selesai : ''}}
                                            </p>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : 'badge-soft-secondary' }}">{{!is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Disetujui dengan revisi' : 'Ditolak')) : '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if (!is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) && $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->status != 'belum_terjadwal')
                                                <a href="{{ route('apps.jadwal.penilaian', $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->id) }}"
                                                    class="btn btn-outline-primary btn-sm mb-1">
                                                    <i class="bx bx-clipboard"></i>
                                                </a>
                                            @endif
                                            @if ($item->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->where('jenis', 'pembimbing')->where('urut', 1)->count() > 0 && $item->tugas_akhir->status_seminar != 'acc' && (!is_null($item->tugas_akhir->jadwal_seminar) && $item->tugas_akhir->jadwal_seminar->status == 'telah_seminar'))
                                                <button class="btn btn-outline-warning btn-sm mb-1" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Setujui?</button>
                                                @include('administrator.jadwal.partials.modal')
                                            @endif
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
