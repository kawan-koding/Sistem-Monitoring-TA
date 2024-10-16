function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/store`);
    $('#myModalLabel').html('Tambah Rekomendasi Topik')
    $('#judul').val('')
    $('#deskripsi').val('')
    $('#jenis_ta_id').val('')
    $('#kuota').val('')
    $('#tipe').val('')
    $('#myModal').modal('show')
}

function editData(id, urlShow) {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/${id}/update`);
    $('#myModalLabel').html('Ubah Rekomendasi Topik')

    $.ajax({
        url: urlShow,
        type: "GET",
        dataType: "json",
        success: function (response) {
            $('#judul').val(response.judul)
            $('#kuota').val(response.kuota)
            $('#tipe').val(response.tipe)
            $('#deskripsi').val(response.deskripsi)
            $('#jenis_ta_id').val(response.jenis_ta_id)
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}

$(document).ready(function() {
    $('*[data-toggle="get-topik"]').on('click', function() {
        const id = $(this).data('id');
        $('#myImportFormulir').attr('action', `${BASE_URL}/apps/rekomendasi-topik/${id}/mengambil-topik`);
        $('#myModalLabelApply').html('Ambil Topik');
        $('#description').val('');
        $('#myModalApply').modal('show');
    });

    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Topik Yang Ditawarkan', url);
    });

    $('*[data-toggle="delete-topik"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Topik Yang Diambil', url);
    });
    $('*[data-toggle="delete-mhs"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Mahasiswa', url);
    });

    $('*[data-toggle="reject-mhs"]').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('#approveForm').attr('action', url).attr('method', 'POST').submit();
    });

    $('*[data-toggle="approve-mhs"]').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        $('#approveForm').attr('action', url).attr('method', 'POST').submit();;
    });

    $('#jenis_ta_id').on('change', function () {
        let selectedValue = $(this).val();
        if (selectedValue === 'lainnya') {
            $('#new_jenis').show();
        } else {
            $('#new_jenis').hide();
        }
    });
});



