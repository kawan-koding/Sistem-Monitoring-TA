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
    $('#modalValidasiFile').modal('show')
}

function updateOptions() {
    var selectedValues = [];

    var selects = document.querySelectorAll('.dosen-select');
    selects.forEach(function (select) {
        var selectedValue = select.value;
        if (selectedValue) {
            selectedValues.push(selectedValue);
        }
    });

    selects.forEach(function (currentSelect) {
        var currentValue = currentSelect.value;

        var options = currentSelect.querySelectorAll('option');
        options.forEach(function (option) {
            var optionValue = option.value;
            if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
                option.disabled = true;
                option.setAttribute('data-hidden', 'true');
            } else {
                option.disabled = false;
                option.removeAttribute('data-hidden');
            }

        });
    });

}