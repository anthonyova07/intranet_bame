<?php

function remove_accents($str)
{
    $not_allowed= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹", "ñ", "Ñ");
    $allowed= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E", "n", "N");
    return str_replace($not_allowed, $allowed ,$str);
}

function gesti_doc_back_folder($folders)
{
    $folders = explode('\\', $folders);

    $folders = array_slice($folders, 0, count($folders) - 1);

    return implode('\\', $folders);
}

function get_department_name($department)
{
    switch ($department) {
        case 'marketing':
            return 'Mercadeo';
            break;
        case 'human_resources':
            return 'Recursos Humanos';
            break;
        case 'process':
            return 'Procesos';
            break;
        case 'compliance':
            return 'Cumplimiento';
            break;
    }
}

function get_file_icon($ext)
{
    switch ($ext) {
        case 'png':
        case 'jpg':
            $name = 'image';
            break;
        case 'doc':
        case 'docx':
            $name = 'word';
            break;
        case 'csv':
        case 'xls':
        case 'xlsx':
            $name = 'excel';
            break;
        case 'ppt':
        case 'pptx':
        case 'ppsx':
            $name = 'powerpoint';
            break;
        case 'pst':
            $name = 'correo';
            break;
        case 'pub':
            $name = 'publisher';
            break;
        case 'mp3':
            $name = 'music';
            break;
        case 'mp4':
        case 'avi':
            $name = 'video';
            break;
        case 'mpp':
            $name = 'project';
            break;
        case 'one':
            $name = 'onenote';
            break;
        case 'pdf':
            $name = 'pdf';
            break;
        case 'directory':
            $name = 'directory';
            break;
        default:
            $name = 'default';
            break;
    }

    if (!file_exists(public_path('images\\' . $ext . '.png'))) {
        $ext = 'default';
    }

    $icon = route('home') . '/images/' . $name . '.png';
    return $icon;
}

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
            $can_access = $menu->submenus->contains('sub_coduni', $permiso);
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

function get_notifications($user) {
    $user = str_replace('.', '_', $user);
    $archivo_json = get_noti_path() . $user . '.json';

    if (file_exists($archivo_json)) {
        return collect(json_decode(file_get_contents($archivo_json)));
    }

    return collect();
}

function save_notifications($user, $notifications) {
    if ($user) {
        $user = str_replace('.', '_', $user);
        $archivo_json = get_noti_path() . $user . '.json';
        file_put_contents($archivo_json, $notifications);
    }
}

function get_noti_path() {
    $path = storage_path() . '\\app\\notifications\\';

    if (!file_exists($path)) {
        mkdir($path);
    }

    return $path;
}

function format_identification($identification) {
    $idn = $identification;

    if (strlen(clear_str($identification)) == 11) {
        $idn = substr($identification, 0, 3);
        $idn .= '-';
        $idn .= substr($identification, 3, 7);
        $idn .= '-';
        $idn .= substr($identification, 10, 11);

        return $idn;
    }

    return $idn;
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
        case 'f':
            return 'Femenino';
            break;
        case 'm':
            return 'Masculino';
            break;
        default:
            return 'Otro';
            break;
    }
}

