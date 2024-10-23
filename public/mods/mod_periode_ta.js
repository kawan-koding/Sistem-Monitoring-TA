function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/periode/store`);
    $('#myModalLabel').html('Tambah Data')
    $('#nama').val('')
    $('#mulai_daftar').val('')
    $('#akhir_daftar').val('')
    $('#mulai_seminar').val('')
    $('#akhir_seminar').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/periode/${id}/update`);
    $('#myModalLabel').html('Ubah Data')
    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#nama').val(response.nama)
            $('#mulai_daftar').val(response.mulai_daftar)
            $('#akhir_daftar').val(response.akhir_daftar)
            $('#mulai_seminar').val(response.mulai_seminar)
            $('#akhir_seminar').val(response.akhir_seminar)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    $('#myModal').modal('show')
}

function hapusPeriode(e, url) {
    Swal.fire({
        title: "Hapus Periode?",
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

function changeIsActive(url, currentStatus) {
    let active = currentStatus == 0 ? 1 : 0;
    Swal.fire({
        title: 'Konfirmasi',
        text: active === 1 ? "Apakah Anda yakin ingin mengaktifkan periode ini?" : "Apakah Anda yakin ingin menonaktifkan periode ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url + `?is=` + active,
                type: "get",
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
                     }).then(() => {
                         window.location.reload();
                     });
                 }
            });
        }
    });
}
