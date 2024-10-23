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

function hapusRuangan(e, url) {
    Swal.fire({
        title: "Hapus Ruangan?",
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
                type: "GET",
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
}
