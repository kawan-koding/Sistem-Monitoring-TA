<div id="myModalApply" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabelApply"></h5>
            </div>
            <form action="" id="myImportFormulir" method="post">
                @csrf
                <div class="modal-body">
                    <div>
                        <label for="">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                        <i><span class="text-danger small">*Jelaskan bidang keahlian anda secara singkat</span></i>
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
</div>