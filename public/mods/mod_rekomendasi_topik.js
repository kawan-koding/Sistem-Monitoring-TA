function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/store`);
    $('#myModalLabel').html('Tambah Rekomendasi Topik')
    $('#judul').val('')
    $('#jenis_ta_id').val('')
    $('#kuota').val('')
    $('#tipe').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/${id}/update`);
    $('#myModalLabel').html('Ubah Rekomendasi Topik')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#judul').val(response.judul)
            $('#kuota').val(response.kuota)
            $('#tipe').val(response.tipe)
            $('#jenis_ta_id').val(response.jenis_ta_id)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

$(document).ready(function() {
    $('*[data-toggle="get-topik"]').on('click', function() {
        const id = $(this).data('id');
        $('#myImportFormulir').attr('action', `${BASE_URL}/apps/rekomendasi-topik/${id}/mengambil-topik`);
        $('#myModalLabelApply').html('Ambil Topik');
        $('#description').val('');
        $('#myModalApply').modal('show');
    });
});

$(document).ready(function () {
    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Program Studi', url);
    });
});

$(document).ready(function () {
    $('*[data-toggle="delete-topik"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Topik Yang Diambil', url);
    });
});
