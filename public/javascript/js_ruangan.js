function tambahData(){
    $('#myFormulir').attr("action", formUrlCreate);
    $('#myModalLabel').html('Tambah Data')
    $('#kode').val('')
    $('#nama_ruangan').val('')
    $('#lokasi').val('')
    $('#idRuangan').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow){
    // alert(urlShow)
    $('#myFormulir').attr("action", formUrlUpdate);
    $('#myModalLabel').html('Ubah Data')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#kode').val(response.kode)
            $('#nama_ruangan').val(response.nama_ruangan)
            $('#lokasi').val(response.lokasi)
            $('#idRuangan').val(response.id)
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
