$(document).ready(function() {
    $.ajaxSetup({
        cache: false
    });

    $('[data-toggle="tooltip"]').tooltip();

    $orderBy = $('.datatable').attr('order-by');

    $orderBy = $orderBy.split('|');

    $('.datatable').DataTable({
        "language": {
            "url": $('body').attr('ruta') + "/js/dataTables.spanish.lang"
        },
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        'order': [[$orderBy[0], $orderBy[1]]]
    });
});
