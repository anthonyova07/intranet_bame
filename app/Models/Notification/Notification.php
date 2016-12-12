<?php

namespace Bame\Models\Notification;

use DateTime;

class Notification
{

    protected $notifications;

    protected $user;

    public function __construct($user = null)
    {
        if ($user) {
            $this->user = $user;
        } else {
            $this->user = session()->get('user');
        }

        $notifications = get_notifications($this->user);

        if ($notifications) {
            $this->notifications = $notifications;
        }
    }

    public function all()
    {
        return $this->notifications;
    }

    public function count() {
        return $this->notifications->count();
    }

    public function notified($id)
    {
        $this->notifications = $this->notifications->each(function ($notificacion, $index) use ($id) {
            if ($notificacion->id == $id) {
                $notificacion->notificado = true;
                return false;
            }
        });
    }

    public static function notify($title, $body, $url = '', $user = null)
    {
        $noti = new self($user);
        $noti->create($title, $body, $url);
        $noti->save();
    }

    public static function notifyUsersByPermission($permission, $title, $body, $url = '')
    {
        $sub_menu = \Bame\Models\Security\SubMenu::where('sub_coduni', $permission)->first();

        if ($sub_menu) {
            $users = \Bame\Models\Security\Access::where('acc_codmen', $sub_menu->sub_codmen)
                ->where('acc_submen', $sub_menu->sub_codigo)->get();

            foreach ($users as $user) {
                self::notify($title, $body, $url, $user->acc_user);
            }
        }

    }

    public function create($titulo, $texto, $url = '')
    {
        $notificacion = new \stdClass;
        $notificacion->id = uniqid();
        $notificacion->titulo = $titulo;
        $notificacion->texto = $texto;
        $notificacion->url = $url;
        $notificacion->creado = (new DateTime)->format('d/m/Y H:i:s');
        $notificacion->notificado = false;
        $this->notifications->push($notificacion);
    }

    public function delete($id)
    {
        $this->notifications = $this->notifications->filter(function ($notificacion, $index) use ($id) {
            return $notificacion->id != $id;
        });
    }

    public function save()
    {
        save_notifications($this->user, $this->notifications->take(-8)->values());
    }
}
