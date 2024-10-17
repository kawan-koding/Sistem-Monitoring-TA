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

function cancelTA(id) {
    $('#myModal').find('form').attr('action', `${BASE_URL}/apps/pengajuan-ta/${id}/cancel`);
    $('#myModal').find('.modal-title').html('Batalkan TA?');
    $('#myModal').modal('show');

}


$(document).ready(function () {
     $('select[name="jenis_ta_id"]').on('change', function () {
        let selectedValue = $(this).val();
        if (selectedValue === 'lainnya') {
            $('#new_jenis').show();
        } else {
            $('#new_jenis').hide();
        }
    });

    $('select[name="topik"]').on('change', function () {
        let selectedValue = $(this).val();
        if (selectedValue === 'lainnya') {
            $('#new_topik').show();
        } else {
            $('#new_topik').hide();
        }
    });
});