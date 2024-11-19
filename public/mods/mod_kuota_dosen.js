// function setTimeLoad(func, delay) {
//     let timer;
//     return function (...args) {
//         clearTimeout(timer);
//         timer = setTimeout(() => func.apply(this, args), delay);
//     };
// }

// const procedUpdate = setTimeLoad((name, field, periode, dosen) => {
//     let kuota = document.getElementById(field).value;
//     $.ajax({
//         url: `${BASE_URL}/apps/kuota-dosen/store`,
//         type: "POST",
//         data: {
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             field: name,
//             value: kuota,
//             periode_ta_id: periode,
//             dosen_id: dosen,
//         },
//         success: function (data) {
//             Pace.restart();
//         },
//         error: function (error) {
//             console.error("Error:", error);
//         }
//     });
// }, 1000);

// function changeKuota(name, field, periode, dosen) {
//     procedUpdate(name, field, periode, dosen);
// }


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
    $('#myFormulir').attr("action", `${BASE_URL}/apps/kuota-dosen/store`);
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
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#myModal').modal('show')
}