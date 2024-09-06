function tambahData(){
    $('#myFormulir').attr("action", formUrlCreate);
    $('#myModalLabel').html('Tambah Data')
    $('#nama_jenis').val('')
    $('#idJenis').val('')
    $('#myModal').modal('show')
}

function editJenis(id, urlShow){
    // alert(urlShow)
    $('#myFormulir').attr("action", formUrlUpdate);
    $('#myModalLabel').html('Ubah Data')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#nama_jenis').val(response.nama_jenis)
            $('#idJenis').val(response.id)
        },
        error: function(xhr, status, error) {
            // Logika untuk menangani kesalahan
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

function hapusJenis(e, url) {
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
