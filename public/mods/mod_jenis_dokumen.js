function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jenis-dokumen/store`);
    $('#myModalLabel').html('Tambah Jenis Dokumen')
    $('#nama').val('')
    $('#jenis').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jenis-dokumen/${id}/update`);
    $('#myModalLabel').html('Ubah Jenis Dokumen')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#nama').val(response.nama)
            $('#jenis').val(response.jenis)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    $('#myModal').modal('show')
}

function hapusJenisDokumen(e, url) {
    Swal.fire({
        title: "Hapus Jenis Dokumen?",
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
