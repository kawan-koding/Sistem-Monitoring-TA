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

                    <div class="mb-3 d-flex gap-2 flex-column justify-content-end flex-md-row" >
                        <form action="">
                            <select name="program_studi" id="program_studi" class="form-control" style="min-width: 300px; width: 100%" onchange="this.form.submit()">
                                <option selected disabled hidden>Filter Program Studi</option>
                                <option value="semua" {{ request('program_studi') == 'semua' ? 'selected' : '' }}>Semua Program Studi</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" {{ request('program_studi') == $p->id ? 'selected' : '' }}>{{ $p->display }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <hr>
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th>Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Ruangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="m-0"><span class="badge badge-soft-primary">{{ !is_null($item->tugas_akhir->mahasiswa->programStudi) ? $item->tugas_akhir->mahasiswa->programStudi->display : '' }}</span></p>
                                            <p class="m-0"><strong>{{ $item->tugas_akhir->mahasiswa->nama_mhs }} - {{ $item->tugas_akhir->mahasiswa->kelas }}</strong></p>
                                            <p class="m-0 p-0 text-muted small">NIM : {{$item->tugas_akhir->mahasiswa->nim}}</p>
                                        </td>
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
                                            <p class="m-0"><strong>{{ $item->tugas_akhir->judul }}</strong></p>
                                            <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} - {{ $item->tugas_akhir->jenis_ta->nama_jenis}}</p>
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
                                                class="badge {{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'retrial' ? 'badge-soft-warning' : 'badge-soft-danger'))) : 'badge-soft-secondary' }}">{{!is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Disetujui dengan revisi' : ($item->tugas_akhir->status_seminar == 'retrial' ? 'Sempro Ulang' : 'Ditolak'))) : '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if (!is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) && $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->status != 'belum_terjadwal' || !is_null($item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()) && $item->tugas_akhir->status_seminar == 'retrial')
                                                <a href="{{ route('apps.jadwal.penilaian', $item->tugas_akhir->jadwal_seminar()->orderBy('id', 'desc')->first()->id) }}"
                                                    class="btn btn-outline-primary btn-sm mb-1">
                                                    <i class="bx bx-clipboard"></i>
                                                </a>
                                            @endif
                                            @if ($item->tugas_akhir->bimbing_uji()->where('dosen_id', getInfoLogin()->userable_id)->where('jenis', 'pembimbing')->where('urut', 1)->count() > 0 && $item->tugas_akhir->status_seminar != 'acc' && $item->tugas_akhir->status_seminar != 'revisi' && $item->tugas_akhir->status_seminar != 'reject' && (!is_null($item->tugas_akhir->jadwal_seminar) && $item->tugas_akhir->jadwal_seminar->status == 'telah_seminar' || $item->tugas_akhir->status_seminar == 'retrial'))
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
