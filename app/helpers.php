<?php

function clear_str($str)
{
    return strtolower(trim($str));
}

function cap_str($str)
{
    return ucwords(clear_str(htmlentities($str)));
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

function get_notifications($usuario) {
    $usuario = str_replace('.', '_', $usuario);
    $archivo_json = get_noti_path() . $usuario . '.json';

    if (file_exists($archivo_json)) {
        return collect(json_decode(file_get_contents($archivo_json)));
    }

    return collect();
}

function save_notifications($usuario, $notifications) {
    if ($usuario) {
        $usuario = str_replace('.', '_', $usuario);
        $archivo_json = get_noti_path() . $usuario . '.json';
        file_put_contents($archivo_json, $notifications);
    }
}

function get_noti_path() {
    return storage_path() . '\\app\\notifications\\';
}

function format_identification($identificacion) {
    return (strlen(clear_str($identificacion)) == 11) ? (substr($identificacion, 0, 3) . '-' . substr($identificacion, 3, 7) . '-' . substr($identificacion, 10, 11)) : $identificacion;
}

function get_marital_status($id) {
    switch ($id) {
        case 1:
            return 'Soltero(a)';
            break;
        case 2:
            return 'Casado(a)';
            break;
        case 3:
            return 'Divorciado(a)';
            break;
        case 4:
            return 'Viudo(a)';
            break;
        default:
            return 'Otro';
            break;
    }
}

function get_gender($genero) {
    switch ($genero) {
        case 'F':
            return 'Femenino';
            break;
        case 'M':
            return 'Masculino';
            break;
        default:
            return 'Otro';
            break;
    }
}

function get_nationality($codigo_pais) {
    switch ($codigo_pais) {
        case 'DR':
            return 'Dominicano(a)';
            break;
        default:
            return 'Otro';
            break;
    }
}
