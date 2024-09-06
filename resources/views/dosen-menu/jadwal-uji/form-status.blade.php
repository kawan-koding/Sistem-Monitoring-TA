<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="myModalLabel">Ubah Status
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <form action="{{route('dosen.jadwal-uji.status-update')}}" method="post">
            @csrf
            <div class="modal-body">
                <div>
                    {{-- STATUS BERITA ACARA --}}
                    <label for="">Status</label>
                    <select name="status_seminar" id="status_seminar" class="form-control">
                        {{-- <option value="">Belum diseminarkan</option> --}}
                        <option value="acc">Disetujui</option>
                        <option value="reject">Tidak Disetujui</option>
                        <option value="revisi">Disetujui dengan Revisi</option>
                    </select>
                    <input type="hidden" name="id" id="idTA">
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


