$('.delete-uraian').on('click', function() {
    var url = $(this).data('url')
    Swal.fire({
        title: "Are you sure ?",
        text: "Deleted data can not be restored!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "get",
                success: function (data) {
                    if(data.status == 'success'){
                        Swal.fire("Success!",`${data.message}`,"success")
                        window.location.reload();
                    }else{
                        Swal.fire("Error!", `${data.message}`, "error");
                    }
                }
            })
        }
    })
})


$('.delete-nilai').on('click', function() {
    var url = $(this).data('url')
    Swal.fire({
        title: "Are you sure ?",
        text: "Deleted data can not be restored!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "get",
                success: function (data) {
                    if(data.status == 'success'){
                        Swal.fire("Success!",`${data.message}`,"success")
                        window.location.reload();
                    }else{
                        Swal.fire("Error!", `${data.message}`, "error");
                    }
                }
            })
        }
    })
})

$('.update-status-seminar').on('click', function() {
    var status = $(this).data('status')
    var id = $(this).data('id')
    $('#status_seminar').val(status)
    $('#idTA').val(id)

    $('#myModal').modal('show')
})

function makeNilai(a, b, c){
    var aspek = $(`#${a}`).val()
    var nilai = $(`#${b}`).val()
    var tugas_akhir_id = $(`#tugas_akhir_id`).val()
    var dosen_id = $(`#dosen_id`).val()
    var jenis = $(`#jenis`).val()
    var urut = $(`#urut`).val()

    if(nilai > 100){
        alert('Nilai tidak boleh melebihi 100')
        $(`#${b}`).val(0)
    }else{
        // alert('aspek nilai : '+aspek)
        // alert('nilai : '+nilai)
        $.ajax({
            url: formUrlChangeOrCreate +`?tugas_akhir_id=${tugas_akhir_id}&dosen_id=${dosen_id}&jenis=${jenis}&urut=${urut}&aspek=${aspek}&nilai=${nilai}`,
            type: "get",
            success: function (data) {
                // alert(data)
                // window.location.reload();
                $(`#${c}`).html(data)
            }
        });
    }
}

$('.update-uraian').on('click', function(){
    var uraian = $(this).data('revisi')
    var id = $(this).data('id')
    $('#revisi').val(uraian)
    $('#idRevisi').val(id)
    $('#myModal').modal('show')
})
