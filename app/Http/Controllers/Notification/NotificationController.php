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

    public function allGlobal(Request $request) {
        $noti = new Notification('global');

        $ids = collect($request->cookie('ids_notifications'));

        if ($noti->count()) {

            $notifications = $noti->all()->filter(function ($notification, $index) use ($ids) {
                if (!$ids->contains($notification->id)) {
                    $ids->push($notification->id);
                    return true;
                }

                return false;
            });

            $ids_cookies = cookie('ids_notifications', $ids, 10080);

            return response()->json($notifications)->cookie($ids_cookies);
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
