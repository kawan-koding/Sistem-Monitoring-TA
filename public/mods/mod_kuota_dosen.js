function changeKuota(name, field, periode, dosen) {
    let kuota = $(`#${field}`).val();
    $.ajax({
        url: `${BASE_URL}/apps/kuota-dosen/store`,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            field: name,
            value: kuota,
            periode_ta_id: periode,
            dosen_id: dosen,
        },
        success: function (data) {
            console.log(data.message);
            Pace.restart();
        }
    });
}
