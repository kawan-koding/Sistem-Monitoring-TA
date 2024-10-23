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

function hapusJurusan(e, url) {
    Swal.fire({
        title: "Hapus Jurusan?",
        text: "Apakah kamu yakin untuk menghapus data ini?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "get",
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
    })
}
