function desktop_noty(title, body) {
    var options = {
        body: body,
        icon: $('body').attr('icon-noti')
    }
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification('Bancamérica Intranet - ' + title, options);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification('Bancamérica Intranet - ' + title, options);
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
                desktop_noty(notificacion.titulo, notificacion.texto);
                $.ajax({
                    url: ruta_base + '/notification/notified/' + notificacion.id,
                });
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
