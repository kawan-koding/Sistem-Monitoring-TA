function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/ruangan/store`);
    $('#myModalLabel').html('Tambah Ruangan')
    $('#kode').val('')
    $('#nama_ruangan').val('')
    $('#lokasi').val('')
    $('#idRuangan').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/ruangan/update/${id}`);
    $('#myModalLabel').html('Ubah Data')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#kode').val(response.kode)
            $('#nama_ruangan').val(response.nama_ruangan)
            $('#lokasi').val(response.lokasi)
            $('#idRuangan').val(response.id)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

$(document).ready(function () {
    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Ruangan', url);
    });
});
