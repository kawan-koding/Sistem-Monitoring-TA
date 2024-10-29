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
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            @if (getInfoLogin()->hasRole('Admin'))
                <div class="col-md-8 col-sm-12">
                    <form action="">
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
                                            <a href="{{ route('apps.jadwal-seminar') }}"
                                                class="btn btn-secondary input-group-text inner">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @can('read-jadwal-seminar')
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-seminar')) active @endif"
                                href="{{ route('apps.jadwal-seminar') }}">
                                <span class="d-block d-sm-none"><i class="bx bx-timer"></i></span>
                                <span class="d-none d-sm-block">Belum Terjadwal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-seminar', ['status' => 'sudah_terjadwal'])) active @endif"
                                href="{{ route('apps.jadwal-seminar', ['status' => 'sudah_terjadwal']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-list-check"></i></span>
                                <span class="d-none d-sm-block">Sudah Terjadwal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-seminar', ['status' => 'telah_seminar'])) active @endif"
                                href="{{ route('apps.jadwal-seminar', ['status' => 'telah_seminar']) }}">
                                <span class="d-block d-sm-none"><i class="bx bx-check-circle"></i></span>
                                <span class="d-none d-sm-block">Telah Diseminarkan</span>
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
                            <th min-width="200px">Judul</th>
                            @if (getInfoLogin()->hasRole('Admin'))
                                <th>Mahasiswa</th>
                            @endif
                            <th>Dosen</th>
                            <th>Ruangan</th>
                            @if (getInfoLogin()->hasRole('Admin'))
                                <th>Status</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @foreach ($item->tugas_akhir->bimbing_uji as $bimuj)
                                @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 1)
                                    @php
                                        $item_pemb_1 = $bimuj->dosen->name;
                                    @endphp
                                @endif
                                @if ($bimuj->jenis == 'pembimbing' && $bimuj->urut == 2)
                                    @php
                                        $item_pemb_2 = $bimuj->dosen->name;
                                    @endphp
                                @endif
                                @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 1)
                                    @php
                                        $item_peng_1 = $bimuj->dosen->name;
                                    @endphp
                                @endif
                                @if ($bimuj->jenis == 'penguji' && $bimuj->urut == 2)
                                    @php
                                        $item_peng_2 = $bimuj->dosen->name;
                                    @endphp
                                @endif
                            @endforeach
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->status == 'telah_seminar')
                                        <span
                                            class="badge small mb-1 {{ isset($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-primary' : 'badge-soft-danger')) : '' }}">{{ ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Revisi' : 'Ditolak')) ?? 'Belum Diseminarkan' }}</span>
                                    @endif
                                    <a href="{{ route('apps.jadwal-seminar.detail', $item->id) }}">
                                        <h5 class="fw-bold m-0">{{ $item->tugas_akhir->judul }}</h5>
                                    </a>
                                    <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} -
                                        {{ $item->tugas_akhir->jenis_ta->nama_jenis }}</p>
                                </td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td>{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</td>
                                @endif
                                <td>
                                    <strong>Pembimbing</strong>
                                    <ol>
                                        <li>{{ $item_pemb_1 ?? '-' }}</li>
                                        <li>{{ $item_pemb_2 ?? '-' }}</li>
                                    </ol>
                                    <strong>Penguji</strong>
                                    <ol>
                                        <li>{{ $item_peng_1 ?? '-' }}</li>
                                        <li>{{ $item_peng_2 ?? '-' }}</li>
                                    </ol>
                                </td>
                                <td>
                                    <strong>{{ isset($item->ruangan->nama_ruangan) ? $item->ruangan->nama_ruangan : '-' }}</strong>
                                    <p class="m-0">Tanggal:
                                        {{ $item->tanggal ? Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : ' -' }}
                                    </p>
                                    <p class="m-0">Waktu:
                                        {{ $item->jam_mulai ? Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '' }}
                                        -
                                        {{ $item->jam_selesai ? Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '' }}
                                    </p>
                                </td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td class="text-align-center justify-content-center">
                                        @if ($item->status == 'belum_terjadwal')
                                            <span class="badge rounded-pill badge-soft-secondary font-size-12">Belum
                                                Terjadwal</span>
                                        @else
                                            @if ($item->status == 'sudah_terjadwal')
                                                <span class="badge rounded-pill badge-soft-primary font-size-12">Sudah
                                                    Terjadwal</span>
                                            @else
                                                <span class="badge rounded-pill badge-soft-success font-size-12">Telah
                                                    Seminar</span>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                                <td class="mb-3 text-center">
                                    {{-- <div class="btn-group"> --}}
                                    @if (getInfoLogin()->hasRole('Admin'))
                                        @can('update-jadwal-seminar')
                                            <a href="{{ route('apps.jadwal-seminar.edit', ['jadwalSeminar' => $item->id]) }}"
                                                class="btn btn-sm btn-primary"><i class="bx bx-calendar-event"></i></a>
                                            {{-- @if ($item->status == 'sudah_terjadwal')
                                                <a href="" class="btn btn-sm btn-primary"><i class="bx bx-check"></i></a>
                                            @endif --}}
                                        @endcan
                                    @endif
                                    @if (getInfoLogin()->hasRole('Mahasiswa'))
                                        <a href="{{ route('apps.jadwal-seminar.detail', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary"><i class="bx bx-search my-1"></i></a>
                                        <a href="javascript:void(0);"
                                            onclick="uploadFileSeminar('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')"
                                            class="btn btn-sm btn-outline-dark">
                                            @if ($item->status == 'sudah_terjadwal')
                                                <i class="mdi mdi-pencil"></i>
                                                Daftar
                                            @else
                                                <i class="bx bx-file"></i>
                                                Unggah
                                            @endif
                                        </a>
                                    @endif
                                    {{-- </div> --}}
                                </td>
                            </tr>
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

    @include('administrator.jadwal-seminar.partials.modal')
@endsection

@section('js')
    <script>
        function uploadFileSeminar(id, url) {
            $('#id_jadwal_seminar').val(id);
            $('#url_unggah_berkas').val(url);
            $('#myModalUpload').modal('show');
        }
    </script>
@endsection
