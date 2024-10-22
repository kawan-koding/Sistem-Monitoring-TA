function uploadFileSeminar() {
    $('#myUploadFileSeminar').attr('action', `${BASE_URL}/apps/jadwal-seminar/${id}/unggah-berkas`);
    $('#myModalUploadFileSeminar').modal('show');
}