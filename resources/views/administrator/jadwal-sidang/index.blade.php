@extends('administrator.layout.main')

@section('content')
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ getSetting('app_sidang_registration_template') }}" target="_blank"
                    class="btn btn-success mb-2"><i class="far fa-file-alt"></i> Template Pendaftaran Sidang</a>
                <a href="{{ getSetting('app_sidang_filing_template') }}" target="_blank" class="btn btn-secondary mb-2"><i
                        class="far fa-file-alt"></i> Template Pemberkasan Sidang</a>
                @if (session('switchRoles') == 'Admin')
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle mb-2"
                            style="max-width: 150px;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file-excel me-2"></i> Export <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'belum_daftar']) }}">Belum Daftar
                                Sidang</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'sudah_daftar']) }}">Sudah Daftar
                                Sidang</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'sudah_terjadwal_sidang']) }}">Sudah
                                Terjadwal Sidang</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'sudah_sidang']) }}">Telah Sidang</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'sudah_pemberkasan_sidang']) }}">Sudah
                                Pemberkasan Sidang</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-sidang.export', ['data' => 'sk_sidang']) }}">SK Sidang</a>
                        </div>
                    </div>
                @endif
            </div>
            <hr>
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

            @if (getInfoLogin()->hasRole('Dosen'))
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                    <li class="nav-item">
                        <a href="{{ route('apps.jadwal-sidang') }}"
                            class="nav-link @if (url()->full() == route('apps.jadwal-sidang')) active @endif">
                            <span class="d-block d-sm-none small">Mahasiswa Bimbing</span>
                            <span class="d-none d-sm-block fw-bold">Mahasiswa Bimbing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('apps.jadwal-sidang', ['jenis' => 'penguji']) }}"
                            class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['jenis' => 'penguji'])) active @endif">
                            <span class="d-block d-sm-none small">Mahasiswa Uji</span>
                            <span class="d-none d-sm-block fw-bold">Mahasiswa Uji</span>
                        </a>
                    </li>
                </ul>
            @endif

            @if (getInfoLogin()->hasRole('Admin'))
                <form action="">
                    @if (!is_null($status))
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    @if (!is_null($status_pemberkasan_sidang))
                        <input type="hidden" name="status_pemberkasan_sidang" value="{{ $status_pemberkasan_sidang }}">
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="">Filter Tanggal</label>
                            <div class="inner mb-3 row">
                                <div class="col-md-8 col-sm-6">
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="date" name="tanggal" class="inner form-control"
                                                placeholder="cari berdasarkan tanggal">
                                            <div class="input-group-prepend">
                                                <button type="submit"
                                                    class="btn btn-primary input-group-text inner">Filter</button>
                                                <a href="{{ route('apps.jadwal-sidang') }}"
                                                    class="btn btn-secondary input-group-text inner">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Filter berdasarkan Prodi / Periode / Penyelesaian</label>
                            <div class="row">
                                <div class="col-4">
                                    <select name="filter1" class="form-control" onchange="this.form.submit()">
                                        <option value="semua" {{ $filter1 == 'semua' ? 'selected' : '' }}>Semua Program
                                            Studi</option>
                                        @foreach ($programStudies as $item)
                                            <option
                                                value="{{ $item->id }}"{{ $filter1 == $item->id ? 'selected' : '' }}>
                                                {{ $item->display }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="filter2" class="form-control" onchange="this.form.submit()">
                                        <option value="semua" {{ $filter2 == 'semua' ? 'selected' : '' }}>Semua Periode
                                        </option>
                                        @foreach ($periodes as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($filter2) && $filter2 == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }} - {{ 'Prodi' . ' ' . $item->programStudi->display }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="type" class="form-control" onchange="this.form.submit()">
                                        <option value="semua" {{ $type == 'semua' ? 'selected' : '' }}>Semua</option>
                                        <option value="I" {{ $type == 'I' ? 'selected' : '' }}>Individu</option>
                                        <option value="K" {{ $type == 'K' ? 'selected' : '' }}>Kelompok</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @can('read-daftar-sidang')
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang') ||
                                    (\Request::is('apps/jadwal-sidang') && \Request::has('tanggal') && !\Request::has('status'))) active @endif"
                                href="{{ route('apps.jadwal-sidang') }}">
                                <span class="d-block d-sm-none"><i class="bx bx-timer"></i></span>
                                <span class="d-none d-sm-block">Belum Daftar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang',['status' => 'sudah_daftar']) ||
                                    (\Request::is('apps/jadwal-sidang') && \Request::has('tanggal') && !\Request::has('status') == 'sudah_daftar')) ) active @endif"
                                href="{{ route('apps.jadwal-sidang',['status' => 'sudah_daftar']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-timer"></i></span>
                                <span class="d-none d-sm-block">Belum Terjadwal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status' => 'sudah_terjadwal']) ||
                                    (\Request::is('apps/jadwal-sidang') && \Request::has('status') && \Request::get('status') == 'sudah_terjadwal')) ) active @endif"
                                href="{{ route('apps.jadwal-sidang', ['status' => 'sudah_terjadwal']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-list-check"></i></span>
                                <span class="d-none d-sm-block">Sudah Terjadwal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status' => 'sudah_sidang']) ||
                                    (\Request::is('apps/jadwal-sidang') && \Request::has('status') && \Request::get('status') == 'sudah_sidang')) active @endif"
                                href="{{ route('apps.jadwal-sidang', ['status' => 'sudah_sidang']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-check-circle"></i></span>
                                <span class="d-none d-sm-block">Telah Sidang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status_pemberkasan_sidang' => 'sudah_lengkap']) ||
                                    (\Request::is('apps/jadwal-sidang') &&
                                        \Request::has('status_pemberkasan_sidang') &&
                                        \Request::get('status_pemberkasan_sidang') == 'sudah_lengkap')) active @endif"
                                href="{{ route('apps.jadwal-sidang', ['status_pemberkasan_sidang' => 'sudah_lengkap']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-check-circle"></i></span>
                                <span class="d-none d-sm-block">Sudah Pemberkasan</span>
                            </a>
                        </li>
                    </ul>
                @endcan
            @endif

            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            @if (getInfoLogin()->hasRole('Admin') || getInfoLogin()->hasRole('Dosen'))
                                <th>Mahasiswa</th>
                            @endif
                            <th width="40%">Judul</th>
                            @if (getInfoLogin()->hasRole('Admin') || getInfoLogin()->hasRole('Mahasiswa'))
                                <th width="20%">Dosen</th>
                            @endif
                            <th>Ruangan</th>
                            @if (getInfoLogin()->hasRole('Admin') || getInfoLogin()->hasRole('Dosen'))
                                <th>Status</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($data as $key => $item)
                            {{-- @dd($item->jenis == 'penguji' && $item->dosen_id == getInfoLogin()->userable->id && $item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', $item->urut)->count() > 0) --}}
                            @if (
                                !(
                                    $item->jenis == 'penguji' &&
                                    $item->dosen_id == getInfoLogin()->userable->id &&
                                    $item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', $item->urut)->count() > 0
                                ) || $item->jenis != 'penguji')
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    @if (getInfoLogin()->hasRole('Admin'))
                                        <td width="15%">
                                            @if (getInfoLogin()->hasRole('Admin'))
                                                <span
                                                    class="badge badge-soft-primary">{{ !is_null($item->tugas_akhir->mahasiswa->programStudi) ? $item->tugas_akhir->mahasiswa->programStudi->display : '' }}</span>
                                                <a href="#" class="m-0" data-bs-toggle="modal"
                                                    data-bs-target="#mahasiswaModal{{ $key }}">
                                                    <p class="fw-bold m-0">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}
                                                    </p>
                                                </a>
                                                <div class="modal fade" id="mahasiswaModal{{ $key }}"
                                                    tabindex="-1"
                                                    aria-labelledby="mahasiswaModalLabel{{ $key }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="mahasiswaModalLabel{{ $key }}">Biodata
                                                                    Mahasiswa</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-4 text-center">
                                                                        <img src="{{ $item->tugas_akhir->mahasiswa->user->image == null ? 'https://ui-avatars.com/api/?background=random&name=' . $item->tugas_akhir->mahasiswa->name : asset('storage/images/users/' . $item->tugas_akhir->mahasiswa->user->image) }}"
                                                                            alt="Foto Mahasiswa"
                                                                            class="img-fluid rounded">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <table class="table table-sm table-borderless">
                                                                            <tr>
                                                                                <th>Nama</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->nama_mhs ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>NIM</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->nim ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Kelas</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->kelas ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Prodi</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->programStudi->display ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Telepon</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->telp ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Email</th>
                                                                                <td>{{ $item->tugas_akhir->mahasiswa->email ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <p class="small m-0">{{ $item->tugas_akhir->mahasiswa->nim }}</p>
                                        </td>
                                    @elseif(getInfoLogin()->hasRole('Dosen'))
                                        <td>
                                            <span
                                                class="badge badge-soft-primary">{{ !is_null($item->tugas_akhir->mahasiswa->programStudi) ? $item->tugas_akhir->mahasiswa->programStudi->display : '' }}</span>
                                            <p class="fw-bold m-0">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p>
                                            <p class="small m-0">{{ $item->tugas_akhir->mahasiswa->nim }}</p>
                                        </td>
                                    @endif
                                    <td>
                                        @if (getInfoLogin()->hasRole('Admin') || getInfoLogin()->hasRole('Mahasiswa'))
                                            @if ($item->status == 'sudah_sidang')
                                                <span
                                                    class="badge small mb-1 {{ !is_null($item->tugas_akhir->status_sidang) ? ($item->tugas_akhir->status_sidang == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_sidang == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : 'badge-soft-secondary' }}">{{ !is_null($item->tugas_akhir->status_sidang) ? ($item->tugas_akhir->status_sidang == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_sidang == 'revisi' ? 'Disetujui dengan revisi' : 'Sempro Ulang')) : ($item->status == 'sudah_sidang' ? 'Tahap Diskusi' : 'Belum Sidang') }}</span>
                                            @endif
                                        @endif
                                        @if (getInfoLogin()->hasRole('Dosen'))
                                            @if (
                                                !is_null($item->tugas_akhir->sidang()->orderBy('id', 'desc')->first()) &&
                                                    $item->tugas_akhir->sidang()->orderBy('id', 'desc')->first()->status == 'sudah_daftar')
                                                <span class="badge rounded-pill badge-soft-primary">Belum Terjadwal</span>
                                            @else
                                                @if (
                                                    !is_null($item->tugas_akhir->sidang()->orderBy('id', 'desc')->first()) &&
                                                        $item->tugas_akhir->sidang()->orderBy('id', 'desc')->first()->status == 'sudah_terjadwal')
                                                    <span class="badge rounded-pill badge-soft-primary">Sudah
                                                        Terjadwal</span>
                                                @else
                                                    <span class="badge rounded-pill badge-soft-primary">Sudah Sidang</span>
                                                @endif
                                            @endif
                                        @endif
                                        <h5 class="font-size-14 m-0">{{ $item->tugas_akhir->judul }}</h5>
                                        <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} -
                                            {{ $item->tugas_akhir->jenis_ta->nama_jenis }}</p>
                                        <span
                                            class="badge small mb-1 badge-soft-secondary">{{ isset($item->tugas_akhir) ? ($item->tugas_akhir->tipe == 'I' ? 'Individu' : 'Kelompok') : '' }}</span>
                                    </td>
                                    @if (getInfoLogin()->hasRole('Admin') || getInfoLogin()->hasRole('Mahasiswa'))
                                        <td>
                                            @php
                                                $ratingRecap = 0;

                                                $penguji = $item->tugas_akhir->bimbing_uji()->whereIn('jenis', ['pengganti', 'penguji'])->orderBy('urut', 'asc')->get();
                                                $prioritasBimbing = collect();
                                                $penguji->groupBy('urut')->each(function ($group) use ($prioritasBimbing) {
                                                    $prioritasBimbing->push($group->where('jenis', 'pengganti')->first() ?? $group->where('jenis', 'penguji')->first());
                                                });
                                                $revisions = $prioritasBimbing->flatMap(fn($bimbing) => $bimbing->revisi->where('type', 'Sidang'));
                                                $allMentorValidated = $revisions->isNotEmpty() && $revisions->every(fn($revisi) => $revisi->is_mentor_validation);
                                            @endphp
                                            <p class="fw-bold small m-0">Pembimbing
                                                @if (getInfoLogin()->hasRole('Admin'))
                                                    @if (isset($revisions) && $revisions->isNotEmpty())  <i class="bx {{ $allMentorValidated ? 'bx-check-circle text-success' : 'bx-time' }}"></i> @endif
                                                @endif
                                                </p>
                                            <ol>
                                                @for ($i = 0; $i < 2; $i++)
                                                    @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', $i + 1)->count() > 0)
                                                        @foreach ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->get() as $pemb)
                                                            @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 1 && $i == 0)
                                                            @php $ratingRecap += ($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.3; @endphp
                                                            <li class="small"> <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                                <span class="text-muted">Nilai : <strong>{{ number_format($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                        <span style="font-size: 9px;">({{ number_format(($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.3, 2, '.', ',') }})</span>
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 2 && $i == 1)
                                                                @php $ratingRecap += ($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.3; @endphp
                                                                <li class="small">
                                                                    <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                                    <span class="text-muted">Nilai : <strong>{{ number_format($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                        <span style="font-size: 9px;">({{ number_format(($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.3, 2, '.', ',') }})</span>
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li class="small">-</li>
                                                    @endif
                                                @endfor
                                            </ol>
                                            <p class="fw-bold small m-0">Penguji</p>
                                            <ol>
                                                @for ($i = 0; $i < 2; $i++)
                                                    @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->where('urut', $i + 1)->count() > 0)
                                                        @foreach ($item->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->get() as $pemb)
                                                            @if ($pemb->jenis == 'penguji' && $pemb->urut == 1 && $i == 0)
                                                                @php $ratingRecap += ($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2; @endphp
                                                                <li class="small mb-2">
                                                                    <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                                    <span class="text-muted">Nilai : <strong>{{ number_format($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                        <span style="font-size: 9px;">({{ number_format(($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span>
                                                                        @if (getInfoLogin()->hasRole('Admin'))
                                                                        @if (isset($pemb->revisi) && $pemb->revisi->isNotEmpty())
                                                                            @php
                                                                                $penguji1 = $pemb->revisi->where('type', 'Sidang')->first();
                                                                            @endphp
                                                                            @if ($penguji1)
                                                                                <i class="bx {{ $penguji1->is_valid ? 'bx-check-circle text-success' : 'bx-time' }}"></i>
                                                                            @endif
                                                                        @endif
                                                                        @endif

                                                                    </span>
                                                                </li>
                                                            @endif
                                                            @if ($pemb->jenis == 'penguji' && $pemb->urut == 2 && $i == 1)
                                                                @php $ratingRecap += ($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2; @endphp
                                                                <li class="small">
                                                                    <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                                    <span class="text-muted">Nilai :<strong>{{ number_format($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                        <span style="font-size: 9px;">({{ number_format(($pemb->penilaian()->where('type', 'Sidang')->count() > 0 ? $pemb->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span>
                                                                        @if (getInfoLogin()->hasRole('Admin'))
                                                                        @if (isset($pemb->revisi) && $pemb->revisi->isNotEmpty())
                                                                            @php
                                                                                $penguji2 = $pemb->revisi->where('type', 'Sidang')->first();
                                                                            @endphp
                                                                            @if ($penguji2)
                                                                                <i class="bx {{ $penguji2->is_valid ? 'bx-check-circle text-success' : 'bx-time' }}"></i>
                                                                            @endif
                                                                        @endif
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li class="small">-</li>
                                                    @endif
                                                @endfor
                                            </ol>
                                            <p class="fw-bold small m-0">Pengganti</p>
                                            <ol>
                                                @for ($i = 0; $i < 2; $i++)
                                                    @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->where('urut', $i + 1)->count() > 0)
                                                        @foreach ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pengganti')->get() as $peng)
                                                            @if ($peng->jenis == 'pengganti' && $peng->urut == 1 && $i == 0)
                                                            @php $ratingRecap += ($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2; @endphp
                                                            <li class="small mb-2">
                                                                <p class="mb-0">{{ $peng->dosen->name ?? '-' }}</p>
                                                                <span class="text-muted">Nilai : <strong>{{ number_format($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                    <span style="font-size: 9px;">({{ number_format(($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span>
                                                                    @if (getInfoLogin()->hasRole('Admin'))
                                                                    @if (isset($peng->revisi) && $peng->revisi->isNotEmpty())
                                                                        @php
                                                                            $pengganti1 = $peng->revisi->where('type', 'Sidang')->first();
                                                                        @endphp
                                                                        @if ($pengganti1)
                                                                            <i class="bx {{ $pengganti1->is_valid ? 'bx-check-circle text-success' : 'bx-time' }}"></i>
                                                                        @endif
                                                                    @endif
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            @endif
                                                            @if ($peng->jenis == 'pengganti' && $peng->urut == 2 && $i == 1)
                                                            @php $ratingRecap += ($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2; @endphp
                                                            <li class="small mb-2">
                                                                <p class="mb-0">{{ $peng->dosen->name ?? '-' }}</p>
                                                                <span class="text-muted">Nilai : <strong>{{ number_format($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                    <span style="font-size: 9px;">({{ number_format(($peng->penilaian()->where('type', 'Sidang')->count() > 0 ? $peng->penilaian()->where('type', 'Sidang')->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span>
                                                                    @if (getInfoLogin()->hasRole('Admin'))
                                                                    @if (isset($peng->revisi) && $peng->revisi->isNotEmpty())
                                                                        @php
                                                                            $pengganti2 = $peng->revisi->where('type', 'Sidang')->first();
                                                                        @endphp
                                                                        @if ($pengganti2)
                                                                            <i class="bx {{ $pengganti2->is_valid ? 'bx-check-circle text-success' : 'bx-time' }}"></i>
                                                                        @endif
                                                                    @endif
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li class="small">-</li>
                                                    @endif
                                                @endfor
                                            </ol>
                                            <p class="fw-bold small m-0">Rekapitulasi Nilai : {{ number_format($ratingRecap, 2, '.', ',') }}</p>
                                        </td>
                                    @endif
                                    <td>
                                        @if (getInfoLogin()->hasRole('Dosen'))
                                            <strong>{{ isset($item->tugas_akhir->sidang->ruangan->nama_ruangan) ? $item->tugas_akhir->sidang->ruangan->nama_ruangan : '-' }}</strong>
                                            <p class="m-0 small">Tanggal:
                                                {{ $item->tugas_akhir->sidang->tanggal ? Carbon\Carbon::parse($item->tugas_akhir->sidang->tanggal)->format('d/m/Y') : ' -' }}
                                            </p>
                                            <p class="m-0 small">Waktu:
                                                {{ $item->tugas_akhir->sidang->jam_mulai ? Carbon\Carbon::parse($item->tugas_akhir->sidang->jam_mulai)->format('H:i') : '' }}
                                                -
                                                {{ $item->tugas_akhir->sidang->jam_selesai ? Carbon\Carbon::parse($item->tugas_akhir->sidang->jam_selesai)->format('H:i') : '' }}
                                            </p>
                                        @else
                                            <strong>{{ isset($item->ruangan->nama_ruangan) ? $item->ruangan->nama_ruangan : '-' }}</strong>
                                            <p class="m-0 small">Tanggal:
                                                {{ $item->tanggal ? Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : ' -' }}
                                            </p>
                                            <p class="m-0 small">Waktu:
                                                {{ $item->jam_mulai ? Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '' }}
                                                -
                                                {{ $item->jam_selesai ? Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '' }}
                                            </p>
                                        @endif
                                    </td>
                                    @if (getInfoLogin()->hasRole('Dosen'))
                                        <td>
                                            <span
                                                class="badge small mb-1 {{ !is_null($item->tugas_akhir->status_sidang) ? ($item->tugas_akhir->status_sidang == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_sidang == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : 'badge-soft-secondary' }}">{{ !is_null($item->tugas_akhir->status_sidang) ? ($item->tugas_akhir->status_sidang == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_sidang == 'revisi' ? 'Disetujui dengan revisi' : 'Sempro Ulang')) : '-' }}</span>
                                        </td>
                                    @endif
                                    @if (getInfoLogin()->hasRole('Admin'))
                                        <td class="text-align-center justify-content-center">
                                            <p style="white-space: nowrap"

                                                class="font-size-12 small {{ $item->tugas_akhir->status_pemberkasan_sidang == 'sudah_lengkap' ? 'badge badge-soft-success text-success' : 'badge badge-soft-danger text-danger' }}">
                                                {{ $item->tugas_akhir->status_pemberkasan_sidang == 'sudah_lengkap' ? 'Berkas sudah lengkap' : 'Berkas belum lengkap' }}
                                            </p>
                                        </td>
                                    @endif
                                    <td class="mb-3 text-center">
                                        @if (getInfoLogin()->hasRole('Dosen'))
                                            <a href="{{ route('apps.jadwal-sidang.detail', $item->tugas_akhir->sidang->id) }}" class="btn btn-sm btn-outline-primary my-1" title="Detail Sidang"><i class="bx bx-clipboard"></i></a>
                                            @if ($item->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->where('jenis', 'pembimbing')->where('urut', 1)->count() > 0 &&
                                                    $item->tugas_akhir->sidang->status == 'sudah_sidang' &&
                                                    $item->tugas_akhir->status_sidang != 'acc' &&
                                                    $item->tugas_akhir->status_sidang != 'revisi' &&
                                                    $item->tugas_akhir->status_sidang != 'retrial')
                                                <button class="btn btn-outline-warning btn-sm mb-1" type="button" data-bs-toggle="modal" data-bs-target="#myModal{{ $item->id }}">Setujui?</button>
                                                @include('administrator.jadwal-sidang.partials.modal')
                                            @endif
                                        @endif

                                            {{-- @if (getInfoLogin()->hasRole('Mahasiswa'))
                                                @if ($item->status == 'sudah_sidang')
                                                    <a href="{{ route('apps.jadwal-sidang.detail', $item->id) }}" class="btn btn-sm btn-outline-primary my-1" title="Detail Sidang"><i class="bx bx-show"></i></a>
                                                @endif
                                                @if ($item->status == 'belum_daftar' || $item->status == 'sudah_daftar')
                                                    @if ($item->tugas_akhir->status_pemberkasan == 'sudah_lengkap')
                                                        <button onclick="daftarSidang('{{ $item->id }}', '{{ route('apps.jadwal-sidang.register', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>Daftar</button>
                                                    @endif
                                                @else
                                                    @if ($item->tugas_akhir->status_sidang != 'reject' && $item->tugas_akhir->status_pemberkasan_sidang != 'sudah_lengkap')
                                                        <a href="javascript:void(0);" onclick="unggahFile('{{ $item->id }}', '{{ route('apps.jadwal-sidang.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>Unggah</a>
                                                    @endif
                                                @endif
                                            @endif --}}
                                        @if (getInfoLogin()->hasRole('Mahasiswa'))
                                            @if ($item->status == 'sudah_sidang')
                                                <a href="{{ route('apps.jadwal-sidang.detail', $item->id) }}" class="btn btn-sm btn-outline-primary my-1" title="Detail Sidang">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            @endif

                                            @if (in_array($item->status, ['belum_daftar', 'sudah_daftar']))
                                                @if ($item->tugas_akhir->status_pemberkasan == 'sudah_lengkap')
                                                    <button onclick="daftarSidang('{{ $item->id }}', '{{ route('apps.jadwal-sidang.register', $item->id) }}')" class="btn btn-sm btn-outline-dark my-1">
                                                        <i class="bx bx-file"></i> Daftar
                                                    </button>
                                                @else
                                                    <p style="white-space: nowrap" class="font-size-12 small badge badge-soft-danger text-dark">Belum pemberkasan sempro</p>
                                                @endif
                                            @endif

                                            @if ($item->status == 'sudah_sidang')
                                                <a href="javascript:void(0);" onclick="unggahFile('{{ $item->id }}', '{{ route('apps.jadwal-sidang.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark my-1">
                                                    <i class="bx bx-file"></i> Unggah
                                                </a>
                                            @endif
                                        @endif


                                        {{-- @if (getInfoLogin()->hasRole('Admin'))
                                            @if ($item->status == 'belum_daftar')
                                                <a href="{{ route('apps.jadwal-sidang.edit', ['jadwalSidang' => $item->id]) }}" class="btn btn-sm btn-primary"><i class="bx bx-calendar-event"></i></a>
                                            @endif
                                            @if ($item->status == 'sudah_daftar')
                                                <a href="javascript:void(0);" onclick="validasiFile('{{ $item->id }}', '{{ route('apps.jadwal-sidang.validasi-berkas', $item->id) }}')" class="btn btn-sm btn-outline-success my-1" title="Detail Berkas"><i class="bx bx-pencil"></i></a>
                                            @endif
                                            @if ($item->tugas_akhir->status_pemberkasan_sidang == 'belum_lengkap' && $item->status !== 'belum_daftar')
                                                <a href="javascript:void(0);" onclick="validasiFile('{{ $item->id }}', '{{ route('apps.jadwal-sidang.validasi-berkas', $item->id) }}')" class="btn btn-sm btn-outline-success my-1" title="Detail Berkas"><i class="bx bx-pencil"></i></a>
                                            @endif
                                            @if ($item->status == 'sudah_daftar' || $item->status == 'sudah_terjadwal')
                                                <a href="{{ route('apps.jadwal-sidang.edit', ['jadwalSidang' => $item->id]) }}" class="btn btn-sm btn-primary"><i class="bx bx-calendar-event"></i></a>
                                            @endif
                                            @if ($item->status == 'sudah_sidang')
                                                <a href="{{ route('apps.jadwal-sidang.show-data', $item) }}" class="btn btn-sm btn-outline-warning mb-2" title="Detail"><i class="bx bx-show"></i></a>
                                            @endif
                                        @endif --}}

                                        @if (getInfoLogin()->hasRole('Admin'))
                                            {{-- Jika status belum_daftar, tampilkan tombol edit --}}
                                            @if ($item->status == 'belum_daftar')
                                                <a href="{{ route('apps.jadwal-sidang.edit', ['jadwalSidang' => $item->id]) }}" class="btn btn-sm btn-primary my-1" title="Atur Jadwal">
                                                    <i class="bx bx-calendar-event"></i>
                                                </a>
                                            @endif
                                            {{-- Jika status sudah_daftar atau sudah_terjadwal, tampilkan tombol edit --}}
                                            @if (in_array($item->status, ['sudah_daftar', 'sudah_terjadwal']))
                                                <a href="{{ route('apps.jadwal-sidang.edit', ['jadwalSidang' => $item->id]) }}" class="btn btn-sm btn-primary my-1" title="Atur Jadwal">
                                                    <i class="bx bx-calendar-event"></i>
                                                </a>
                                            @endif
                                            {{-- Jika status sudah_daftar atau status_pemberkasan_sidang belum lengkap dan status bukan belum_daftar --}}
                                            @if (($item->status == 'sudah_daftar') || ($item->tugas_akhir->status_pemberkasan_sidang == 'belum_lengkap' && $item->status !== 'belum_daftar'))
                                                <a href="javascript:void(0);" onclick="validasiFile('{{ $item->id }}', '{{ route('apps.jadwal-sidang.validasi-berkas', $item->id) }}')" class="btn btn-sm btn-outline-success my-1" title="Validasi Berkas">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                            @endif
                                            {{-- Jika status sudah_sidang tampilkan tombol detail --}}
                                            @if ($item->status == 'sudah_sidang')
                                                <a href="{{ route('apps.jadwal-sidang.show-data', $item) }}" class="btn btn-sm btn-outline-warning my-1" title="Detail Sidang">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            @endif

                                        @endif


                                        @include('administrator.jadwal-sidang.partials.modal')
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr class="text-center">
                                <td colspan="7">No data available in table</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function uploadFileSidang(id, url) {
            $('#id_jadwal_sidang').val(id);
            $('#url_unggah_berkas').val(url);
            ~
            $('#myModalUpload').find('form').trigger('reset');
            $('#myModalUpload').find('form').attr("action", url);
            $('#myModalUpload').modal('show');
        }

        function changeFile(target) {
            var filename = $(target).find('[type="file"]').prop('files')[0].name;
            $(target).find('.file-desc').html(filename);
            $(target).find('.file-icon').attr('class', 'file-icon mdi mdi-alert-circle-outline text-warning');
            $(target).find('.file-btn').html('Ganti');
        }

        $('.update-status').unbind().on('click', async function(e) {
            e.preventDefault()
            $(this).parent().find('.update-status').html('<i class="bx bx-loader bx-spin"></i>').attr(
                'disabled', 'disabled');
            const res = await fetch($(this).attr('href'), {
                headers: {
                    'accept': 'application/json'
                }
            })

            $($(this).parent().find('.update-status')[0]).html('<i class="bx bx-check"></i>').removeAttr(
                'disabled');
            $($(this).parent().find('.update-status')[1]).html('<i class="bx bx-x"></i>').removeAttr(
                'disabled');
            if (res.status == 200) {
                var data = await res.json()

                if (data.status == 'approve') {
                    $(this).parent().find('.icon-display').attr('class',
                        'file-icon bx bx-check-circle text-success icon-display')
                }

                if (data.status == 'reject') {
                    $(this).parent().find('.icon-display').attr('class',
                        'file-icon mdi mdi-close-circle-outline text-danger icon-display')
                }

                $(this).parent().find('.update-status').remove()
            } else {

            }
        })
    </script>
@endsection
