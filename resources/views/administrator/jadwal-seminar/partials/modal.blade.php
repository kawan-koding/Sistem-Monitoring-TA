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
                        @php $document = $documents->where('nama', 'pemenuhan_persyaratan_ta')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document1">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Formulir Pemenuhan Persyaratan Seminar Proposal
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file1">
                                <input type="file" id="file1" onchange="changeFile('#document1')"
                                    name="pemenuhan_persyaratan_ta" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'scan_khs_sem_1_7')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3" id="document2">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Scan KHS Semester 1 - 7
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file2">
                                <input type="file" id="file2" onchange="changeFile('#document2')"
                                    name="scan_khs_sem_1_7" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'bukti_heregistrasi_semester_7')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document3">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Bukti Heregrestrasi Semester 7
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file3">
                                <input type="file" id="file3" onchange="changeFile('#document3')"
                                    name="bukti_heregistrasi_semester_7" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                    @else
                        @php $document = $documents->where('nama', 'jadwal_seminar_proposal')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document4">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Jadwal Seminar Proposal
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file4">
                                <input type="file" id="file4" onchange="changeFile('#document4')"
                                    name="jadwal_seminar_proposal" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'formulir_pengantar_pengambilan_data')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document5">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Formulir Pengantar Pengambilan Data
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file5">
                                <input type="file" id="file5" onchange="changeFile('#document5')"
                                    name="formulir_pengantar_pengambilan_data" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'daftar_hadir_peserta_seminar_proposal')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document6">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Daftar Hadir Peserta Seminar Proposal
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file6">
                                <input type="file" id="file6" onchange="changeFile('#document6')"
                                    name="daftar_hadir_peserta_seminar_proposal" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'bukti_dukung_dari_mitra')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document7">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Bukti Dukung Dari Mitra
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file7">
                                <input type="file" id="file7" onchange="changeFile('#document7')"
                                    name="bukti_dukung_dari_mitra" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'berita_acara')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document8">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Berita Acara
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file8">
                                <input type="file" id="file8" onchange="changeFile('#document8')"
                                    name="berita_acara" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'lembar_penilaian')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document9">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Lembar Penilaian
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file9">
                                <input type="file" id="file9" onchange="changeFile('#document9')"
                                    name="lembar_penilaian" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'rekapitulasi_nilai')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document10">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Rekapitulasi Nilai
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file10">
                                <input type="file" id="file10" onchange="changeFile('#document10')"
                                    name="rekapitulasi_nilai" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'formulir_revisi_penguji')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document11">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Formulir Revisi Penguji 1 & 2
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file11">
                                <input type="file" id="file11" onchange="changeFile('#document11')"
                                    name="formulir_revisi_penguji" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                        @php $document = $documents->where('nama', 'lembar_pengesahan')->first(); @endphp
                        <div class="d-flex align-items-center gap-2 mb-3 " id="document12">
                            @if ($document)
                                <i class="file-icon bx bx-check-circle text-success"></i>
                            @else
                                <i class="file-icon mdi mdi-close-circle-outline text-danger"></i>
                            @endif
                            <div class="w-100 fw-bold text-start">
                                Lembar Pengesahan
                                @if ($document)
                                    <p class="file-desc text-muted small m-0 p-0"><a
                                            href="{{ asset('storage/files/documents/' . $document->file) }}"
                                            target="_blank">Lihat berkas</a></p>
                                @else
                                    <p class="file-desc text-muted small m-0 p-0"><i class="text-danger">*</i>) Belum
                                        ada berkas</p>
                                @endif
                            </div>
                            <label for="file12">
                                <input type="file" id="file12" onchange="changeFile('#document12')"
                                    name="lembar_pengesahan" class="d-none">
                                @if ($document)
                                    <div class="file-btn btn btn-outline-primary btn-sm">Perbarui</div>
                                @else
                                    <div class="file-btn btn btn-outline-primary btn-sm">Unggah</div>
                                @endif
                            </label>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waver-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
