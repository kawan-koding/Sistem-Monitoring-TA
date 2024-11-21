function daftarSidang(id, url) {
    $('#daftarSidangAction').attr("action", `${BASE_URL}/apps/jadwal-sidang/${id}/daftar-sidang`);
    $('#daftarSidangLabel').html('Unggah Berkas Pendaftaran')
    $('#modalDaftarSidang').modal('show')
}

function unggahFile(id, url) {
    // $('#daftarSidangAction').attr("action", `${BASE_URL}/apps/jadwal-sidang/daftar-sidang`);
    $('#daftarSidangLabel').html('Unggah Berkas Pasca Sidang')
    $('#modalDaftarSidang').modal('show')
}

function validasiFile(id, url) {
    $('#validasiFileAction').attr("action", `${BASE_URL}/apps/jadwal-sidang/${id}/validasi-berkas`);
    $('#validasiFileLabel').html('Validasi Berkas Sidang');
    $('#modalValidasiFile').modal('show')
}