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
                    @if ($item->status == 'belum_terjadwal')
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
