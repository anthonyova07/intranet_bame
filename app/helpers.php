<?php

function clear_str($str)
{
    return strtolower(trim($str));
}

function cap_str($str)
{
    return ucwords(clear_str($str));
}

function remove_dashes($str) {
    return str_replace('-', '', $str);
}

function get_status($status)
{
    return $status ? 'A' : 'I';
}

function cod_tel($str)
{
    return substr($str, 0, 3);
}

function tel($str)
{
    return substr($str, 3, 7);
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
            if ($can_access) {
                return false;
            }
        });
    }

    return !$can_access;
}

function generate_pdf($html, $archivo) {
    require_once base_path() . '\vendor\spipu\html2pdf\html2pdf.class.php';
    $html2pdf = new \HTML2PDF('P', 'A4', 'es', true, 'UTF-8', [3, 6, 133, 2]);
    $html2pdf->setDefaultFont('Helvetica');
    $html2pdf->WriteHTML($html);
    $html2pdf->Output($archivo, 'F');
}
