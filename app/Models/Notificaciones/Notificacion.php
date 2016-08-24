<?php

namespace Bame\Models\Notificaciones;

use DateTime;

class Notificacion
{

    protected $notificaciones;

    public function __construct()
    {
        $notificaciones = get_notifications(session('usuario'));
        if ($notificaciones) {
            $this->notificaciones = $notificaciones;
        }
    }

    public function all()
    {
        return $this->notificaciones;
    }

    public function notified($id)
    {
        $this->notificaciones = $this->notificaciones->each(function ($notificacion, $index) use ($id) {
            if ($notificacion->id == $id) {
                $notificacion->notificado = true;
                return false;
            }
        });
    }

    public function create($texto)
    {
        $notificacion = new \stdClass;
        $notificacion->id = uniqid();
        $notificacion->texto = cap_str($texto);
        $notificacion->notificado = false;
        $notificacion->creado = (new DateTime)->format('Y-m-d H:i:s');
        $this->notificaciones->push($notificacion);
    }

    public function delete($id)
    {
        $this->notificaciones = $this->notificaciones->filter(function ($notificacion, $index) use ($id) {
            return $notificacion->id != $id;
        });
    }

    public function save()
    {
        save_notifications(session('usuario'), $this->notificaciones);
    }
}
