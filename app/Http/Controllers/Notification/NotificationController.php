<?php

namespace Bame\Http\Controllers\Notification;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Notification\Notification;

class NotificationController extends Controller
{
    public function all() {
        $noti = new Notification;
        if ($noti->count()) {
            return $noti->all()->where('notificado', false)->each(function ($notificacion, $index) {
                $notificacion->titulo = html_entity_decode($notificacion->titulo);
                $notificacion->texto = html_entity_decode($notificacion->texto);
            });
        }
    }

    public function notified($id) {
        $noti = new Notification;
        $noti->notified($id);
        $noti->save();
    }

    public function delete($id) {
        $noti = new Notification;
        $noti->delete($id);
        $noti->save();
    }
}
