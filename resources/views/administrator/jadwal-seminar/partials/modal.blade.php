<div class="modal fade" id="myModalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="myUploadFileSeminar" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    @if ($item->status == 'belum_terjadwal')
                        <h5 class="modal-title mt-0" id="myModalLabelUploadFile">Unggah Berkas Pendaftaran Seminar
                            Proposal
                        </h5>
                    @else
                        <h5 class="modal-title mt-0" id="myModalLabelUploadFile">Unggah Berkas Paska Seminar Proposal
                        </h5>
                    @endif
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body" style="position: relative">
                    @if ($item->status == 'belum_terjadwal')
                        @foreach ($document_seminar->where('jenis', 'pra_seminar') as $key => $doc)
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
                                        name="document_{{ $doc->id }}" class="d-none"  accept="{{ $doc->tipe_dokumen == 'pdf' ? '.pdf' : 'image/*' }}" >
                                    @if ($document)
                                        <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                    @else
                                        <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    @else
                        @foreach ($document_seminar->where('jenis', 'seminar') as $key => $doc)
                            @php $document = $doc->pemberkasan()->where('tugas_akhir_id', $item->tugas_akhir->id)->first(); @endphp
                            <div class="d-flex align-items-center gap-2 mb-3 " id="document{{ $doc->id }}">
                                @if ($document)
                                    <i class="file-icon bx bx-check-circle text-success"></i>
                                @else
                                    <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                                @endif
                                <div class="w-100 fw-bold text-start">
                                    {{ ucwords(strtolower($doc->nama)) }}
                                    @if($doc->tipe_dokumen == 'gambar')
                                        <p class="fw-normal small mb-0">(Berkas harus berupa JPG/JPEG/PNG)</p>
                                    @endif
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
                    <button type="submit" class="btn btn-primary waver-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalValidasiFile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="validasiFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="validasiFileAction" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title mt-0"> Validasi Berkas Seminar Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <h5 class="fw-bold">1. Berkas Pendaftaran Seminar</h5>
                    <div class="row">
                        @foreach ($document_seminar->where('jenis', 'pra_seminar') as $key => $doc)
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
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" class="btn btn-secondary btn-sm">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br><br>
                    <h5 class="fw-bold">2. Berkas Seminar</h5>
                    <div class="row">
                        @foreach ($document_seminar->where('jenis', 'seminar') as $key => $doc)
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
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}" class="btn btn-secondary btn-sm">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if($item->status == 'telah_seminar' && $item->tugas_akhir->status_pemberkasan != 'sudah_lengkap')
                    <div class="modal-footer">
                        <button class="btn btn-outline-success waves-effect"> <i class="fa fa-check-circle"></i> Berkas Lengkap</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>