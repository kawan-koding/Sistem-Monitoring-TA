$('.status-revisi-modal').on('click', function() {
    var status = $(this).data('status')
    var url = $(this).data('url')
    $('#revisiForm').attr('action', url);
    $('#status_revisi').val(status);
    $('#myModal').modal('show');
})
