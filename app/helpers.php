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

// I: envía el fichero al navegador de forma que se usa la extensión (plug in) si está disponible.
// D: envía el fichero al navegador y fuerza la descarga del fichero con el nombre especificado por name.
// F: guarda el fichero en un fichero local de nombre name.
// S: devuelve el documento como una cadena.
function generate_pdf($html, $archivo, $destino = 'F') {
    require_once base_path() . '\vendor\spipu\html2pdf\html2pdf.class.php';
    $html2pdf = new \HTML2PDF('P', 'A4', 'es', true, 'UTF-8', [3, 6, 133, 2]);
    $html2pdf->setDefaultFont('Helvetica');
    $html2pdf->WriteHTML($html);
    $html2pdf->Output($archivo, $destino);
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

function format_date($fecha) {
    if (strlen($fecha) == 8) {
        $a = substr($fecha, 0, 4);
        $m = substr($fecha, 4, 2);
        $d = substr($fecha, 6, 2);

        $fecha = $d . '/' . $m . '/' . $a;
    }

    return $fecha;
}

function format_time($time) {
    if (strlen($time) == 5) {
        $time = '0' . $time;
    }

    if (strlen($time) == 6) {
        $h = substr($time, 0, 2);
        $m = substr($time, 2, 2);
        $s = substr($time, 4, 2);

        $time = $h . ':' . $m . ':' . $s;
    }

    return $time;
}

function format_datetime_to_file($date, $time)
{
    return str_replace('/', '_', format_date($date)) . '_' . str_replace(':', '_', format_time($time));
}

function get_months($mes = false)
{
    $meses = collect([1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre']);

    if (!$mes) {
        return $meses;
    }

    return $meses->get((int) $mes);
}

function get_identification_types($tipo_identificacion = false)
{
    $tipos_identificacion = collect(['C' => 'Cédula', 'N' => 'RNC', 'O' => 'OffShore', 'P' => 'Pasaporte']);

    if (!$tipo_identificacion) {
        return $tipos_identificacion;
    }

    return $tipos_identificacion->get($tipo_identificacion);
}
