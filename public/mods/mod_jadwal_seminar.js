function uploadFileSeminar() {
    $('#myUploadFileSeminar').attr('action', `${BASE_URL}/apps/jadwal-seminar/${id}/unggah-berkas`);
    $('#myModalUploadFileSeminar').modal('show');
}

function validasiFile(id, url) {
    $('#validasiFileAction').attr("action", url);    
    $('#modalValidasiFile').modal('show')
}