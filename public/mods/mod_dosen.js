function tambahData(){
    $('#myFormulir').attr("action", `${BASE_URL}/apps/dosen/store`);
    $('#myModalLabel').html('Tambah Data')
    $('#nip').val('')
    $('#nidn').val('')
    $('#name').val('')
    $('#jenis_kelamin').val('')
    $('#email').val('')
    $('#telp').val('')
    $('#alamat').val('')
    $('#idDosen').val('')
    $('#myModal').modal('show')
}
function importData(){
    $('#myImportFormulir').attr("action", `${BASE_URL}/apps/dosen/import`);
    $('#myModalImport').modal('show')
}

function editData(id, urlShow){
    // alert(urlShow)
    $('#myFormulir').attr("action", `${BASE_URL}/apps/dosen/${id}/update`);
    $('#myModalLabel').html('Ubah Data')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#nip').val(response.nip)
            $('#nidn').val(response.nidn)
            $('#name').val(response.name)
            $('#jenis_kelamin').val(response.jenis_kelamin)
            $('#email').val(response.email)
            $('#telp').val(response.telp)
            $('#alamat').val(response.alamat)
            $('#program_studi_id').val(response.program_studi_id)
            $('#idDosen').val(response.id)
        },
        error: function(xhr, status, error) {
            // Logika untuk menangani kesalahan
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

function hapusDosen(e, url) {
    Swal.fire({
        title: "Hapus Dosen?",
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
