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
    var alert = $('.alert');
    var headerPage = $('.header-page');

    panel.css('display', 'block');
    alert.css('display', 'block');
    headerPage.css('display', 'block');

    panel.addClass('animated rollIn');
    alert.addClass('animated rollIn');
    headerPage.addClass('animated slideInLeft');

    $('a.btn, .pagination>li>a, .nav-second-level>li>a, .naranja, button[type=submit]').on('click', function (e) {
        panel.removeClass('animated rollIn');
        panel.addClass('animated rollOut');
        headerPage.addClass('animated slideOutRight');
        panel.one('webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd animationend', function () {
            $(this).removeClass('animated rollOut');
        });
    });
});
