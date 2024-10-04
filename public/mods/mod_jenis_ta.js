function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jenis-ta/store`);
    $('#myModalLabel').html('Tambah Jenis Tugas Akhir')
    $('#nama_jenis').val('')
    $('#idJenis').val('')
    $('#myModal').modal('show')
}

function editJenis(id, urlShow) {
    // alert(urlShow)
    $('#myFormulir').attr("action", `${BASE_URL}/apps/jenis-ta/update/${id}`);
    $('#myModalLabel').html('Ubah Jenis Tugas Akhir')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#nama_jenis').val(response.nama_jenis)
            $('#idJenis').val(response.id)
        },
        error: function (xhr, status, error) {
            // Logika untuk menangani kesalahan
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

function hapusJenis(e, url) {
    Swal.fire({
        title: "Hapus Jenis Tugas Akhir?",
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
                    window.location.reload();
                }
            })
        }
    })

}
