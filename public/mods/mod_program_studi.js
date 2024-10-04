function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/program-studi/store`);
    $('#myModalLabel').html('Tambah Program Studi')
    $('#kode').val('')
    $('#nama').val('')
    $('#jurusan_id').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/program-studi/${id}/update`);
    $('#myModalLabel').html('Ubah Program Studi')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#kode').val(response.kode)
            $('#nama').val(response.nama)
            $('#jurusan_id').val(response.jurusan_id)
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
        confirmDelete('Program Studi', url);
    });
});
