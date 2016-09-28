$(document).ready(function() {
    $.ajaxSetup({
        cache: false
    });

    $('[data-toggle="tooltip"]').tooltip();

    $orderBy = $('.datatable').attr('order-by');

    if ($orderBy !== undefined) {
        $orderBy = $orderBy.split('|');
    } else {
        $orderBy = [];
    }

    $('.datatable').DataTable({
        "language": {
            "url": $('body').attr('ruta') + "/js/dataTables.spanish.lang"
        },
        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        'order': [$orderBy]
    });

    $('.carousel').carousel();

    var panel = $('.panel');
    panel.css('display', 'block');
    panel.addClass('animated rollIn');

    $('a.btn').on('click', function (e) {
        panel.removeClass('animated rollIn');
        panel.addClass('animated rollOut');
        panel.one('webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd animationend', function () {
            $(this).removeClass('animated rollOut');
        });
    });
});
