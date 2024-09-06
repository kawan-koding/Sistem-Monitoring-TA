function checkRuangan(){
    // alert(urlShow)
    var tanggal = $('#tanggal').val()
    var jam_mulai = $('#jam_mulai').val()
    var jam_selesai = $('#jam_selesai').val()
    var ruangan = $('#ruangan').val()

    $.ajax({
        url: urlCheckRuangan + `?ruangan=${ruangan}&tanggal=${tanggal}&jam_mulai=${jam_mulai}&jam_selesai=${jam_selesai}`,
        type: "GET",
        dataType: "json",
        success: function(response) {
            console.log(response)
            if(response == 1){
                alert('Ruangan telah terpakai!!')
            }
        },
        error: function(xhr, status, error) {
            // Logika untuk menangani kesalahan
            console.error(xhr.responseText);
        }
    });
}