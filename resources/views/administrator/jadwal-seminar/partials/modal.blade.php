<div class="modal fade" id="myModalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="myUploadFileSeminar" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabelUploadFile">Unggah Berkas Pendaftaran Seminar</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Formulir Pemenuhan Persyaratan TA</label>
                                <input type="file" name="pemenuhan_persyaratan_ta" class="form-control filepond">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="">Scan KHS Semester 1-7</label>
                            <input type="file" name="KHS_sem_1_7" class="form-control filepond">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="">Bukti Heregrestrasi Semester 7</label>
                            <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                        </div>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabelUploadFile">Unggah Berkas Pasca Seminar</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Jadwal Seminar Proposal</label>
                                <input type="file" name="pemenuhan_persyaratan_ta" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Formulir Pengantar Pengambilan Data</label>
                                <input type="file" name="KHS_sem_1_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Daftar Hadir Peserta Seminar Proposal</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Bukti Dukung Dari Mitra</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Berita Acara</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Lembar Penilaian</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Rekapitulasi Nilai</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Formulir Revisi Penguji 1 & 2</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="">Lembar Pengesahan</label>
                                <input type="file" name="heregrestrasi_sem_7" class="form-control filepond">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waver-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>