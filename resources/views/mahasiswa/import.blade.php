<!-- sample modal content -->
<div id="myModalImport" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabelImport">Import
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="" enctype="multipart/form-data" id="myImportFormulir" method="post">
            @csrf
            <div class="modal-body">
                <a href="{{asset('Mahasiswa-Excel.xlsx')}}" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Template</a>
                <hr>
                <div>
                    <label for="">File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                    <span class="text-danger">*csv,xls,xlsx</span>
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
