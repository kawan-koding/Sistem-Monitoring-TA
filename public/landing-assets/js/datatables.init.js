$(document).ready(function () {
    $("#datatable").DataTable({
        // "dom": '<"row"<"col-sm-4 col-12 filter"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"l><"col-sm-12 col-md-7"p>>',
        dom: '<"row mb-3"<"col-sm-6 d-flex align-items-center"l><"col-sm-6 text-end"f>>' +
            '<"row"<"col-12"tr>>' +
            '<"row mt-3"<"col-sm-12 col-md-12 d-flex justify-content-center"p>>',
        "search": {
            return: true,
        },
        "lengthMenu": [
            [10, 25, 50, 100],
            [10 + " baris", 25 + " baris", 50 + " baris", 100 + " baris"]
        ], 
        "language": {
            "info": "Showing _START_ to _END_ of _TOTAL_",
            "lengthMenu": "_MENU_ ",
            "search": "_INPUT_",
            "searchPlaceholder": "Pencarian...",
            "paginate": {
                "previous": "«",
                "next": "»"
            }
        },
        "info": false
    });
});
