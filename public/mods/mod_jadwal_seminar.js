function uploadFileSeminar() {
    alert(1)
    $('#myUploadFileSeminar'+ id).attr('action', `${BASE_URL}/apps/jadwal-seminar/${id}/unggah-berkas`);
    $('#myModalUploadFileSeminar'+ id).modal('show');
}

function validasiFile(id, url) {
    $('#validasiFileAction'+ id).attr("action", url);    
    $('#modalValidasiFile'+ id).modal('show')
}

function reset(e, url) {
    Swal.fire({
        title: "Reset Jadwal Seminar?",
        text: "Apakah kamu yakin untuk mereset jadwal seminar ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Reset!"
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
};