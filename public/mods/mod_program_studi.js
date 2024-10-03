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

function hapusData(e, url) {
    Swal.fire({
        title: "Hapus Program Studi ?",
        text: "Apakah kamu yakin untuk menghapus data ini?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Hapus!"
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
