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
    $('*[data-toggle="delete"]').on('click', function () {
        const url = $(this).data('url');
        confirmDelete('Tugas Akhir', url);
    });
});
