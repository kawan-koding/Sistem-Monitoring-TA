function setTimeLoad(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

const procedUpdate = setTimeLoad((name, field, periode, dosen) => {
    let kuota = document.getElementById(field).value;
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
            Pace.restart();
        },
        error: function (error) {
            console.error("Error:", error);
        }
    });
}, 1000);

function changeKuota(name, field, periode, dosen) {
    procedUpdate(name, field, periode, dosen);
}