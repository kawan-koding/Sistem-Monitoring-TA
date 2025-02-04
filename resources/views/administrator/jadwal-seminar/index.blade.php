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
                                href="{{ route('apps.jadwal-seminar.export', ['type' => 'sudah_terjadwal']) }}">Sudah
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
                        <div class="col-md-6 col-sm-12">
                            <label for="">Filter berdasarkan Prodi / Periode</label>
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
                                        <option value="semua" {{ $type == 'semua' ? 'selected' : '' }}>Semua Jenis
                                            Penyelesaian</option>
                                        <option value="I" {{ $type == 'I' ? 'selected' : '' }}>Individu</option>
                                        <option value="K" {{ $type == 'K' ? 'selected' : '' }}>Kelompok</option>
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
                        @forelse ($data as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td>
                                        @if (getInfoLogin()->hasRole('Admin'))
                                            <span
                                                class="badge badge-soft-primary">{{ !is_null($item->tugas_akhir->mahasiswa->programStudi) ? $item->tugas_akhir->mahasiswa->programStudi->display : '' }}</span>
                                            <a href="#" class="m-0" data-bs-toggle="modal"
                                                data-bs-target="#mahasiswaModal{{ $key }}">
                                                <p class="fw-bold m-0">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p>
                                            </a>
                                            <div class="modal fade" id="mahasiswaModal{{ $key }}"
                                                tabindex="-1" aria-labelledby="mahasiswaModalLabel{{ $key }}"
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
                                                                        alt="Foto Mahasiswa" class="img-fluid rounded">
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
                                        @else
                                            <p class="fw-bold m-0">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p>
                                        @endif
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
                                    @php $ratingRecap = 0; @endphp
                                    <p class="fw-bold small m-0">Pembimbing</p>
                                    <ol>
                                        @for ($i = 0; $i < 2; $i++)
                                            @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'pembimbing')->count() > $i)
                                                @foreach ($item->tugas_akhir->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 1 && $i == 0)
                                                        @php $ratingRecap += ($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.3; @endphp
                                                        <li class="small mb-2">
                                                            <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                            <span class="text-muted">Nilai :
                                                                <strong>{{ number_format($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                <span
                                                                    style="font-size: 9px;">({{ number_format(($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.3, 2, '.', ',') }})</span></span>
                                                        </li>
                                                    @endif
                                                    @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 2 && $i == 1)
                                                        @php $ratingRecap += ($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.3; @endphp
                                                        <li class="small">
                                                            <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                            <span class="text-muted">Nilai :
                                                                <strong>{{ number_format($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                <span
                                                                    style="font-size: 9px;">({{ number_format(($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.3, 2, '.', ',') }})</span></span>
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
                                            @if ($item->tugas_akhir->bimbing_uji()->where('jenis', 'penguji')->count() > $i)
                                                @foreach ($item->tugas_akhir->bimbing_uji as $pemb)
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 1 && $i == 0)
                                                        @php $ratingRecap += ($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.2; @endphp
                                                        <li class="small mb-2">
                                                            <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                            <span class="text-muted">Nilai :
                                                                <strong>{{ number_format($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                <span
                                                                    style="font-size: 9px;">({{ number_format(($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span></span>
                                                        </li>
                                                    @endif
                                                    @if ($pemb->jenis == 'penguji' && $pemb->urut == 2 && $i == 1)
                                                        @php $ratingRecap += ($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.2; @endphp
                                                        <li class="small">
                                                            <p class="mb-0">{{ $pemb->dosen->name ?? '-' }}</p>
                                                            <span class="text-muted">Nilai :
                                                                <strong>{{ number_format($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0, 2, '.', ',') }}</strong>
                                                                <span
                                                                    style="font-size: 9px;">({{ number_format(($pemb->penilaian->count() > 0 ? $pemb->penilaian->avg('nilai') : 0) * 0.2, 2, '.', ',') }})</span></span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li class="small">-</li>
                                            @endif
                                        @endfor
                                    </ol>
                                    <p class="fw-bold small m-0">Rekapitulasi Nilai :
                                        {{ number_format($ratingRecap, 2, '.', ',') }}</p>
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
                                            class="font-size-12 mb-0 {{ $item->tugas_akhir->status_pemberkasan == 'sudah_lengkap' || !is_null($item->tugas_akhir->status_sidang) ? 'badge badge-soft-success text-success' : 'badge badge-soft-danger text-danger' }}">
                                            {{ $item->tugas_akhir->status_pemberkasan == 'sudah_lengkap' || !is_null($item->tugas_akhir->status_sidang) ? 'Berkas sudah lengkap' : 'Berkas belum lengkap' }}
                                        </p>
                                        @if($item->tugas_akhir->status_seminar == 'retrial')
                                        <p style="white-space: nowrap"
                                            class="font-size-12 badge badge-soft-warning">
                                            Sempro Ulang
                                        </p>
                                        @endif
                                    </td>
                                @endif
                                <td class="mb-3 text-center">
                                    @if (getInfoLogin()->hasRole('Admin'))
                                        @if ($item->status != 'telah_seminar')
                                            @can('update-jadwal-seminar')
                                                <a href="{{ route('apps.jadwal-seminar.edit', ['jadwalSeminar' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary mb-2"><i
                                                        class="bx bx-calendar-event"></i></a>
                                            @endcan
                                        @endif
                                        @if ($item->status == 'sudah_terjadwal')
                                            <a href="javascript:void(0)"
                                                onclick="reset('{{ $item->id }}', '{{ route('apps.jadwal-seminar.reset', ['jadwalSeminar' => $item->id]) }}')"
                                                class="btn btn-sm btn-danger mb-2" title="Reset Jadwal Seminar"><i
                                                    class="bx bx-reset"></i></a>
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
                                        @if (
                                            ($item->tugas_akhir->status_seminar != 'reject' && $item->tugas_akhir->status_pemberkasan != 'sudah_lengkap') ||
                                                ($item->tugas_akhir->status_seminar != 'reject' && is_null($item->tugas_akhir->status_sidang)))
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
            $('#myModalUpload' + id).find('form').trigger('reset');
            $('#myModalUpload' + id).find('form').attr("action", url);
            $('#myModalUpload' + id).modal('show');
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
