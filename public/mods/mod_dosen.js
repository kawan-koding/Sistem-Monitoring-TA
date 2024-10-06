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

$(document).ready(function () {
    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Dosen', url);
    });
});
