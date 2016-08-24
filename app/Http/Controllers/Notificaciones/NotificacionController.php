<?php

namespace Bame\Http\Controllers\Notificaciones;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Notificaciones\Notificacion;

class NotificacionController extends Controller
{
    public function getTodas() {
        $noti = new Notificacion;
        if ($noti->count()) {
            return $noti->all()->where('notificado', false)->each(function ($notificacion, $index) {
                $notificacion->titulo = html_entity_decode($notificacion->titulo);
                $notificacion->texto = html_entity_decode($notificacion->texto);
            });
        }
    }

    public function getNotificado($id) {
        $noti = new Notificacion;
        $noti->notified($id);
        $noti->save();
    }
}
