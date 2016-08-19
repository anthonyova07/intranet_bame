<?php

/*
|--------------------------------------------------------------------------
| Controlar los accesos por IP
|--------------------------------------------------------------------------
|
| Agregar en los metodos autorize de los request
/ $ips_permitidas = collect(config('accesos.consultas.encartes.ips_permitidas'));
/ return $ips_permitidas->contains($_SERVER['REMOTE_ADDR']);
|
*/

return [
    'consultas' => [
        'encartes' => [
            'ips_permitidas' => [

            ]
        ]
    ]
];
