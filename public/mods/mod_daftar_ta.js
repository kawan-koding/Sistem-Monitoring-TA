document.addEventListener('DOMContentLoaded', function () {
    updateOptions();
});

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
                option.removeAttribute('data-hidden');
            }
        });
    });
}

function hapusDaftarTa(e, url) {
    Swal.fire({
        title: "Hapus Tugas Akhir?",
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
};


$('#jenis').on('change', function () {
    let selectedValue = $(this).val();
    if (selectedValue === 'Lainnya') {
        $('#new_jenis').show();
    } else {
        $('#new_jenis').hide();
    }
});

$('#topik').on('change', function () {
    let selectedValue = $(this).val();
    if (selectedValue === 'Lainnya') {
        $('#new_topik').show();
    } else {
        $('#new_topik').hide();
    }
});