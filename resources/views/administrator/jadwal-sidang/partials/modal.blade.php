<!-- sample modal content -->
<div id="modalDaftarSidang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="daftarSidangLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="daftarSidangLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="daftarSidangAction" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if ($item->status == 'belum_daftar')
                        @foreach ($document_sidang->where('jenis', 'pra_sidang') as $key => $doc)
                            @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                            <div class="d-flex align-items-center gap-2 mb-3 " id="document{{ $doc->id }}">
                                @if ($document)
                                    <i class="file-icon bx bx-check-circle text-success"></i>
                                @else
                                    <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                                @endif
                                <div class="w-100 fw-bold text-start">
                                    {{ ucwords(strtolower($doc->nama)) }}
                                    @if ($document)
                                        <p class="file-desc text-muted small m-0 p-0"><a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" target="_blank">Lihat berkas</a></p>
                                    @else
                                        <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum ada berkas</p>
                                    @endif
                                </div>
                                <label for="file{{ $doc->id }}">
                                    <input type="file" id="file{{ $doc->id }}" onchange="changeFile('#document{{ $doc->id }}')"
                                        name="document_{{ $doc->id }}" class="d-none"  accept=".pdf" >
                                    @if ($document)
                                        <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                    @else
                                        <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    @else
                        @foreach ($document_sidang->where('jenis', 'sidang') as $key => $doc)
                            @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                            <div class="d-flex align-items-center gap-2 mb-3 " id="document{{ $doc->id }}">
                                @if ($document)
                                    <i class="file-icon bx bx-check-circle text-success"></i>
                                @else
                                    <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                                @endif
                                <div class="w-100 fw-bold text-start">
                                    {{ ucwords(strtolower($doc->nama)) }}
                                    @if ($document)
                                        <p class="file-desc text-muted small m-0 p-0"><a
                                                href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}"
                                                target="_blank">Lihat berkas</a></p>
                                    @else
                                        <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>)
                                            Belum ada berkas</p>
                                    @endif
                                </div>
                                <label for="file{{ $doc->id }}">
                                    <input type="file" id="file{{ $doc->id }}" onchange="changeFile('#document{{ $doc->id }}')"
                                        name="document_{{ $doc->id }}" class="d-none"  accept=".pdf" >
                                    @if ($document)
                                        <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                    @else
                                        <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalValidasiFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="validasiFileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="validasiFileAction" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="validasiFileLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{dd($data)}}
                    @if($data->status == 'sudah_daftar')
                        @foreach ($document_sidang->where('jenis', 'pra_sidang') as $key => $doc)
                            @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                            <div class="col-md-4 col-sm-6 col-12 border p-3" style="position: relative">
                                <div class="d-block text-center fw-bold" style="height: calc(100% - 115px);">{{ ucwords(strtolower($doc->nama)) }}</div>
                                <div class="d-flex align-items-center justify-content-center my-3" style="height: 50px">
                                    @if($document)
                                        <i class="fa fa-file-pdf text-danger fa-3x"></i>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if($document)
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" class="btn btn-secondary btn-sm" target="_blank">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @elseif($data->status == 'sudah sidang')
                        @foreach ($document_sidang->where('jenis', 'sidang') as $key => $doc)
                            @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                            <div class="col-md-4 col-sm-6 col-12 border p-3" style="position: relative">
                                <div class="d-block text-center fw-bold" style="height: calc(100% - 115px);">{{ ucwords(strtolower($doc->nama)) }}</div>
                                <div class="d-flex align-items-center justify-content-center my-3" style="height: 50px">
                                    @if($document)
                                        <i class="fa fa-file-pdf text-danger fa-3x"></i>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if($document)
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" class="btn btn-secondary btn-sm" target="_blank">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{-- @foreach ($document_sidang->where('jenis', 'pra_sidang') as $key => $doc)
                    @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document{{ $doc->id }}">
                            @if ($document)
                                @if (is_null($document->status))
                                <i class="file-icon mdi mdi-alert-circle-outline text-warning icon-display"></i>
                                @elseif($document->status == 'valid')
                                <i class="file-icon bx bx-check-circle text-success icon-display"></i>
                                @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger icon-display"></i>
                                @endif
                            @else
                            <i class="file-icon mdi mdi-close-circle-outline text-danger icon-display"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                {{ ucwords(strtolower($doc->nama)) }}
                                @if ($document)
                                <p class="file-desc text-muted small m-0 p-0"><a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" target="_blank">Lihat berkas</a></p>
                                @else
                                <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum ada berkas</p>
                                @endif
                            </div>
                            <label for="file{{ $doc->id }}">
                                <input type="text" id="file{{ $doc->id }}" onchange="changeFile('#document{{ $doc->id }}')"
                                    name="document_{{ $doc->id }}" class="d-none">
                            </label>
                            @if(!is_null($document) && is_null($document->status))
                                <a href="{{ route('apps.jadwal-sidang.validasi-berkas', $document->id) }}" class="file-btn btn btn-outline-success btn-sm update-status"><i class="bx bx-check"></i></a>
                                <a href="{{ route('apps.jadwal-sidang.reject', $document->id) }}" class="file-btn btn btn-outline-danger btn-sm update-status"><i class="bx bx-x"></i></a>
                            @endif
                        </div>
                    @endforeach --}}
                </div>
                @if($item->status == 'sudah_sidang')
                <div class="modal-footer">
                    <button class="btn btn-outline-success waves-effect">Berkas Lengkap</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
