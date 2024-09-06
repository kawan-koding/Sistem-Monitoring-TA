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
                <div>
                    <label for="">Nama Periode <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div>
                    <label for="">Mulai Daftar <span class="text-danger">*</span></label>
                    <input type="date" name="mulai_daftar" id="mulai_daftar" class="form-control" required>
                    <input type="hidden" name="id" id="idPeriode">
                </div>
                <div>
                    <label for="">Akhir Daftar <span class="text-danger">*</span></label>
                    <input type="date" name="akhir_daftar" id="akhir_daftar" class="form-control" required>
                </div>
                <div>
                    <label for="">Mulai Seminar <span class="text-danger">*</span></label>
                    <input type="date" name="mulai_seminar" id="mulai_seminar" class="form-control" required>
                </div>
                <div>
                    <label for="">Akhir Seminar <span class="text-danger">*</span></label>
                    <input type="date" name="akhir_seminar" id="akhir_seminar" class="form-control" required>
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
