function desktop_noty(title, body, url) {
    var options = {
        body: body,
        icon: $('body').attr('icon-noti')
    }
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification('Bancamérica Intranet - ' + title, options);
        notification.onclick = function () {
            if (url !== undefined && url !== '') {
                window.open(url);
            }
        };
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification('Bancamérica Intranet - ' + title, options);
                notification.onclick = function () {
                    if (url !== undefined) {
                        window.open(url);
                    }
                };
            }
        });
    }

    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}

function check_notifications() {
    var ruta_base = $('body').attr('ruta');
    $.ajax({
        url: ruta_base + '/notification/all',
        success: function (data,status) {
            $.each(data, function (index, notificacion) {
                desktop_noty(notificacion.titulo, notificacion.texto, notificacion.url);
                $.ajax({
                    url: ruta_base + '/notification/notified/' + notificacion.id,
                });
            });
        }
    });
}

function check_global_notifications() {
    var ruta_base = $('body').attr('ruta');
    $.ajax({
        url: ruta_base + '/notification/all/global',
        success: function (data,status) {
            $.each(data, function (index, notificacion) {
                desktop_noty(notificacion.titulo, notificacion.texto, notificacion.url);
            });
        }
    });
}

function delete_notification(id) {
    var ruta_base = $('body').attr('ruta');
    $('#' + id).remove();
    $('#' + id + '_divider').remove();

    $.ajax({
        url: ruta_base + '/notification/delete/' + id
    });
}

function calendar(defaultDate, events) {
    $('#calendar').fullCalendar({
        theme: true,
        defaultDate: defaultDate,
        defaultView: 'month',
        fixedWeekCount: true,
        nowIndicator: true,
        firstDay: 1,
        weekNumbers: false,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        // eventLimit: true, // allow "more" link when too many events
        events: events,
        dayClick: function (date, jsEvent, view) {
            var day = date.toDate().getDate() + 1;
            var month = date.toDate().getMonth() + 1;
        }
    });

    $('#calendar').on({
        mouseenter: function () {
            var content = '<ul class="list-group">';
            $(this).addClass('show_popover').attr('class').split(' ').forEach(function (item, index) {
                if (item != 'fc-day-grid-event'
                    && item != 'fc-h-event'
                    && item != 'fc-event'
                    && item != 'fc-start'
                    && item != 'fc-end'
                    && item != 'show_popover'
                    && item != 'cal_icon'
                    && item != 'birthdate') {
                    var names = item.split(',');
                    names.forEach(function (item, index) {
                        var name = item.split('|').join(' ');
                        content += '<li class="list-group-item">' + name + '</li>';
                    });
                }
            });
            content += '</ul>';

            $('.show_popover').popover({
                title: 'Cumpleaños del Día',
                content: content,
                html: true,
                placement: 'top',
                container: 'body',
            }).popover('show');
        },
        mouseleave: function () {
            $('.show_popover').popover('hide');
            $(this).removeClass('show_popover');
        }
    }, '.birthdate');

    $('#calendar').on({
        mouseenter: function () {
            var content = '<ul class="list-group">';
            $(this).addClass('show_popover').attr('class').split(' ').forEach(function (item, index) {
                if (item != 'fc-day-grid-event'
                    && item != 'fc-h-event'
                    && item != 'fc-event'
                    && item != 'fc-start'
                    && item != 'fc-end'
                    && item != 'show_popover'
                    && item != 'cal_icon'
                    && item != 'service_year') {
                    var names = item.split(',');
                    names.forEach(function (item, index) {
                        var name = item.split('|').join(' ');
                        content += '<li class="list-group-item">' + name + '</li>';
                    });
                }
            });
            content += '</ul>';

            $('.show_popover').popover({
                title: 'Aniversarios de Trabajo',
                content: content,
                html: true,
                placement: 'top',
                container: 'body',
            }).popover('show');
        },
        mouseleave: function () {
            $('.show_popover').popover('hide');
            $(this).removeClass('show_popover');
        }
    }, '.service_year');

    $('#calendar').on({
        mouseenter: function () {
            var title = '';
            $(this).addClass('show_tooltip').attr('class').split(' ').forEach(function (item, index) {
                if (item != 'fc-day-grid-event'
                    && item != 'fc-h-event'
                    && item != 'fc-event'
                    && item != 'fc-start'
                    && item != 'fc-end'
                    && item != 'show_tooltip'
                    && item != 'payment_days'
                    && item != 'cal_icon'
                    && item != 'cal_tooltip') {
                    title = item.split('|').join(' ');
                }
            });

            $('.show_tooltip').tooltip({
                title: title,
                placement: 'top',
                container: 'body',
            }).tooltip('show');
        },
        mouseleave: function () {
            $('.show_tooltip').tooltip('hide');
            $(this).removeClass('show_tooltip');
        }
    }, '.cal_tooltip');
}
