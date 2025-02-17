function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/users/store`);
    $('#myModalLabel').html('Tambah Pengguna')
    $('#name').val('')
    $('#username').val('')
    $('#email').val('')
    $('#password').val('')
    $('#confirm_password').val('')
    $('#roles').find('option[value=""]').remove();
    $('#roles').val([]).trigger('change');
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

function hapusUser(e, url) {
    Swal.fire({
        title: "Hapus Pengguna?",
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
