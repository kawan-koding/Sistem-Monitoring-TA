function tambahData(){
    $('#myFormulir').attr("action", formUrlCreate);
    $('#myModalLabel').html('Tambah Data')
    $('#nama').val('')
    $('#mulai_daftar').val('')
    $('#akhir_daftar').val('')
    $('#mulai_seminar').val('')
    $('#akhir_seminar').val('')
    $('#idPeriode').val('')
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
            $('#nama').val(response.nama)
            $('#mulai_daftar').val(response.mulai_daftar)
            $('#akhir_daftar').val(response.akhir_daftar)
            $('#mulai_seminar').val(response.mulai_seminar)
            $('#akhir_seminar').val(response.akhir_seminar)
            $('#idPeriode').val(response.id)
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

function changeIsActive(url, a){
    let checkbox = a
    if(checkbox == 0){
        var active = 1
    }else{
        var active = 0
    }
    console.log(active)
    $.ajax({
        url: url + `?is=` + active,
        type: "get",
        success: function (data) {
            window.location.reload();
        }
    })
}
