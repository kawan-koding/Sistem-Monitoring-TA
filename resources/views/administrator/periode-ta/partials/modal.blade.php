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
                    <label for="">Periode <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Mulai Daftar</label>
                            <input type="date" name="mulai_daftar" id="mulai_daftar" class="form-control">
                            <input type="hidden" name="id" id="idPeriode">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Akhir Daftar</label>
                            <input type="date" name="akhir_daftar" id="akhir_daftar" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Mulai Seminar</label>
                            <input type="date" name="mulai_seminar" id="mulai_seminar" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Akhir Seminar</label>
                            <input type="date" name="akhir_seminar" id="akhir_seminar" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Mulai Sidang</label>
                            <input type="date" name="mulai_sidang" id="mulai_sidang" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Akhir Sidang</label>
                            <input type="date" name="akhir_sidang" id="akhir_sidang" class="form-control">
                        </div>
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
