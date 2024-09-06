<!-- sample modal content -->
<div id="myUnggahModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">Unggah Berkas
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="" id="myFormulir" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                @if ($timer != 'selesai')
                <div>
                    <label for="">Persetujuan Pembimbing 2</label>
                    <input type="file" name="file_persetujuan_pemb_2" id="file_persetujuan_pemb_2" class="form-control">
                    @if ($errors->has('file_persetujuan_pemb_2'))
                        <span class="text-danger">{{ $errors->first('file_persetujuan_pemb_2') }}</span>
                    @endif
                </div>
                @endif
                @if ($timer == 'selesai')
                <div>
                    <label for="">File Pengesahan</label>
                    <input type="file" name="pengesahan" id="pengesahan" class="form-control">
                    @if ($errors->has('pengesahan'))
                        <span class="text-danger">{{ $errors->first('pengesahan') }}</span>
                    @endif
                </div>
                @endif
                <div>
                    <label for="">File Proposal</label>
                    <input type="file" name="proposal" id="proposal" class="form-control">
                    @if ($errors->has('proposal'))
                        <span class="text-danger">{{ $errors->first('proposal') }}</span>
                    @endif
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
