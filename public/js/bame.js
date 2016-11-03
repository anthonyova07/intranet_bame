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

    var animateNameIn = 'zoomInDown';
    var animateNameOut = 'zoomOut';

    var headerBar = $('.row-top');
    var panel = $('.panel');
    var alert = $('.alert');
    var headerPage = $('.header-page');
    var news = $('.news');
    var bame_tada = $('.bame_tada');
    var bame_wobble = $('.bame_wobble');
    var bame_hinge = $('.bame_hinge');

    headerBar.each(function (index, value) {
        $(this).animateCSS('slideInDown', {
            delay: index * 200,
            callback: function () {
                $(this).css('animation-duration', '0ms');
            }
        });
    });
    panel.each(function (index, value) {
        $(this).animateCSS(animateNameIn, {
            delay: index * 200,
            callback: function () {
                $(this).css('animation-duration', '0ms');
            }
        });
    });
    news.each(function (index, value) {
        $(this).animateCSS(animateNameIn, {
            delay: index * 200,
            callback: function () {
                $(this).css('animation-duration', '0ms');
            }
        });
    });
    alert.each(function (index, value) {
        $(this).animateCSS('bounceInDown', {
            delay: index * 300
        });
    });
    bame_tada.each(function (index, value) {
        $(this).animateCSS('tada', {
            delay: 1000
        });
    });
    bame_wobble.each(function (index, value) {
        $(this).animateCSS('wobble', {
            delay: 1000
        });
    });
    bame_hinge.each(function (index, value) {
        $(this).animateCSS('hinge', {
            delay: 3000,
            callback: function () {
                $(this).remove();
            }
        });
    });
    headerPage.animateCSS('slideInLeft');

    $('a.btn, .pagination>li>a, .nav-second-level>li>a, .naranja, button[type=submit], .fa-share, a.link_noticias, a.list-group-item').click(function () {
        headerBar.animateCSS('slideOutUp', function () {
            $(this).remove();
        });
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
