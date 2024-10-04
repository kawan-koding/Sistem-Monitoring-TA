function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jurusan/store`);
    $('#myModalLabel').html('Tambah Jurusan')
    $('#kode').val('')
    $('#nama').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jurusan/${id}/update`);
    $('#myModalLabel').html('Ubah Jurusan')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#kode').val(response.kode)
            $('#nama').val(response.nama)
        },
        error: function (xhr, status, error) {
            // Logika untuk menangani kesalahan
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

$(document).ready(function () {
    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Jurusan', url);
    });
});
