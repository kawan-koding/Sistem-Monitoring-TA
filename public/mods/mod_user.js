function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/users/store`);
    $('#myModalLabel').html('Tambah Pengguna')
    $('#name').val('')
    $('#username').val('')
    $('#email').val('')
    $('#password').val('')
    $('#confirm-_').val('')
    $('#roles').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/users/${id}/update`);
    $('#myModalLabel').html('Edit Pengguna')
    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#name').val(response.name)
            $('#username').val(response.username)
            $('#roles').val(response.roles).trigger('change');
            $('#email').val(response.email)
            $('#password').val('')
            $('#confirm_password').val('')
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
    });
}
