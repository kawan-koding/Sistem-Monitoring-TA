function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/kategori-nilai/store`);
    $('#myModalLabel').html('Tambah Kategori Nilai')
    $('#nama').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    console.log(urlShow, id);
    $('#myFormulir').attr("action", `${BASE_URL}/apps/kategori-nilai/${id}/update`);
    $('#myModalLabel').html('Ubah Kategori Nilai')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#nama').val(response.nama)
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
        confirmDelete('Kategori Nilai', url);
    });
});
