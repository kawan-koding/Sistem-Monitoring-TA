function uploadFile(id) {
    $('#myUploadFile').attr('action', `${BASE_URL}/apps/pengajuan-ta/${id}/unggah-berkas`);
    $('#myModalUploadFile').modal('show');
}

function acceptTA(id) {
    $('#myModal').find('form').attr('action', `${BASE_URL}/apps/pengajuan-ta/${id}/accept`);
    $('#myModal').find('.modal-title').html('Setujui TA?');
    $('#myModal').modal('show');
}

function rejectTA(id) {
    $('#myModal').find('form').attr('action', `${BASE_URL}/apps/pengajuan-ta/${id}/reject`);
    $('#myModal').find('.modal-title').html('Tolak TA?');
    $('#myModal').modal('show');
}