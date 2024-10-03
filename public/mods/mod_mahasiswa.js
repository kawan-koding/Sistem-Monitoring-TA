function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/mahasiswa/store`);
    $('#myModalLabel').html('Tambah Data')
    $('#kelas').val('')
    $('#nim').val('')
    $('#nama_mhs').val('')
    $('#jenis_kelamin').val('')
    $('#email').val('')
    $('#telp').val('')
    $('#program_studi_id').val('')
    $('#idMahasiswa').val('')
    $('#myModal').modal('show')
}

function importData() {
    $('#myImportFormulir').attr("action", `${BASE_URL}/apps/mahasiswa/import`);
    $('#myModalImport').modal('show')
}

function editData(id, urlShow) {
    // alert(urlShow)
    $('#myFormulir').attr("action", `${BASE_URL}/apps/mahasiswa/${id}/update`);
    $('#myModalLabel').html('Ubah Data')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#kelas').val(response.kelas)
            $('#nim').val(response.nim)
            $('#nama_mhs').val(response.nama_mhs)
            $('#jenis_kelamin').val(response.jenis_kelamin)
            $('#email').val(response.email)
            $('#telp').val(response.telp)
            $('#program_studi_id').val(response.program_studi_id)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

function hapusData(e, url) {
    Swal.fire({
        title: "Are you sure ?",
        text: "Deleted data can not be restored!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
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
