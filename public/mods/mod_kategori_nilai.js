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
   $(document).on('click', '*[data-toggle="delete"]', function () {
        const url = $(this).data('url');
        Swal.fire({
            title: "Hapus Kategori Nilai?",
            text: "Apakah kamu yakin untuk menghapus data ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: token,
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            }
        });
    });
});
