$(document).ready(function() {
    $.ajaxSetup({
        cache: false
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="popover"]').popover({
        html: true,
        trigger: 'click',
        template: '<div class="popover awesome-popover-class mipopover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
    });

    $('td').on('click', '.close-popover', function () {
        $('.popover').popover('hide');
    });

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
        'order': [$orderBy],
        'autoWidth': false
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
    var bame_flash = $('.bame_flash');
    var bame_shake = $('.bame_shake');
    var bame_bounce = $('.bame_bounce');

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
    bame_flash.each(function (index, value) {
        $(this).animateCSS('flash', {
            delay: 1000
        });
    });
    bame_shake.each(function (index, value) {
        $(this).animateCSS('shake', {
            delay: 1000
        });
    });
    bame_bounce.each(function (index, value) {
        $(this).animateCSS('bounce', {
            delay: 1000
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

    $('.modal_start').modal('show');

    setTimeout(function () {
        var date = new Date;
        if (date.getHours() == 2) {
            window.location = '/';
        }
    }, 3000000);
});
