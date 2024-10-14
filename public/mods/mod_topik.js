function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/topik/store`);
    $('#myModalLabel').html('Tambah Topik Tugas Akhir')
    $('#nama_topik').val('')
    $('#idTopik').val('')
    $('#myModal').modal('show')
}

function editTopik(id, urlShow) {
    // alert(urlShow)
    $('#myFormulir').attr("action", `${BASE_URL}/apps/topik/update/${id}`);
    $('#myModalLabel').html('Ubah Topik Tugas Akhir')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#nama_topik').val(response.nama_topik)
            $('#idTopik').val(response.id)
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
        confirmDelete('Topik', url);
    });
});

