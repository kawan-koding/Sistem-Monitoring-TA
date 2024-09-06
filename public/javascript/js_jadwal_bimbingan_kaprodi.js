$('.acc_ta').on('click', function() {
    var url = $(this).data('url')

    Swal.fire({
        title: "Are you sure ?",
        text: "You want acc this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Acc it!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: "get",
                success: function (data) {
                    console.log(data.status)
                    if(data.status == 'success'){
                        Swal.fire("Acc!","Your action have been success.","success")
                        window.location.reload();
                    }else{
                        alert(data.message)
                    }
                }
            })
        }
    })
})

$('.reject_ta').on('click', function(){
    var url = $(this).data('url')
    // Mengisi action form dengan jQuery
    $('#formReject').attr('action', url);
    $('#modalReject').modal('show');
})
