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
        <form action="" id="myFormulir" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Key </label>
                    <input type="text" name="key" id="key" placeholder="Kode" class="form-control" disabled autocomplete="off">
                </div>
                <div class="mb-3" id="general">
                    <label for="">Value <span class="text-danger">*</span></label>
                    <input type="text" name="value" id="value" autocomplete="off"  class="form-control">
                </div>
                <div class="mb-3" id="file">
                    <label for="">Value <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="file" autocomplete="off"  class="form-control filepond">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
