function changeKuota(name, field, periode, dosen){
    let kuota = $(`#${field}`).val();
    // alert(kuota)
    $.ajax({
        url: formUrlChangeOrCreate +`?field=${name}&value=${kuota}&periode_ta_id=${periode}&dosen_id=${dosen}`,
        type: "get",
        success: function (data) {
            // window.location.reload();
        }
    });
}
