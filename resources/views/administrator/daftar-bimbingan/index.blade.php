@extends('administrator.layout.main')
@section('content')

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-24 me-3" style="height: 3.5rem; width: 3.5rem">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <i class="mdi mdi-account-multiple"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-1 fw-bold">Total Kuota Pembimbing 1</div>
                        <p class="font-size-14 mt-1 text-muted m-0">
                            @foreach ($kuota as $item)
                                {{ $item->programStudi->display ?? '-' }} : <span class="text-primary">{{ $item->pembimbing_1 ?? 0}}</span> @if(!$loop->last) | @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-24 me-3" style="height: 3.5rem; width: 3.5rem">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <i class="mdi mdi-account-outline"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-1 fw-bold">Sisa Kuota Pembimbing 1</div>
                        <p class="font-size-14 mt-1 text-muted m-0">
                            @foreach ($sisaKuota as $item)
                                {{ $item['prodi'] ?? '-' }} : <span class="text-primary">{{ $item['sisa_kuota_pemb_1'] ?? 0}}</span> @if(!$loop->last) | @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-24 me-3" style="height: 3.5rem; width: 3.5rem">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <i class="mdi mdi-account-outline"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-1 fw-bold">Sisa Kuota Pembimbing 2</div>
                        <p class="font-size-14 mt-1 text-muted m-0">
                            @foreach ($sisaKuota as $item)
                                {{ $item['prodi'] ?? '-' }} : <span class="text-primary">{{ $item['sisa_kuota_pemb_2'] ?? 0}}</span> @if(!$loop->last) | @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12 col-sm-12 col-g-12">
        <div class="card">
            @can('read-daftar-bimbingan')
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-1" role="tablist">
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

                <div class="d-flex flex-column flex-md-row  justify-content-end align-items-md-center gap-2">
                    <form action="" method="GET">
                        <input type="hidden" name="status" value="{{ request('status', 'mahasiswa_bimbing') }}">
                        <div class="d-flex gap-2 flex-column flex-md-row">
                            <select name="program_studi" id="program_studi" class="form-control" style="min-width: 300px; width: 100%" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Program Studi</option>
                                <option value="semua" {{ request('program_studi') == 'semua' ? 'selected' : '' }}>Semua Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" {{ request('program_studi') == $p->id ? 'selected' : '' }}>{{ $p->display }}</option>
                                @endforeach
                            </select>
                            @if (request('status') == 'mahasiswa_uji')
                                <select name="penguji" id="penguji" class="form-control" style="min-width: 300px; width: 100%" onchange="this.form.submit()">
                                    <option selected disabled hidden>Filter Penguji</option>
                                    <option value="semua" {{ request('penguji') == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="1" {{ request('penguji') == '1' ? 'selected' : '' }}>Penguji 1</option>
                                    <option value="2" {{ request('penguji') == '2' ? 'selected' : '' }}>Penguji 2</option>
                                </select>
                            @else
                                <select name="pembimbing" id="pembimbing" class="form-control" style="min-width: 300px; width: 100%" onchange="this.form.submit()">
                                    <option selected disabled hidden>Filter Pembimbing</option>
                                    <option value="semua" {{ request('pembimbing') == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="1" {{ request('pembimbing') == '1' ? 'selected' : '' }}>Pembimbing 1</option>
                                    <option value="2" {{ request('pembimbing') == '2' ? 'selected' : '' }}>Pembimbing 2</option>
                                </select>
                            @endif
                        </div>
                    </form>

                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Mahasiswa</th>
                                <th>Judul</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small mb-1">{{ $item->tugas_akhir->mahasiswa->programStudi->display }}</span></p>
                                        <a href="#" class="m-0" data-bs-toggle="modal" data-bs-target="#mahasiswaModal{{ $key }}">
                                            <strong>{{ $item->tugas_akhir->mahasiswa->nama_mhs }} - {{ $item->tugas_akhir->mahasiswa->kelas }}</strong>
                                        </a>
                                        <div class="modal fade" id="mahasiswaModal{{ $key }}" tabindex="-1" aria-labelledby="mahasiswaModalLabel{{ $key }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mahasiswaModalLabel{{ $key }}">Biodata Mahasiswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                <img src="{{ $item->tugas_akhir->mahasiswa->user->image == null ? 'https://ui-avatars.com/api/?background=random&name='. $item->tugas_akhir->mahasiswa->name : asset('storage/images/users/'. $item->tugas_akhir->mahasiswa->user->image) }}" alt="Foto Mahasiswa" class="img-fluid rounded">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <table class="table table-sm table-borderless">
                                                                    <tr>
                                                                        <th>Nama</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->nama_mhs ?? '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>NIM</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->nim ?? '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Kelas</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->kelas ?? '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Prodi</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->programStudi->display ?? '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Telepon</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->telp ?? '-' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        <td>{{ $item->tugas_akhir->mahasiswa->email ?? '-' }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="m-0 p-0 text-muted small">NIM : {{$item->tugas_akhir->mahasiswa->nim}}</p>
                                    </td>
                                    <td>
                                        <p class="m-0"><span class="badge rounded-pill bg-primary-subtle text-primary small mb-1">{{ strtoupper($item->jenis) ?? '-'}} {{ $item->urut ?? '-'  }}</span></p>
                                        <p class="m-0"><strong>{{ $item->tugas_akhir->judul }}</strong></p>
                                        <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} - {{ $item->tugas_akhir->jenis_ta->nama_jenis}}</p>
                                    </td>
                                    <td>
                                        {{ $item->tugas_akhir->periode_ta->nama }}
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'badge-soft-secondary';
                                            if (isset($item->tugas_akhir)) {
                                                $ta = $item->tugas_akhir;
                                                if (isset($ta->status_sidang)) {
                                                    if (($ta->status_sidang == 'acc' || $ta->status_sidang == 'revisi') && $ta->sudah_pemberkasan == 'sudah_lengkap' && isset($ta->sidang) && $ta->sidang->status == 'sudah_sidang') {
                                                        $badgeClass = 'badge-soft-success';
                                                    } elseif (($ta->status_sidang == 'acc' || $ta->status_sidang == 'revisi') && $ta->sudah_pemberkasan == 'belum_lengkap' && isset($ta->sidang) && $ta->sidang->status == 'sudah_sidang') {
                                                        $badgeClass = 'badge-soft-warning';
                                                    } elseif ($ta->status_sidang == 'retrail') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } else {
                                                        $badgeClass = 'badge-soft-secondary';
                                                    }
                                                } elseif (isset($ta->status_seminar)) {
                                                    if (($ta->status_seminar == 'acc' || $ta->status_seminar == 'revisi') && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar' && $ta->status_pemberkasan == 'sudah_lengkap' && is_null($ta->status_sidang)) {
                                                        $badgeClass = 'badge-soft-success';
                                                    } elseif (($ta->status_seminar == 'acc' || $ta->status_seminar == 'revisi') && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar' && $ta->status_pemberkasan == 'belum_lengkap' && is_null($ta->status_sidang)) {
                                                        $badgeClass = 'badge-soft-warning';
                                                    } elseif ($ta->status_seminar == 'retrail' && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } elseif ($ta->status_seminar == 'reject') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } else {
                                                        $badgeClass = 'badge-soft-secondary';
                                                    }
                                                } elseif (isset($ta->status)) {
                                                    if ($ta->status == 'acc') {
                                                        $badgeClass = 'badge-soft-info';
                                                    } elseif ($ta->status == 'reject') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } elseif ($ta->status == 'draft') {
                                                        $badgeClass = 'badge-soft-dark';
                                                    } elseif ($ta->status == 'revisi') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } elseif ($ta->status == 'cancel') {
                                                        $badgeClass = 'badge-soft-danger';
                                                    } else {
                                                        $badgeClass = 'badge-soft-secondary';
                                                    }
                                                }
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} small mb-1">
                                            @php
                                            $statusText = '-';

                                            if (isset($item->tugas_akhir)) {
                                                $ta = $item->tugas_akhir;
                                                if (isset($ta->status_sidang)) {
                                                    if (($ta->status_sidang == 'acc' || $ta->status_sidang == 'revisi') && $ta->sudah_pemberkasan == 'sudah_lengkap' && isset($ta->sidang) && $ta->sidang->status == 'sudah_sidang') {
                                                        $statusText = 'Sudah Pemberkasan Sidang';
                                                    } elseif (($ta->status_sidang == 'acc' || $ta->status_sidang == 'revisi') && $ta->sudah_pemberkasan == 'belum_lengkap' && isset($ta->sidang) && $ta->sidang->status == 'sudah_sidang') {
                                                        $statusText = 'Proses Revisi Laporan';
                                                    } elseif (is_null($ta->status_sidang) && isset($ta->sidang) && $ta->sidang->status == 'sudah_terjadwal') {
                                                        $statusText = 'Sudah Terjadwal Sidang';
                                                    } elseif (isset($ta->sidang) && $ta->sidang->status == 'sudah_daftar') {
                                                        $statusText = 'Sudah Daftar Sidang';
                                                    } elseif ($ta->status_sidang == 'retrail') {
                                                        $statusText = 'Sidang Ulang';
                                                    }
                                                } elseif (isset($ta->status_seminar)) {
                                                    if (($ta->status_seminar == 'acc' || $ta->status_seminar == 'revisi') && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar' && $ta->status_pemberkasan == 'sudah_lengkap' && is_null($ta->status_sidang)) {
                                                        $statusText = 'Sudah Pemberkasan Sempro';
                                                    } elseif (($ta->status_seminar == 'acc' || $ta->status_seminar == 'revisi') && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar' && $ta->status_pemberkasan == 'belum_lengkap' && is_null($ta->status_sidang)) {
                                                        $statusText = 'Proses Revisi Proposal';
                                                    } elseif (is_null($ta->status_seminar) && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_terjadwal') {
                                                        $statusText = 'Sudah Terjadwal Sempro';
                                                    } elseif ($ta->status_seminar == 'retrail' && isset($ta->jadwal_seminar) && $ta->jadwal_seminar->status == 'telah_seminar') {
                                                        $statusText = 'Sempro Ulang';
                                                    } elseif ($ta->status_seminar == 'reject') {
                                                        $statusText = 'Sempro Ditolak';
                                                    }
                                                } elseif (isset($ta->status)) {
                                                    if ($ta->status == 'acc') {
                                                        $statusText = 'Proses Penyusunan Proposal';
                                                    } elseif ($ta->status == 'draft') {
                                                        $statusText = 'Proses Pengajuan';
                                                    } elseif ($ta->status == 'pengajuan ulang') {
                                                        $statusText = 'Pengajuan Ulang';
                                                    } elseif ($ta->status == 'revisi') {
                                                        $statusText = 'Revisi';
                                                    } elseif ($ta->status == 'reject') {
                                                        $statusText = 'Topik Ditolak';
                                                    } elseif ($ta->status == 'cancel') {
                                                        $statusText = 'Tidak Dilanjutkan';
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $statusText }}
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
