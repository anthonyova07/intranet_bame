<?php

function clear_str($str)
{
    return strtolower(trim($str));
}

function cap_str($str)
{
    return ucwords(clear_str($str));
}

function get_status($status)
{
    return $status ? 'A' : 'I';
}

function get_web($web)
{
    return $web ? 'S' : 'N';
}

function can_not_do($permiso)
{
    $can_access = false;

    if (session()->has('menus')) {
        $menus = session()->get('menus');
        $menus->each(function ($menu, $index) use ($permiso, &$can_access) {
            $can_access = $menu->submenus->contains('CODUNI', $permiso);
        });
    }

    return !$can_access;
}
