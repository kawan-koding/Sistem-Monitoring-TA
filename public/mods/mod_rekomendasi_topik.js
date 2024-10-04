function tambahData() {
    $('#myFormulir').attr("action", `${BASE_URL}/apps/rekomendasi-topik/store`);
    $('#myModalLabel').html('Tambah Data')
    $('#judul').val('')
    $('#jenis_ta_id').val('')
    $('#kuota').val('')
    $('#tipe').val('')
    $('#myModal').modal('show')
}

