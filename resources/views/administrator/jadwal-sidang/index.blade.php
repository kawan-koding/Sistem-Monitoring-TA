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

            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th width="40%">Judul</th>
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
                                            class="badge small mb-1 {{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'badge-soft-success' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'badge-soft-success' : 'badge-soft-danger')) : '' }}">{{ !is_null($item->tugas_akhir->status_seminar) ? ($item->tugas_akhir->status_seminar == 'acc' ? 'Disetujui' : ($item->tugas_akhir->status_seminar == 'revisi' ? 'Disetujui dengan revisi' : 'Ditolak')) : 'Belum Seminar' }}</span>
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
                                        <p style="white-space: nowrap" class="font-size-12 {{ $item->document_complete ? 'badge badge-soft-success text-success' : 'badge badge-soft-danger text-danger' }}">{{ $item->document_complete ? 'Berkas sudah lengkap' : 'Berkas belum lengkap' }}</p>
                                    </td>
                                @endif
                                <td class="mb-3 text-center">
                                    @if (getInfoLogin()->hasRole('Mahasiswa'))
                                        <a href="{{ route('apps.jadwal-seminar.detail', $item->id) }}" class="btn btn-sm btn-outline-primary my-1"><i class="bx bx-show" title="Detail"></i></a>
                                        @if($item->status == 'belum_terjadwal')
                                            <a href="javascript:void(0);" onclick="daftarSidang('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>
                                                Daftar
                                            </a>
                                            @else 
                                            <a href="javascript:void(0);" onclick="unggahFile('{{ $item->id }}', '{{ route('apps.jadwal-seminar.unggah-berkas', $item->id) }}')" class="btn btn-sm btn-outline-dark"><i class="bx bx-file"></i>
                                                Unggah
                                            </a>
                                        @endif
                                        @include('administrator.jadwal-sidang.partials.modal')
                                    @endif
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
    </script>
    @endsection
    
@endsection