$(document).ready(function() {
    $.ajaxSetup({
        cache: false
    });

    var myCustomTemplates = {
        emphasis : function(locale) {
            return "<li>" +
                "<div class='btn-group'>" +
                "<button data-wysihtml5-command='bold' title='Negrita' class='btn btn-default' ><span style='font-weight:700'>B</span></button>" +
                "<button data-wysihtml5-command='italic' title='Itálica' class='btn btn-default' ><span style='font-style:italic'>I</span></button>" +
                "<button data-wysihtml5-command='underline' title='Subrayado' class='btn btn-default' ><span style='text-decoration:underline'>U</span></button>" +
                "</div>" +
                "</li>";
        },
        lists : function(locale) {
            return "<li>" +
                "<div class='btn-group'>" +
                "<button data-wysihtml5-command='insertUnorderedList' title='Lista desordenada' class='btn btn-default' ><span class='fa fa-list-ul'></span></button>" +
                "<button data-wysihtml5-command='insertOrderedList' title='Lista ordenada' class='btn btn-default' ><span class='fa fa-list-ol'></span></button>" +
                // "<button data-wysihtml5-command='Outdent' title='Anular sangría' class='btn btn-default' ><span class='fa fa-outdent'></span></button>" +
                // "<button data-wysihtml5-command='Indent' title='Añadir Sangria' class='btn btn-default'><span class='fa fa-indent'></span></button>" +
                "</div>" +
                "</li>";
        }
    };

    $('.textarea').wysihtml5({
        toolbar: {
            fa: true,
            image: false,
            blockquote: false,
            link: false,
            "font-styles": false
        },
        customTemplates: myCustomTemplates
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

    var animateNameIn = 'fadeInDown';
    var animateNameOut = 'fadeOutUp';

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
