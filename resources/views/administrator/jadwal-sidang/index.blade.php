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
            <a href="#" target="_blank" class="btn btn-success mb-2"><i class="far fa-file-alt"></i> Template Pendaftaran Sidang</a>
            <a href="#" target="_blank" class="btn btn-secondary mb-2"><i class="far fa-file-alt"></i> Template Pemberkasan Sidang</a>
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

            @if (getInfoLogin()->hasRole('Admin'))
                <div class="col-md-8 col-sm-12">
                    <form action="">
                        @if(!is_null($status))
                        <input type="hidden" name="status" value="{{ $status }}">
                        @endif
                        <label for="">Filter Tanggal</label>
                        <div class="inner mb-3 row">
                            <div class="col-md-8 col-sm-6">
                                <div class="position-relative">
                                    <div class="input-group">
                                        <input type="date" name="tanggal" class="inner form-control" placeholder="cari berdasarkan tanggal">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-primary input-group-text inner">Filter</button>
                                            <a href="{{ route('apps.jadwal-seminar') }}" class="btn btn-secondary input-group-text inner">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @can('read-daftar-sidang')
                <ul class="nav nav-tabs nav-tabs-custom nav-justified mt-1 mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang')) active @endif"
                            href="{{ route('apps.jadwal-sidang') }}">
                            <span class="d-block d-sm-none"><i class="bx bx-timer"></i></span>
                            <span class="d-none d-sm-block">Belum Terjadwal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status' => 'sudah_terjadwal'])) active @endif"
                            href="{{ route('apps.jadwal-sidang', ['status' => 'sudah_terjadwal']) }}">
                            <span class="d-block d-sm-none"><i class="bx bx-list-check"></i></span>
                            <span class="d-none d-sm-block">Sudah Terjadwal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status' => 'sudah_sidang'])) active @endif"
                            href="{{ route('apps.jadwal-sidang', ['status' => 'sudah_sidang']) }}">
                            <span class="d-block d-sm-none"><i class="bx bx-check-circle"></i></span>
                            <span class="d-none d-sm-block">Telah Sidang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (url()->full() == route('apps.jadwal-sidang', ['status_pemberkasan' => 'sudah_lengkap'])) active @endif"
                            href="{{ route('apps.jadwal-sidang', ['status_pemberkasan' => 'sudah_lengkap']) }}">
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
                            <th width="40%">Judul</th>
                            @if (getInfoLogin()->hasRole('Admin'))
                            <th>Mahasiswa</th>
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
                                <td>
                                    @if ($item->status == 'telah_seminar')
                                        <span
                                            class="badge small mb-1 {{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : '' }}">{{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Disetujui dengan revisi' : 'Ditolak')) : 'Belum Seminar' }}</span>
                                    @endif
                                    <a href="{{ route('apps.jadwal-sidang.detail', $item->id) }}">
                                        <h5 class="small font-size-14 m-0">{{ $item->tugas_akhir->judul }}</h5>
                                    </a>
                                    <p class="m-0 text-muted small">{{ $item->tugas_akhir->topik->nama_topik }} -
                                        {{ $item->tugas_akhir->jenis_ta->nama_jenis }}</p>
                                </td>
                                @if (getInfoLogin()->hasRole('Admin'))
                                    <td><p class="small">{{ $item->tugas_akhir->mahasiswa->nama_mhs }}</p></td>
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
                                        <p style="white-space: nowrap" class="font-size-12 small {{ !is_null($item->status_sidang) && $item->document_complete ? 'badge badge-soft-success text-success' : 'badge badge-soft-danger text-danger' }}">{{ !is_null($item->status_sidang) &&    $item->document_complete ? 'Berkas sudah lengkap' : 'Berkas belum lengkap' }}</p>
                                    </td>
                                @endif
                                <td class="mb-3 text-center">
                                    @if (getInfoLogin()->hasRole('Mahasiswa'))
                                    <a href="{{ route('apps.jadwal-sidang.detail-sidang', $item->id) }}" class="btn btn-sm btn-outline-primary my-1" title="Detail Sidang"><i class="bx bx-show" ></i></a>
                                        @if($item->status == 'belum_daftar')
                                            <button onclick="daftarSidang('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>
                                                Daftar
                                            </button>
                                            @else 
                                            <a href="javascript:void(0);" onclick="unggahFile('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>
                                                Unggah
                                            </a>
                                        @endif
                                    @endif
                                    @if(getInfoLogin()->hasRole('Admin'))
                                        {{-- @if($item->status == 'sudah_daftar' || $item->status == 'sudah_sidang')
                                          <a href="javascript:void(0);" onclick="validasiFile('{{ $item->id}}', '{{ route('apps.jadwal-sidang.validasi-berkas', $item->id) }}')" class="btn btn-sm btn-outline-success my-1" title="Detail Berkas"><i class="bx bx-pencil"></i></a>
                                        @endif --}}
                                        @if($item->status == 'sudah_daftar' || $item->status == 'sudah_terjadwal')
                                            <a href="{{ route('apps.jadwal-sidang.edit', ['jadwalSidang' => $item->id]) }}"
                                            class="btn btn-sm btn-primary"><i class="bx bx-calendar-event"></i></a>
                                        @endif
                                    @endif
                                    @include('administrator.jadwal-sidang.partials.modal')
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

    
@endsection
@section('js')
<script>
    function uploadFileSeminar(id, url) {
        $('#id_jadwal_seminar').val(id);
        $('#url_unggah_berkas').val(url);
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
        $(this).parent().find('.update-status').html('<i class="bx bx-loader bx-spin"></i>').attr('disabled', 'disabled');
        const res = await fetch($(this).attr('href'), {
            headers: {
                'accept': 'application/json'
            }
        })
        
        $($(this).parent().find('.update-status')[0]).html('<i class="bx bx-check"></i>').removeAttr('disabled');
        $($(this).parent().find('.update-status')[1]).html('<i class="bx bx-x"></i>').removeAttr('disabled');
        if(res.status == 200) {
            var data = await res.json()

            if(data.status == 'approve') {
                $(this).parent().find('.icon-display').attr('class', 'file-icon bx bx-check-circle text-success icon-display')
            }

            if(data.status == 'reject') {
                $(this).parent().find('.icon-display').attr('class', 'file-icon mdi mdi-close-circle-outline text-danger icon-display')
            }

            $(this).parent().find('.update-status').remove()
        } else {

        }
    })
</script>
@endsection