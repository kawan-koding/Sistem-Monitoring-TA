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
                        </div>
                    @endif
                    <form action="">
                        @can('create-pengajuan-tugas-akhir')
                            @if (!$dataTA->whereNotIn('status', ['reject','cancel'])->count() > 0 || $dataTA->count() == 0)
                                <a href="{{ route('apps.pengajuan-ta.create') }}" class="btn btn-primary mb-2"><i class="fa fa-upload me-1"></i> Ajukan TA</a>
                            @endif
                        @endcan
                        <a href="{{ getSetting('app_template_mentor') }}" target="_blank" class="btn btn-success mb-2"><i
                                class="far fa-file-alt"></i> Template Persetujuan Pembimbing</a>
                        <a href="{{ getSetting('app_template_summary') }}" target="_blank" class="btn btn-secondary mb-2"><i
                            class="far fa-file-alt"></i> Template Ringkasan</a>
                        @if(getInfoLogin()->hasRole('Kaprodi'))
                        <div class="d-flex align-items-center gap-2 float-end col-5" style="white-space: nowrap"> 
                            <label for="">Filter Berdasarkan: </label>
                            <select name="filter" id="" class="form-control" onchange="this.form.submit()">
                                <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>Semua Jenis Penyelesaian</option>
                                <option value="I" {{ $filter == 'I' ? 'selected' : '' }}>Individu</option>
                                <option value="K" {{ $filter == 'K' ? 'selected' : '' }}>Kelompok</option>
                            </select>
                            <select name="filter2" id="" class="form-control" onchange="this.form.submit()">
                                <option value="semua" {{ $filter2 == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="draft" {{ $filter2 == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="acc" {{ $filter2 == 'acc' ? 'selected' : '' }}>Acc</option>
                            </select>
                        </div>
                        @endif
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th min-width="250px">Judul</th>
                                    @if(!getInfoLogin()->hasRole('Mahasiswa'))
                                    <th>Mahasiswa</th>
                                    @endif
                                    <th min-width="200px">Dosen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @forelse ($dataTA as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-soft-primary small mb-1 fw-bold">{{ $item->tipe == 'I' ? 'Individu' : 'Kelompok' }}</span>
                                                <h5 class="fw-bold small m-0">{{ $item->judul }}</h5>
                                                <p class="m-0 text-muted small">{{ $item->topik->nama_topik }} -
                                                    {{ $item->jenis_ta->nama_jenis }}</p>
                                                @if($item->catatan != null)                                                    
                                                    <p class="m-0 text-muted small">Catatan : <span class="text-danger">{{ $item->catatan ?? '-' }}</span></p>
                                                @endif
                                            </td>
                                            @if(!getInfoLogin()->hasRole('Mahasiswa'))
                                            <td> <p class="small">{{$item->mahasiswa->nama_mhs}}</p></td> 
                                            @endif
                                            <td>
                                                <p class="small fw-bold m-0">Pembimbing</p>
                                                <ol>
                                                    @for ($i = 0; $i < 2; $i++)
                                                        @if ($item->bimbing_uji()->where('jenis', 'pembimbing')->count() > $i)
                                                            @foreach ($item->bimbing_uji as $pemb)
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
                                                <p class="small fw-bold m-0">Penguji</p>
                                                <ol>
                                                    @for ($i = 0; $i < 2; $i++)
                                                        @if ($item->bimbing_uji()->where('jenis', 'penguji')->count() > $i)    
                                                            @foreach ($item->bimbing_uji as $pemb)
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
                                                @if ($item->status == 'acc')
                                                    <span
                                                        class='badge sm rounded-pill badge-soft-primary font-size-11'>{{ ucfirst($item->status) }}</span>
                                                @else
                                                    @if ($item->status == 'reject')
                                                        <span
                                                            class='badge small rounded-pill badge-soft-danger font-size-11'>{{ ucfirst($item->status) }}</span>
                                                    @else
                                                        <span
                                                            class='badge small rounded-pill badge-soft-secondary font-size-11'>{{ ucfirst($item->status) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="mb-3">
                                                @if (getInfoLogin()->hasRole('Kaprodi'))
                                                    @if ($item->status == 'draft')
                                                        @can('acc-pengajuan-tugas-akhir')
                                                            <button
                                                                onclick="acceptTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.accept', $item->id) }}')"
                                                                class="btn btn-outline-primary btn-sm mx-1 my-1"
                                                                title="Acc"><i class="bx bx-check-double"></i></button>
                                                        @endcan
                                                        <button
                                                            onclick="rejectTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.reject', $item->id) }}')"
                                                            class="btn btn-outline-danger btn-sm mx-1 my-1"
                                                            title="Reject"><i class="bx bx-x"></i></button>
                                                    @endif
                                                @endif
                                                @if (getInfoLogin()->hasRole('Mahasiswa'))
                                                    @if($item->status !== 'cancel')
                                                    @can('update-pengajuan-tugas-akhir')
                                                        <a href="{{ route('apps.pengajuan-ta.edit', ['pengajuanTA' => $item->id]) }}"
                                                            class="btn btn-sm btn-outline-primary my-1 mx-1" title="Edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                    @endcan
                                                    @endif
                                                    {{-- @if($item->bimbing_uji()->where('jenis', 'pembimbing')->where('urut', 2)->count() > 0 && $item->status == 'acc')
                                                    <button
                                                        onclick="uploadFile('{{ $item->id }}','{{ route('apps.pengajuan-ta.unggah-berkas', $item->id) }}')"
                                                        class="btn btn-sm btn-outline-secondary unggah-berkas mx-1 my-1"
                                                        title="Unggah Berkas Pembimbing 2"><i class="bx bx-file"></i></button>
                                                    @endif --}}
                                                @endif
                                                <a href="{{ route('apps.pengajuan-ta.show', ['pengajuanTA' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-warning mx-1 my-1" title="Detail"><i
                                                        class="bx bx-show"></i></a>
                                                @can('cancel-pengajuan-tugas-akhir')
                                                @if($item->status == 'acc')
                                                <button
                                                    onclick="cancelTA('{{ $item->id }}', '{{ route('apps.pengajuan-ta.cancel', $item->id) }}')"
                                                    class="btn btn-sm btn-outline-danger mx-1 my-1"
                                                    title="Batalkan Tugas Akhir"><i class="bx bxs-no-entry"></i></button>
                                                @endif
                                                @endcan
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
        </div>
    </div>

    {{-- modal unggah berkas --}}
    {{-- <div id="myModalUploadFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                            <label for="">Dokumen Pembimbing 2</label>
                            <input type="file" name="dokumen_pemb_2" class="form-control filepond">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

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
                            <i>Silahkan tuliskan catatan (opsional):</i>
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
