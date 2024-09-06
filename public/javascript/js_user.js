function tambahData(){
    $('#myFormulir').attr("action", formUrlCreate);
    $('#myModalLabel').html('Tambah Data')
    $('#name').val('')
    $('#username').val('')
    // $('#email').val('')
    $('#forPass').html(`
    <label for="">Password <span class="text-danger">*</span></label>
    <input type="password" name="password" id="password" class="form-control" required>
    `)
    $('#password').val('')
    $('#role').val('')
    $('#idUser').val('')
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
            $('#name').val(response.name)
            $('#username').val(response.username)
            // $('#email').val(response.email)
            console.log(response.role)
            $('#role').val(response.role[0])
            $('#role_2').val(response.role[1])
            $('#role_3').val(response.role[2])
            $('#role_4').val(response.role[3])
            $('#forPass').html(``)
            $('#idUser').val(response.id)
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
