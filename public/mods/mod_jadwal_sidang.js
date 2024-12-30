function daftarSidang(id, url) {
    $('#daftarSidangAction'+ id).attr("action", `${BASE_URL}/apps/jadwal-sidang/${id}/daftar-sidang`);
    $('#daftarSidangLabel'+ id).html('Unggah Berkas Pendaftaran')
    $('#modalDaftarSidang'+ id).modal('show')   
}

function unggahFile(id, url) {
    $('#daftarSidangAction'+ id).attr("action", `${BASE_URL}/apps/jadwal-sidang/${id}/unggah-berkas`);
    $('#daftarSidangLabel'+ id).html('Unggah Berkas Pasca Sidang')
    $('#modalDaftarSidang'+ id).modal('show')
}

function validasiFile(id, url) {
    $('#validasiFileAction'+ id).attr("action", `${BASE_URL}/apps/jadwal-sidang/${id}/validasi-berkas`);
    $('#modalValidasiFile'+ id).modal('show')
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