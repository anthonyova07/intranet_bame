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
    $str = str_replace('“', '"', $str);
    $str = str_replace('”', '"', $str);
    $str = str_replace('―', '&#8213;', $str);
    $str = str_replace('•', '&#8226;', $str);
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
        'TARDEB' => 'Tarjeta de Débito',
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
        'REV' => 'Reverso',
    ]);

    if (!$form_type) {
        return $form_types;
    }

    return $form_types->get($form_type);
}

function get_currencies($currency = null)
{
    $channels = collect([
        'RD$' => 'Pesos Dominicanos',
        'US$' => 'Dólares Estado Unidenses',
        'EU$' => 'Euros',
    ]);

    if (!$currency) {
        return $channels;
    }

    return $channels->get($currency);
}

function get_ct_dc($type, $plural = true)
{
    switch ($type) {
        case 'CT':
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Reclamación';
            break;
        case 'DC':
            return ($plural ? 'Canales' : 'Canal') . ' de Distribución';
            break;
        case 'VISA':
            return ($plural ? 'Tipos ' : 'Tipo ') . 'de Reclamación VISA';
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

function get_response_term()
{
    return [
        30
    ];
}

function get_claim_types_visa($claim_type = null, $values = [])
{
    $_1 = new stdClass;
    $_1->id = 1;
    $_1->es_name = 'Solicito Copia del Voucher.';
    $_1->es_detail = 'Información no Reconocida.';
    $_1->es_detail_2 = '';
    $_1->en_name = 'I Request copy of the voucher.';
    $_1->en_detail = 'Informaction Not Recognized.';
    $_1->en_detail_2 = '';
    $_1->required_fields = false;

    $_2 = new stdClass;
    $_2->id = 2;
    $_2->es_name = 'Transacción cargada más de una vez.';
    $_2->es_detail = 'Solo autoricé una transacción, pero ({field1}) transacciones fueron cargadas a mi cuenta.';
    $_2->es_detail_2 = '';
    $_2->en_name = 'Unauthorized charges.';
    $_2->en_detail = 'I authorized only one transaction, but ({field1}) changes were billed to my account.';
    $_2->en_detail_2 = '';
    $_2->required_fields = true;

    $_3 = new stdClass;
    $_3->id = 3;
    $_3->es_name = 'Transacción pagada por otros medios.';
    $_3->es_detail = 'La transacción fue pagada en cheque ({field1}), en efectivo ({field2}) con otra tarjeta ({field3}).';
    $_3->es_detail_2 = '(Anexo copia del recibo de efectivo, o cheque cancelado, o estado de cuenta de otra tarjeta).';
    $_3->en_name = 'Paid by other means';
    $_3->en_detail = 'I paid for this charge by check ({field1}), by cash ({field2}) with other card ({field3}).';
    $_3->en_detail_2 = '(Enclosed is copy of my cash receipt, or canceled check or my other card statement).';
    $_3->required_fields = true;

    $_4 = new stdClass;
    $_4->id = 4;
    $_4->es_name = 'No recibí el efectivo solicitado al ATM ({field1}), o sólo recibí una parte ({field2}).';
    $_4->es_detail = '(Anexo copia de voucher nulo)';
    $_4->es_detail_2 = '';
    $_4->en_name = 'Cash not received from ATM ({field1}), or not received the full requested amount ({field2}).';
    $_4->en_detail = '(Enclose null voucher copy)';
    $_4->en_detail_2 = '';
    $_4->required_fields = true;

    $_5 = new stdClass;
    $_5->id = 5;
    $_5->es_name = 'No he participado, ni autorizado los consumos en cuestión y he tenido la tarjeta todo el tiempo en mi poder.';
    $_5->es_detail = '(Anexo copia de estado de cuenta)';
    $_5->es_detail_2 = '';
    $_5->en_name = 'I have not authorized or participated the items in dispute. I have always had the card in my power.';
    $_5->en_detail = '(Enclose copy of account statement)';
    $_5->en_detail_2 = '';
    $_5->required_fields = false;

    $_6 = new stdClass;
    $_6->id = 6;
    $_6->es_name = 'No he recibido Mercancía o Servicio pedido en fecha ({field1}).';
    $_6->es_detail = '';
    $_6->es_detail_2 = '';
    $_6->en_name = 'Merchandise or Service bought on date ({field1}) not received.';
    $_6->en_detail = '';
    $_6->en_detail_2 = '';
    $_6->required_fields = true;

    $_7 = new stdClass;
    $_7->id = 7;
    $_7->es_name = 'Otros {field1}.';
    $_7->es_detail = '';
    $_7->es_detail_2 = '';
    $_7->en_name = 'Others {field1}.';
    $_7->en_detail = '';
    $_7->en_detail_2 = '';
    $_7->required_fields = true;

    $claim_types = collect();

    $claim_types->push($_1);
    $claim_types->push($_2);
    $claim_types->push($_3);
    $claim_types->push($_4);
    $claim_types->push($_5);
    $claim_types->push($_6);
    $claim_types->push($_7);

    if (!$claim_type) {
        return $claim_types;
    }

    $claim = $claim_types->where('id', intval($claim_type))->first();

    if ($claim) {
        switch ($claim->id) {
            case 1:
            case 5:
                return $claim;
                break;
            case 2:
                if (count($values)) {
                    $claim->es_detail = strtr($claim->es_detail, [
                        '{field1}' => strtoupper($values[0])
                    ]);

                    $claim->en_detail = strtr($claim->en_detail, [
                        '{field1}' => strtoupper($values[0])
                    ]);
                }
                return $claim;
                break;
            case 3:
                if (count($values)) {
                    $claim->es_detail = strtr($claim->es_detail, [
                        '{field1}' => strtoupper($values[0]),
                        '{field2}' => strtoupper($values[1]),
                        '{field3}' => strtoupper($values[2]),
                    ]);

                    $claim->en_detail = strtr($claim->en_detail, [
                        '{field1}' => strtoupper($values[0]),
                        '{field2}' => strtoupper($values[1]),
                        '{field3}' => strtoupper($values[2]),
                    ]);
                }
                return $claim;
                break;
            case 4:
                if (count($values)) {
                    $claim->es_name = strtr($claim->es_name, [
                        '{field1}' => strtoupper($values[0]),
                        '{field2}' => strtoupper($values[1]),
                    ]);

                    $claim->en_name = strtr($claim->en_name, [
                        '{field1}' => strtoupper($values[0]),
                        '{field2}' => strtoupper($values[1]),
                    ]);
                }
                return $claim;
                break;
            case 6:
            case 7:
                if (count($values)) {
                    $claim->es_name = strtr($claim->es_name, [
                        '{field1}' => strtoupper($values[0]),
                    ]);

                    $claim->en_name = strtr($claim->en_name, [
                        '{field1}' => strtoupper($values[0]),
                    ]);
                }
                return $claim;
                break;
        }
    }

    return 'Tipo de Reclamación Visa (Invalido)';
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
