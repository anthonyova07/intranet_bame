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

    var animateNameIn = 'rollIn';
    var animateNameOut = 'rollOut';

    var panel = $('.panel');
    var alert = $('.alert');
    var headerPage = $('.header-page');
    var news = $('.news');

    panel.each(function (index, value) {
        $(this).animateCSS(animateNameIn, {
            delay: index * 200
        });
    });
    news.each(function (index, value) {
        $(this).animateCSS(animateNameIn, {
            delay: index * 200
        });
    });
    alert.each(function (index, value) {
        $(this).animateCSS('bounceInDown', {
            delay: index * 300
        });
    });
    headerPage.animateCSS('slideInLeft');

    $('a.btn, .pagination>li>a, .nav-second-level>li>a, .naranja, button[type=submit], .fa-share, a.link_noticias, a.list-group-item').click(function () {
        panel.animateCSS(animateNameOut, function () {
            $(this).remove();
        });
        news.animateCSS(animateNameOut, function () {
            $(this).remove();
        });
        headerPage.animateCSS('slideOutRight', function () {
            $(this).remove();
        });
        alert.animateCSS('bounceOutUp');
    });

    $('.alert').click(function () {
        $(this).animateCSS('bounceOutUp', function () {
            $(this).remove();
        });
    });
});
