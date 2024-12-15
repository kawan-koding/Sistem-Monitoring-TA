<!-- sample modal content -->
<div id="modalDaftarSidang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="daftarSidangLabel"
    aria-hidden="true">
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
                            @php
                                $document = $doc
                                    ->pemberkasan()
                                    ->where('tugas_akhir_id', $item->tugas_akhir->id)
                                    ->first();
                            @endphp
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
                                    <input type="file" id="file{{ $doc->id }}"
                                        onchange="changeFile('#document{{ $doc->id }}')"
                                        name="document_{{ $doc->id }}" class="d-none" accept="{{ $doc->tipe_dokumen == 'pdf' ? '.pdf' : 'image/*' }}">
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
                            @php
                                $document = $doc
                                    ->pemberkasan()
                                    ->where('tugas_akhir_id', $item->tugas_akhir->id)
                                    ->first();
                            @endphp
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
                                    <input type="file" id="file{{ $doc->id }}"
                                        onchange="changeFile('#document{{ $doc->id }}')"
                                        name="document_{{ $doc->id }}" class="d-none" accept="{{ $doc->tipe_dokumen == 'pdf' ? '.pdf' : 'image/*' }}">
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

<div id="modalValidasiFile" class="modal fade" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="validasiFileAction" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    @if($item->status == 'sudah_daftar')
                        <h5 class="modal-title mt-0">Validasi Berkas Pendaftaran Sidang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @else
                        <h5 class="modal-title mt-0">Validasi Berkas Sidang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <div class="modal-body">
                    @if ($item->status == 'belum_daftar' || $item->status == 'sudah_daftar' || $item->status == 'sudah_terjadwal')
                    <div class="row">
                        @foreach ($document_sidang->where('jenis', 'pra_sidang') as $key => $doc)
                            @php
                                $document = $doc
                                    ->pemberkasan()
                                    ->where('tugas_akhir_id', $item->tugas_akhir->id)
                                    ->first();
                            @endphp
                            <div class="col-md-4 col-sm-6 col-12 border p-3" style="position: relative">
                                <div class="d-block text-center fw-bold" style="height: calc(100% - 115px);">
                                    {{ ucwords(strtolower($doc->nama)) }}</div>
                                <div class="d-flex align-items-center justify-content-center my-3" style="height: 50px">
                                    @if ($document)
                                        <i class="fa fa-file-pdf text-danger fa-3x"></i>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if ($document)
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}"
                                            class="btn btn-secondary btn-sm" target="_blank">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="row">
                        @foreach ($document_sidang->where('jenis', 'sidang') as $key => $doc)
                            @php
                                $document = $doc
                                    ->pemberkasan()
                                    ->where('tugas_akhir_id', $item->tugas_akhir->id)
                                    ->first();
                            @endphp
                            <div class="col-md-4 col-sm-6 col-12 border p-3" style="position: relative">
                                <div class="d-block text-center fw-bold" style="height: calc(100% - 115px);">
                                    {{ ucwords(strtolower($doc->nama)) }}</div>
                                <div class="d-flex align-items-center justify-content-center my-3" style="height: 50px">
                                    @if ($document)
                                        <i class="fa fa-file-pdf text-danger fa-3x"></i>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if ($document)
                                        <a href="{{ asset('storage/files/pemberkasan/' . $document->filename) }}"
                                            class="btn btn-secondary btn-sm" target="_blank">Lihat Berkas</a>
                                    @else
                                        <i class="text-danger">*</i>) Belum ada berkas
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @if($item->status == 'sudah_terjadwal' || $item->status == 'sudah_sidang')
                    <div class="modal-footer">
                        <button class="btn btn-outline-success waves-effect"> <i class="fa fa-check-circle"></i> Berkas Lengkap</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal{{$item->id}}">
    <div class="modal-dialog text-start">
        <div class="modal-content">
            <form action="{{ route('apps.jadwal-sidang.update-status', $item->tugas_akhir->sidang->id) }}" method="POST">
                @csrf
                <div class="modal-header d-block">
                    <h5 class="mb-0">Update status sidang akhir</h5>
                    <p class="text-muted small mb-0">Berikan keputusan terkait status sidang akhir</p>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Status Sidang Akhir <span class="text-danger">*</span></label><br>
                        <label for="acc{{$item->id}}" class="me-2"><input type="radio" name="status" id="acc{{$item->id}}" value="acc" {{$item->tugas_akhir->status_sidang == 'acc' ? 'checked' : ''}}> Setujui</label>
                        <label for="revisi{{$item->id}}" class="me-2"><input type="radio" name="status" id="revisi{{$item->id}}" value="revisi" {{$item->tugas_akhir->status_sidang == 'revisi' ? 'checked' : ''}}> Disetujui dengan revisi</label>
                        <label for="reject{{$item->id}}" class="me-2"><input type="radio" name="status" id="reject{{$item->id}}" value="reject" {{$item->tugas_akhir->status_sidang == 'reject' ? 'checked' : ''}}> Ditolak</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
