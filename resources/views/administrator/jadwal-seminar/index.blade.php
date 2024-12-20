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
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ getSetting('app_seminar_registration_template') }}" target="_blank"
                    class="btn btn-success mb-2"><i class="far fa-file-alt"></i> Template Pendaftaran Seminar</a>
                <a href="{{ getSetting('app_seminar_filing_template') }}" target="_blank" class="btn btn-secondary mb-2"><i
                        class="far fa-file-alt"></i> Template Pemberkasan Seminar</a>
                @if (session('switchRoles') == 'Admin')
                    <div class="btn-group" role="group">
                        <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle mb-2"
                            style="max-width: 150px;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file-excel me-2"></i> Export <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-seminar.export', ['type' => 'belum_terjadwal']) }}">Belum
                                Terjadwal</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-seminar.export', ['type' => 'telah_seminar']) }}">Telah
                                Diseminarkan</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-seminar.export', ['type' => 'sudah_pemberkasan']) }}">Sudah
                                Pemberkasan Seminar</a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('apps.jadwal-seminar.export', ['type' => 'st_sempro']) }}">ST Sempro</a>
                        </div>
                    </div>
                @endif
            </div>
            <hr>
            @if (getInfoLogin()->hasRole('Admin'))
                <form action="">
                    <input type="hidden" name="{{ !is_null($status) ? 'status' : 'status_pemberkasan' }}"
                        value="{{ !is_null($status) ? $status : $status_pemberkasan }}">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            {{-- @if (!is_null($status))
                                <input type="hidden" name="status" value="{{ $status }}">
                            @endif --}}
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
                        </div>
                        <div class="col-md-6 col-sm-12">p
                            <label for="">Filter berdasarkan Prodi / Periode</label>
                            <div class="row">
                                <div class="col-6">
                                    <select name="filter1" class="form-control" onchange="this.form.submit()">
                                        <option value="semua" {{ $filter1 == 'semua' ? 'selected' : '' }}>Semua Program
                                            Studi</option>
                                        @foreach ($programStudies as $item)
                                            <option value="{{ $item->id }}"{{ $filter1 == $item->id ? 'selected' : '' }}>{{ $item->display }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
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
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="mb-0">

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
                        <li class="nav-item">
                            <a class="nav-link @if (url()->full() == route('apps.jadwal-seminar', ['status_pemberkasan' => 'sudah_lengkap'])) active @endif"
                                href="{{ route('apps.jadwal-seminar', ['status_pemberkasan' => 'sudah_lengkap']) }}">
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
                            @if (getInfoLogin()->hasRole('Admin'))
                                <th>Mahasiswa</th>
                            @endif
                            <th width="40%">Judul</th>
                            @if (getInfoLogin()->hasRole('Admin'))
                                <th>Periode</th>
                            @endif
                            <th width="20%">Dosen</th>
                            <th>Ruangan</th>
                            @if (getInfoLogin()->hasRole('Admin'))
                                <th>Status</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td>
                                        @if (getInfoLogin()->hasRole('Admin'))
                                            <span
                                                class="badge badge-soft-primary">{{ !is_null($item->tugas_akhir->mahasiswa->programStudi) ? $item->tugas_akhir->mahasiswa->programStudi->display : '' }}</span>
                                        @endif
                                        <p class="fw-bold m-0">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p>
                                        <p class="small text-muted">NIM : {{ $item->tugas_akhir->mahasiswa->nim }}</p>
                                    </td>
                                @endif
                                <td>
                                    @if ($item->status == 'telah_seminar')
                                        <span
                                            class="badge small mb-1 {{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : 'badge-soft-secondary' }}">{{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Disetujui dengan revisi' : 'Ditolak')) : ($item->status == 'telah_seminar' ? 'Tahap Diskusi' : 'Belum Seminar') }}</span>
                                    @endif
                                    <h5 class="font-size-14 m-0">{{ $item->tugas_akhir->judul }}</h5>
                                    <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} -
                                        {{ $item->tugas_akhir->jenis_ta->nama_jenis }}</p>
                                    <span
                                        class="badge small mb-1 badge-soft-secondary">{{ isset($item->tugas_akhir) ? ($item->tugas_akhir->tipe == 'I' ? 'Individu' : 'Kelompok') : '' }}</span>
                                </td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td>{{ !is_null($item->tugas_akhir->periode_ta) ? $item->tugas_akhir->periode_ta->nama : '-' }}
                                    </td>
                                @endif
                                <td>
                                    <p class="fw-bold small m-0">Pembimbing</p>
                                    <ol>
                                        @for ($i = 0; $i < 2; $i++)
                                            @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->count() > $i)
                                                @foreach ($item->tugas_akhir->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 1 && $i == 0)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 2 && $i == 1)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
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
                                            @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->count() > $i)
                                                @foreach ($item->tugas_akhir->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 1 && $i == 0)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 2 && $i == 1)
                                                        <li class="small">{{ $pemb->dosen->name ?? '-' }}</li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif
                                        @endfor
                                    </ol>
                                </td>
                                <td>
                                    <strong>{{ isset($item->ruangan->nama_ruangan) ? $item->ruangan->nama_ruangan : '-' }}</strong>
                                    <p class="m-0 small">Tanggal:
                                        {{ $item->tanggal ? Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : ' -' }}
                                    </p>
                                    <p class="m-0 small">Waktu:
                                        {{ $item->jam_mulai ? Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '' }}
                                        -
                                        {{ $item->jam_selesai ? Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '' }}
                                    </p>
                                </td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td class="text-align-center justify-content-center">
                                        <p style="white-space: nowrap"
                                            class="font-size-12 {{ $item->tugas_akhir->status_pemberkasan == 'sudah_lengkap' || !is_null($item->tugas_akhir->status_sidang) ? 'badge badge-soft-success text-success' : 'badge badge-soft-danger text-danger' }}">
                                            {{ $item->tugas_akhir->status_pemberkasan == 'sudah_lengkap' || !is_null($item->tugas_akhir->status_sidang) ? 'Berkas sudah lengkap' : 'Berkas belum lengkap' }}
                                        </p>
                                    </td>
                                @endif
                                <td class="mb-3 text-center">
                                    @if (getInfoLogin()->hasRole('Admin'))
                                        @if ($item->status != 'telah_seminar')
                                            @can('update-jadwal-seminar')
                                                <a href="{{ route('apps.jadwal-seminar.edit', ['jadwalSeminar' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary mb-2"><i class="bx bx-calendar-event"></i></a>
                                            @endcan
                                        @endif
                                        @if ($item->status == 'telah_seminar')
                                            <a href="{{ route('apps.jadwal-seminar.show', $item) }}"
                                                class="btn btn-sm btn-outline-warning mb-2" title="Detail"><i
                                                    class="bx bx-show"></i></a>
                                        @endif
                                        @if ($item->tugas_akhir->status_pemberkasan != 'sudah_lengkap' && is_null($item->tugas_akhir->status_sidang))
                                            <a href="javascript:void(0)"
                                                onclick="validasiFile('{{ $item->id }}', '{{ route('apps.jadwal-seminar.validate', $item->id) }}')"
                                                class="btn btn-sm btn-outline-success mb-2" title="Validasi Berkas"><i
                                                    class="bx bx-pencil"></i></a>
                                        @endif
                                    @endif

                                    @if (getInfoLogin()->hasRole('Mahasiswa'))
                                        <a href="{{ route('apps.jadwal-seminar.detail', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary my-1"><i class="bx bx-show"
                                                title="Detail"></i></a>
                                        @if($item->tugas_akhir->status_seminar != 'reject' && $item->tugas_akhir->status_pemberkasan != 'sudah_lengkap' || $item->tugas_akhir->status_seminar != 'reject' && is_null($item->tugas_akhir->status_sidang))
                                            <a href="javascript:void(0);"
                                                onclick="uploadFileSeminar('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="bx bx-file"></i>
                                                Unggah
                                            </a>
                                        @endif
                                    @endif
                                    @include('administrator.jadwal-seminar.partials.modal')
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="8">No data available in table</td>
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
        function uploadFileSeminar(id, url) {
            $('#id_jadwal_seminar').val(id);
            $('#url_unggah_berkas').val(url);
            $('#myModalUpload'+ id).find('form').trigger('reset');
            $('#myModalUpload'+ id).find('form').attr("action", url);
            $('#myModalUpload'+ id).modal('show');
        }

        function changeFile(target) {
            var filename = $(target).find('[type="file"]').prop('files')[0].name;
            $(target).find('.file-desc').html(filename);
            $(target).find('.file-icon').attr('class', 'file-icon mdi mdi-alert-circle-outline text-warning');
            $(target).find('.file-btn').html('Ganti');
        }

        function validate(id) {
            Swal.fire({
                title: "Validasi Kelengkapan Berkas?",
                text: "Apakah kamu yakin untuk memvalidasi data ini?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, validasi!"
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ route('apps.jadwal-seminar.validate', ':id') }}".replace(':id', id);
                }
            })
        }
    </script>
@endsection
