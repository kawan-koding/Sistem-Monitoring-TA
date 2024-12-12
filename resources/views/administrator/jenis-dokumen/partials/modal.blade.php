<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel"></h5>
        </div>
        <form action="" id="myFormulir" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Nama Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" placeholder="Nama dokumen" autocomplete="off" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option value="" selected disabled hidden>Pilih Jenis Dokumen</option>
                        <option value="pra_seminar">Pra Seminar</option>
                        <option value="seminar">Seminar</option>
                        <option value="pra_sidang">Pra Sidang</option>
                        <option value="sidang">Sidang</option>
                        <option value="pendaftaran">Pendaftaran</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Tipe Dokumen <span class="text-danger">*</span></label>
                    <select name="tipe_dokumen" id="tipe_dokumen" class="form-control">
                        <option value="" selected disabled hidden>Pilih Tipe Dokumen</option>
                        <option value="pdf">PDF</option>
                        <option value="gambar">GAMBAR</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Maks. Ukuran</label>
                    <div class="input-group">
                        <input class="input form-control" name="max_ukuran" id="max_ukuran" placeholder="Maks. Ukuran" value="5120">
                        <div class="input-group-append">
                            <span class="input-group-text">KB</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
