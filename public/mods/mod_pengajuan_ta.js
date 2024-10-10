function uploadFile(id) {
    $('#myUploadFile').attr('action', `${BASE_URL}/apps/pengajuan-ta/${id}/unggah-berkas`);
    $('#myModalUploadFile').modal('show');
}