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

    var animateNameIn = 'fadeInDown';
    var animateNameOut = 'fadeOutDown';

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

    $('a.btn, .pagination>li>a, .nav-second-level>li>a, .naranja, button[type=submit], .fa-share, a.link_noticias').click(function () {
        panel.animateCSS(animateNameOut);
        news.animateCSS(animateNameOut);
        headerPage.animateCSS('slideOutRight');
        alert.animateCSS('bounceOutUp');
    });

    $('.alert').click(function () {
        $(this).animateCSS('bounceOutUp', function () {
            $(this).remove();
        });
    })
});
