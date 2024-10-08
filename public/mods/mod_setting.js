$(document).ready(function () {
    $('button[data-toggle="edit"]').on('click', function () {
        const url = $(this).data('url');
        const id = $(this).data('id');   
        $('#myFormulir').attr("action", `${BASE_URL}/apps/settings/${id}/update`);
        $('#myModalLabel').html('Perbarui Pengaturan')
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                console.log(response);
                $('#key').val(response.key);
                if (response.type === 'general') {
                    $('#general').show();
                    $('#file').hide();
                    $('#value').val(response.value);
                } else {
                    $('#file').show();
                    $('#general').hide();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        $('#myModal').modal('show')
    });
});