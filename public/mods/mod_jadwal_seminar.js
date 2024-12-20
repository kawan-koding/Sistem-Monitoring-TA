function uploadFileSeminar() {
    alert(1)
    $('#myUploadFileSeminar'+ id).attr('action', `${BASE_URL}/apps/jadwal-seminar/${id}/unggah-berkas`);
    $('#myModalUploadFileSeminar'+ id).modal('show');
}

function validasiFile(id, url) {
    $('#validasiFileAction'+ id).attr("action", url);    
    $('#modalValidasiFile'+ id).modal('show')
}