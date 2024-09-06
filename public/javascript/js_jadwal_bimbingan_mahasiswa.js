$('.unggah-berkas').on('click', function () {
    var url = $(this).data('url')
    $('#myFormulir').attr('action', url);

    $('#myUnggahModal').modal('show')
})
