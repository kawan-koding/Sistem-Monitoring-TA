function tambahData(){
    $('#myFormulir').attr("action", `${BASE_URL}/apps/dosen/store`);
    $('#myModalLabel').html('Tambah Data')
    $('#nip').val('')
    $('#nidn').val('')
    $('#name').val('')
    $('#jenis_kelamin').val('')
    $('#email').val('')
    $('#telp').val('')
    // $('#alamat').val('')
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
            // $('#alamat').val(response.alamat)
            $('#idDosen').val(response.id)
        },
        error: function(xhr, status, error) {
            // Logika untuk menangani kesalahan
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
