<?php

namespace Bame\Models\Notificaciones;

use DateTime;

class Notificacion
{

    protected $notificaciones;

    protected $usuario;

    public function __construct($usuario = null)
    {
        if ($usuario) {
            $this->usuario = $usuario;
        } else {
            $this->usuario = session('usuario');
        }

        $notificaciones = get_notifications($usuario);

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

    public function create($titulo, $texto)
    {
        $notificacion = new \stdClass;
        $notificacion->id = uniqid();
        $notificacion->titulo = cap_str($titulo);
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
        save_notifications($this->usuario, $this->notificaciones);
    }
}
