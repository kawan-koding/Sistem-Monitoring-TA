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

function hapusMahasiswa(e, url) {
    Swal.fire({
        title: "Hapus Mahasiswa?",
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
};
