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


function hapusTopik(e, url) {
    Swal.fire({
        title: "Hapus Topik Tugas Akhir?",
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

