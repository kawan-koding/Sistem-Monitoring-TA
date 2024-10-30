<div class="modal fade" id="myModal">
    <div class="modal-dialog text-start">
        <div class="modal-content">
            <form action="{{ route('apps.jadwal.update-status', $item->id) }}" method="post">
                @csrf
                <div class="modal-header d-block">
                    <h5 class="mb-0">Update status seminar proposal</h5>
                    <p class="text-muted small mb-0">Berikan keputusan terkait status seminar proposal</p>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Status Seminar Proposal <span class="text-danger">*</span></label><br>
                        <label for="acc" class="me-2"><input type="radio" name="status" id="acc" value="acc"> Setujui</label>
                        <label for="revisi" class="me-2"><input type="radio" name="status" id="revisi" value="revisi"> Disetujui dengan revisi</label>
                        <label for="reject" class="me-2"><input type="radio" name="status" id="reject" value="reject"> Ditolak</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>