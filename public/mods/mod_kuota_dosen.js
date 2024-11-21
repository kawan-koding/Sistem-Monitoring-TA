function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/kuota-dosen/create-all`);
    $('#myModalLabel').html('Tambah Kuota Semua Dosen')
    $('#pembimbing_1').val('')
    $('#pembimbing_2').val('')
    $('#penguji_1').val('')
    $('#penguji_2').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/kuota-dosen/${id}/update`);
    $('#myModalLabel').html('Ubah Kuota Dosen')
    $('#dosen_id').val(id);
    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#pembimbing_1').val(response.pembimbing_1 ?? 0);
            $('#pembimbing_2').val(response.pembimbing_2 ?? 0);
            $('#penguji_1').val(response.penguji_1 ?? 0);
            $('#penguji_2').val(response.penguji_2 ?? 0);
            $('#prodi').hide();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}