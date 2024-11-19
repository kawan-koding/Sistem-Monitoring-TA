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