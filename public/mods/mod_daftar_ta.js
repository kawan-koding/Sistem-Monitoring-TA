document.addEventListener('DOMContentLoaded', function () {
    updateOptions(); // Panggil fungsi saat halaman pertama kali dimuat
});

function updateOptions() {
    var selectedValues = [];

    // Ambil semua select yang punya class 'dosen-select'
    var selects = document.querySelectorAll('.dosen-select');

    // Ambil nilai yang sudah dipilih
    selects.forEach(function (select) {
        var selectedValue = select.value;
        if (selectedValue) {
            selectedValues.push(selectedValue);
        }
    });

    // Loop untuk setiap select dan periksa pilihan-pilihan yang tersedia
    selects.forEach(function (currentSelect) {
        var currentValue = currentSelect.value;

        var options = currentSelect.querySelectorAll('option');
        options.forEach(function (option) {
            var optionValue = option.value;

            // Cek apakah pilihan sudah dipilih di select lain, tetapi bukan di select ini
            if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
                option.disabled = true; // Nonaktifkan pilihan yang sudah dipilih di tempat lain
                option.setAttribute('data-hidden', 'true');
            } else {
                option.disabled = false; // Aktifkan pilihan jika belum dipilih
                option.removeAttribute('data-hidden');
            }
        });
    });
}


$(document).ready(function () {
    $(document).on('click', '*[data-toggle="delete"]', function () {
        const url = $(this).data('url');
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
                    type: "DELETE",
                    data: {
                        _token: token
                    },
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
    });
});