function get_nationality($codigo_pais) {
    switch ($codigo_pais) {
        case 'dr':
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

function get_identification_types($identification_type = false)
{
    $identification_types = collect([
        'C' => 'Cédula',
        'N' => 'RNC',
        'O' => 'OffShore',
        'P' => 'Pasaporte',
        'NI' => 'Ninguna'
    ]);

    if (!$identification_type) {
        return $identification_types;
    }

    return $identification_types->get($identification_type);
}

function get_relationship_types($relation_type = false)
{
    $relation_types = collect([
        'P' => 'Primo/a',
        'PA' => 'Padre',
        'MA' => 'Madre',
        'HE' => 'Hermano/a',
        'E' => 'Esposo/a',
        'A' => 'Abuelo/a',
        'H' => 'Hijo/a',
        'SO' => 'Sobrino/a',
        'AH' => 'Ahijado/a',
        'AM' => 'Amigo/a',
        'NI' => 'Nieto/a',
        'OT' => 'Otro'
    ]);

    if (!$relation_type) {
        return $relation_types;
    }

    return $relation_types->get($relation_type);
}

function do_log($description) {
    $log = new \Bame\Models\Security\Log;
    $log->user = session()->get('user');
    $log->description = $description;
    $log->save();
}

function get_news_types($type = false)
{
    $meses = collect(['C' => 'Columna', 'N' => 'Noticia', 'B' => 'Banner']);

    if (!$type) {
        return $meses;
    }

    return $meses->get($type);
}

function get_extensions_file($file_name) {
    $name_parts = explode('.', $file_name);
    return array_pop($name_parts);
}

function clear_tag($str) {
    $str = str_replace('―', '&#8213;', $str);
    $str = str_replace('•', '&#8226;', $str);
    $str = str_replace('', '&#8226;', $str);
    return strip_tags($str, '<br><u><sub><sup><s><b><i><ol><ul><li>');
}

function get_coco_info() {
    $archivo_json = get_coco_path() . 'coco.json';

    if (file_exists($archivo_json)) {
        return json_decode(file_get_contents($archivo_json));
    }

    return null;
}

function save_coco($coco) {
    $archivo_json = get_coco_path() . 'coco.json';
    file_put_contents($archivo_json, $coco);
}

function get_coco_path() {
    $path = storage_path() . '\\app\\coco\\';

    if (!file_exists($path)) {
        mkdir($path);
    }

    return $path;
}

function remove_n_r($str, $use_nl2br = true) {
    $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
    $reemplazar=array("", "", "", "");

    if ($use_nl2br) {
        return str_ireplace($buscar, $reemplazar, nl2br($str));
    }

    return str_ireplace($buscar, $reemplazar, $str);
}

function get_offices($office = null)
{
    $offices = collect([
        '1' => 'Oficina Principal',
        // '2' => 'No Existe',
        '3' => 'Bella Vista',
        '4' => 'Blue Mall',
        '5' => 'Lope de Vega',
        '6' => 'San Vicente',
        '7' => 'Barahona',
        '8' => 'Neyba',
        '9' => 'Vicente Noble',
    ]);

    if (!$office) {
        return $offices;
    }

    return $offices->get($office);
}

function get_product_types($product = null)
{
    $product_types = collect([
        'TARCRE' => 'Tarjeta de Crédito',
        // 'TARDEB' => 'Tarjeta de Débito',
        'CUECOR' => 'Cuenta Corriente',
        'CUEAHO' => 'Cuenta Ahorro',
        'CERDEP' => 'Certificado de Depósitos',
        'PRECOM' => 'Préstamo Comercial',
        'PRECON' => 'Préstamo Consumo',
        'PREHIP' => 'Préstamo Hipotecario',
    ]);

    if (!$product) {
        return $product_types;
    }

    return $product_types->get($product);
}

function get_form_types($form_type = null)
{
    $form_types = collect([
        'NIN' => 'Ninguno',
        'CON' => 'Consumo',
        'FRA' => 'Fraude',
        'CAI' => 'Cargos Internos',
    ]);

    if (!$form_type) {
        return $form_types;
    }

    return $form_types->get($form_type);
}

function get_claim_results($claim_result = null)
{
    $claim_results = collect([
        'F' => 'Favorable',
        'D' => 'Desfavorable',
        'P' => 'Pendiente',
    ]);

    if (!$claim_result) {
        return $claim_results;
    }

    return $claim_results->get($claim_result);
}

function get_currencies($currency = null)
{
    $channels = collect([
        'RD$' => 'Pesos Dominicanos',
        'US$' => 'Dólares Estado Unidenses',
        // 'EU$' => 'Euros',
    ]);

    if (!$currency) {
        return $channels;
    }

    return $channels->get($currency);
}

function get_param($type, $plural = true)
{
    switch ($type) {
        case 'CT': //claim_type
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Reclamación';
            break;
        case 'DC': //distribution_channel
            return ($plural ? 'Canales ' : 'Canal ') . 'de Distribución';
            break;
        case 'TDC': //claim_type_tdc
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Reclamación Tarjeta';
            break;
        case 'KP': // kind_person
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Persona';
            break;
        case 'CS': //claim_status
            return ($plural ? 'Estatus ' : 'Estatus ') . 'de Reclamaciones';
            break;
        case 'PS': //products_services
            return 'Productos y Servicios';
            break;
    }
}

function get_proreq_param($type, $plural = true)
{
    switch ($type) {
        case 'TIPSOL': //TIPO DE SOLICITUD
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Solicitud';
            break;
        case 'EST': //TIPO DE SOLICITUD
            return ($plural ? 'Estatus' : 'Estatus');
            break;
        case 'PRO': //TIPO DE SOLICITUD
            return ($plural ? 'Procesos' : 'Proceso');
            break;
    }
}

function get_next_claim_number($last_claim_number)
{
    $date = null;

    if ($last_claim_number) {
        $parts = explode('-', $last_claim_number);

        $year = $parts[0];
        $month = $parts[1];
        $day = $parts[2];
        $sequence = $parts[3];

        $date = $year . '-' . $month . '-' . $day;
    }

    $date_current = (new \DateTime)->format('Y-m-d');

    if ($date == $date_current) {
        $number = $date_current . '-' . (str_pad((intval($sequence) + 1), 2, '0', STR_PAD_LEFT));
    } else {
        $number = $date_current . '-01';
    }

    return $number;
}

function get_next_request_number()
{
    $date = null;

    $last_process_request = \Bame\Models\Process\Request\ProcessRequest::orderBy('created_at', 'desc')->first();
    $last_request_number = $last_process_request ? $last_process_request->reqnumber : null;

    if ($last_request_number) {
        $parts = explode('-', $last_request_number);

        $year = $parts[0];
        $month = $parts[1];
        $day = $parts[2];
        $sequence = $parts[3];

        $date = $year . '-' . $month . '-' . $day;
    }

    $date_current = (new \DateTime)->format('Y-m-d');

    if ($date == $date_current) {
        $number = $date_current . '-' . (str_pad((intval($sequence) + 1), 2, '0', STR_PAD_LEFT));
    } else {
        $number = $date_current . '-01';
    }

    return $number;
}

function get_response_term()
{
    return [
        30
    ];
}

function str_field($str, $fields, $to_str, $id)
{
    $total_fields = substr_count($str, '{field');

    if ($total_fields > 0) {
        for ($i = 0; $i < $total_fields; $i++) {
            if ($to_str) {
                $str = str_replace('{field' . ($i + 1) . '}', strtoupper($fields[$i]), $str);
            } else {
                $str = str_replace('{field' . ($i + 1) . '}', '<b><input type="text" name="fields_' . $id . '[]"></b>', $str);
            }
        }
    }

    return $str;
}

function field_to_str($str, $fields)
{
    return str_field($str, $fields, true, '');
}

function str_to_field($str, $id)
{
    return str_field($str, [], false, $id);
}

function calculate_year_of_service($date, $with_diff = false)
{
    if (!is_null($date)) {
        $parts = explode('/', $date);
        $current_date = new \DateTime;

        $service_compare_date = new \Datetime($current_date->format('Y') . "-{$parts[1]}-{$parts[0]} 23:59:59");

        $service_date = new \Datetime(trim($parts[2]) . "-{$parts[1]}-{$parts[0]} 23:59:59");

        $diff = $service_date->diff($current_date);

        if ($with_diff) {
            if ($diff->y > 0) {
                return $diff->y == 1 ? ($diff->y . ' año'):($diff->y . ' años');
            } else if ($diff->m > 0) {
                return $diff->m == 1 ? ($diff->m . ' mes'):($diff->m .' meses');
            } else {
                return $diff->d == 1 ? ($diff->d . ' día'):($diff->d . ' días');
            }
        }

        // dd($service_compare_date > $current_date, $service_compare_date, $current_date);

        if ($service_compare_date > $current_date) {
            return ($diff->y + 1) == 1 ? (($diff->y + 1) . ' año'):(($diff->y + 1) . ' años');
        } else {
            // return $diff->y == 1 ? ($diff->y . ' año'):($diff->y . ' años');
            $str = '';

            if ($diff->y > 0) {
                $str .= $diff->y == 1 ? ($diff->y . ' año '):($diff->y . ' años ');
            }

            if ($diff->m > 0) {
                $str .= $diff->m == 1 ? ($diff->m . ' mes '):($diff->m .' meses ');
            }

            if ($diff->d > 0) {
                $str .= $diff->d == 1 ? ($diff->d . ' día '):($diff->d . ' días ');
            }

            return $str;
        }
    }
}

function datetime()
{
    return new \DateTime;
}

function get_employee_name_photo($code, $gender, $just_name = false)
{
    $file = public_path() . '\files\employee_images\\' . $code;

    if ($just_name) {
        if (file_exists($file . '.jpg')) {
            return $code . '.jpg';
        }

        if (file_exists($file . '.png')) {
            return $code . '.png';
        }

        return 'no_existe';
    }

    $id = uniqid();

    if (file_exists($file . '.jpg')) {
        return $code . '.jpg?' . $id;
    }

    if (file_exists($file . '.png')) {
        return $code . '.png?' . $id;
    }

    return $gender . '.jpg';
}

function get_treasury_rate_types($type = null)
{
    $types = collect([
        'P' => 'Pasivo',
        'A' => 'Activo',
    ]);

    if (!$type) {
        return $types;
    }

    return $types->get($type);
}

function get_treasury_rate_contents($content = null)
{
    $contents = collect([
        'V' => 'Valores',
        'R' => 'Rangos',
        'U' => 'Único',
    ]);

    if (!$content) {
        return $contents;
    }

    return $contents->get($content);
}

function get_employee_params($param = null)
{
    $params = collect([
        'DEP' => 'Departmento',
        'POS' => 'Posición',
    ]);

    if (!$param) {
        return $params;
    }

    return $params->get($param);
}

function get_marital($marital = null)
{
    $maritals = collect([
        1 => 'Soltero(a)',
        2 => 'Casado(a)',
        3 => 'Divorciado(a)',
        4 => 'Viudo(a)',
        5 => 'Otro',
    ]);

    if (!$marital) {
        return $maritals;
    }

    return $maritals->get($marital);
}

function get_tdc_products($product = null)
{
    $products = collect([
        'VC' => 'Visa Clásica',
        'VG' => 'Visa Gold',
        'VP' => 'Visa Platinum',
        'VS' => 'Visa Signature',
        'VCO' => 'Visa Combustible',
        'VE' => 'Visa Empresarial',
    ]);

    if (!$product) {
        return $products;
    }

    return $products->get($product);
}

function get_next_request_tdc_number()
{
    $date = null;

    $last_process_request = \Bame\Models\Customer\Requests\Tdc\TdcRequest::orderBy('created_at', 'desc')->first();
    $last_request_number = $last_process_request ? $last_process_request->reqnumber : null;

    if ($last_request_number) {
        $parts = explode('-', $last_request_number);

        $year = $parts[0];
        $month = $parts[1];
        $day = $parts[2];
        $sequence = $parts[3];

        $date = $year . '-' . $month . '-' . $day;
    }

    $date_current = (new \DateTime)->format('Y-m-d');

    if ($date == $date_current) {
        $number = $date_current . '-' . (str_pad((intval($sequence) + 1), 3, '0', STR_PAD_LEFT));
    } else {
        $number = $date_current . '-001';
    }

    return $number;
}
