@extends('administrator.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-g-12">
            <div class="card">
                <div class="card-body">
                    {{-- @if (!isset($dataTA[0]['id'])) --}}
                    {{-- <a href="{{route('mahasiswa.pengajuan-ta.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a> --}}
                    {{-- <hr> --}}
                    {{-- @endif --}}
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
                    @can('create-pengajuan-tugas-akhir')
                        @if ($dataTA->whereIn('status', ['reject','cancel'])->count() > 0 || $dataTA->count() == 0)
                            <a href="{{ route('apps.pengajuan-ta.create') }}" class="btn btn-primary mb-2"><i
                                    class="fa fa-plus"></i> Tambah</a>
                        @endif
                    @endcan
                    <a href="{{ getSetting('app_template_mentor_one') }}" target="_blank" class="btn btn-success mb-2"><i
                            class="far fa-file-alt"></i> Template Persetujuan Pemb 1</a>
                    <a href="{{ getSetting('app_template_summary') }}" target="_blank" class="btn btn-secondary mb-2"><i
                            class="far fa-file-alt"></i> Template Ringkasan</a>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th min-width="250px">Judul</th>
                                    <th>Mahasiswa</th>
                                    {{-- <th>Topik</th> --}}
                                    <th min-width="200px">Dosen</th>
                                    <th>Status</th>
                                    {{-- <th min-width="200px">Catatan</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($dataTA->count() > 0)
                                    @foreach ($dataTA as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-soft-primary small mb-1 fw-bold">{{ $item->tipe == 'I' ? 'Individu' : 'Kelompok' }}</span>
                                                <h5 class="fw-bold m-0">{{ $item->judul }}</h5>
                                                <p class="m-0 text-muted small">{{ $item->topik->nama_topik }} -
                                                    {{ $item->jenis_ta->nama_jenis }}</p>
                                                <p class="m-0 text-muted small">Catatan : {{ $item->catatan ?? '-' }}</p>
                                            </td>
                                            <td>{{$item->mahasiswa->nama_mhs}}</td> 
                                            <td>
                                                <strong>Pembimbing</strong>
                                                <ol>
                                                    @for ($i = 0; $i < 2; $i++)
                                                        @if ($item->bimbing_uji()->where('jenis', 'pembimbing')->count() > $i)
                                                            @foreach ($item->bimbing_uji as $pemb)
                                                                @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 1 && $i == 0)
                                                                    <li>{{ $pemb->dosen->name ?? '-' }}</li>
                                                                @endif
                                                                @if ($pemb->jenis == 'pembimbing' && $pemb->urut == 2 && $i == 1)
                                                                    <li>{{ $pemb->dosen->name ?? '-' }}</li>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <li>-</li>
                                                        @endif
                                                    @endfor
                                                </ol>
                                                <strong>Penguji</strong>
                                                <ol>
                                                    @for ($i = 0; $i < 2; $i++)
                                                        @if ($item->bimbing_uji()->where('jenis', 'penguji')->count() > $i)    
                                                            @foreach ($item->bimbing_uji as $pemb)
                                                                @if ($pemb->jenis == 'penguji' && $pemb->urut == 1 && $i == 0)
                                                                    <li>{{ $pemb->dosen->name ?? '-' }}</li>
                                                                @endif
                                                                @if ($pemb->jenis == 'penguji' && $pemb->urut == 2 && $i == 1)
                                                                    <li>{{ $pemb->dosen->name ?? '-' }}</li>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <li>-</li>
                                                        @endif
                                                    @endfor
                                                </ol>
                                            </td>
                                            <td>
                                                @if ($item->status == 'acc')
                                                    <span
                                                        class='badge rounded-pill badge-soft-primary font-size-11'>{{ ucfirst($item->status) }}</span>
                                                @else
                                                    @if ($item->status == 'reject')
                                                        <span
                                                            class='badge rounded-pill badge-soft-danger font-size-11'>{{ ucfirst($item->status) }}</span>
                                                    @else
                                                        <span
                                                            class='badge rounded-pill badge-soft-secondary font-size-11'>{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- <td>{{$item->catatan}}</td> --}}
                                            <td class="mb-3">
                                                @if (getInfoLogin()->hasRole('Kaprodi'))
                                                    @if ($item->status == 'draft')
                                                        @can('acc-pengajuan-tugas-akhir')
                                                            <a href="javascript:void(0);"
                                                                onclick="acceptTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.accept', $item->id) }}')"
                                                                class="btn btn-outline-primary btn-sm mx-1 my-1"
                                                                title="Acc"><i class="bx bx-check-double"></i></a>
                                                        @endcan
                                                        <a href="javascript:void(0);"
                                                            onclick="rejectTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.reject', $item->id) }}')"
                                                            class="btn btn-outline-danger btn-sm mx-1 my-1"
                                                            title="Reject"><i class="bx bx-x"></i></a>
                                                    @endif
                                                @endif
                                                @if (getInfoLogin()->hasRole('Mahasiswa'))
                                                    @can('update-pengajuan-tugas-akhir')
                                                        <a href="{{ route('apps.pengajuan-ta.edit', ['pengajuanTA' => $item->id]) }}"
                                                            class="btn btn-sm btn-outline-primary my-1 mx-1" title="Edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                    @endcan
                                                    <a href="javascript:void(0);"
                                                        onclick="uploadFile('{{ $item->id }}','{{ route('apps.pengajuan-ta.unggah-berkas', $item->id) }}')"
                                                        class="btn btn-sm btn-outline-secondary unggah-berkas mx-1 my-1"
                                                        title="Unggah Berkas"><i class="far fa-file-alt"></i></a>
                                                @endif
                                                <a href="{{ route('apps.pengajuan-ta.show', ['pengajuanTA' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-warning mx-1 my-1" title="Detail"><i
                                                        class="bx bx-show"></i></a>
                                                @can('cancel-pengajuan-tugas-akhir')    
                                                <a href= "javascript:void(0);"
                                                    onclick="cancelTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.cancel', $item->id) }}')"
                                                    class="btn btn-sm btn-outline-danger mx-1 my-1"
                                                    title="Batalkan Tugas Akhir"><i class="bx bxs-no-entry"></i></a>
                                                @endcan

                                                {{-- @if ($timer == 'selesai') --}}

                                                {{-- <a href="{{route('apps.pengajuan-ta.print_nilai', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Nilai"><i class="fas fa-file-alt"></i></a>
                                    <a href="{{route('apps.pengajuan-ta.print_rekap', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Rekapitulasi"><i class="far fa-file-alt"></i></a>
                                    <a href="{{route('apps.pengajuan-ta.print_revisi', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Revisi"><i class="fas fa-file-invoice"></i></a> --}}
                                                {{-- @endif --}}
                                                {{-- @if (isset($item_pemb_1))
                                    <a href="{{route('apps.pengajuan-ta.print_pemb1', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Print Persetujuan Dosen"><i class="fas fa-file-invoice"></i></a>
                                    @endif
                                    @if (isset($item_pemb_2))
                                    <a href="{{route('apps.pengajuan-ta.print_pemb2', ['id' => $item->id])}}" class="btn btn-sm btn-success mb-3" title="Print Persetujuan Dosen"><i class="fas fa-file-invoice"></i></a>
                                    @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="7">No data available in table</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal unggah berkas --}}
    <div id="myModalUploadFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-tile mt-0" id="myModalLabelUploadFile">Unggah Berkas</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="" id="myUploadFile" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">File Pengesahan</label>
                            <input type="file" name="file_pengesahan" class="form-control filepond">
                        </div>
                        <div class="mb-3">
                            <label for="">File Proposal</label>
                            <input type="file" name="file_proposal" class="form-control filepond">
                        </div>
                        <div class="mb-3">
                            <label for="">Dokumen Pembimbing 2</label>
                            <input type="file" name="dokumen_pemb_2" class="form-control filepond">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">Keluar</button> --}}
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal acc TA and reject TA --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalAccLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Catatan</label>
                            <textarea name="catatan" class="form-control"></textarea>
                            <i>Silahkan tuliskan catatan anda (opsional):</i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
