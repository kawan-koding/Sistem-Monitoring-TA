<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="" id="myFormulir" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">Kelas <span class="text-danger">*</span></label>
                        <input type="text" name="kelas" id="kelas" class="form-control" required>
                        <input type="hidden" name="id" id="idMhs">
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" id="nim" class="form-control" required>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama_mhs" id="nama_mhs" class="form-control" required>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="form-control">
                            <option value="">Pilih</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                        <label for="">Telp <span class="text-danger">*</span></label>
                        <input type="text" name="telp" id="telp" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                    data-bs-dismiss="modal">Keluar</button>
                <button type="submit"
                    class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->