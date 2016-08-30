<?php

namespace Bame\Models\Operaciones\Tdc;

use Bame\Models\Clientes\Cliente;

class Encarte
{
    public $filtros;

    function __construct()
    {
        $this->filtros = collect();
    }

    private static $sql;

    public static function pendingCount()
    {
        $stmt = app('con_itc')->prepare('SELECT COUNT(*) CANTIDAD FROM SADENTR00 WHERE STSEN_ENTR = \'\'');
        $stmt->execute();
        $cantidad = $stmt->fetch()->CANTIDAD;
        return $cantidad ? $cantidad : 0;
    }

    public static function addIdentificationFilter($identificacion)
    {
        self::$sql .= ' AND IDENT_ENTR = \'' . remove_dashes($identificacion) . '\'';
    }

    public static function addCreditCardFilter($credit_card)
    {
        self::$sql .= ' AND NUMTA_ENTR = ' . remove_dashes($credit_card);
    }

    public static function addFechaFilter($fecha)
    {
        self::$sql .= ' AND FECEN_ENTR = ' . remove_dashes($fecha);
    }

    public static function allPending() {
        self::$sql .= ' AND STSEN_ENTR = \'\'';
    }

    public static function orderByCreditCard()
    {
        self::$sql .= ' ORDER BY NUMTA_ENTR';
    }

    public static function all()
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM SADENTR00 WHERE NUMTA_ENTR <> 0' . self::$sql;

        self::$sql = '';

        $stmt = app('con_itc')->prepare($sql);
        $stmt->execute();
        $result = collect($stmt->fetchAll());

        return $result->count() ? $result : false;
    }

    public static function formatAll($tarjetas)
    {
        if (!$tarjetas) { return false; }

        $tarjetas->each(function ($tarjeta, $index) {
            $tarjeta->TARJETA = clear_str($tarjeta->TARJETA);
            $tarjeta->TARJETA = substr($tarjeta->TARJETA, 0, 4) . '-****-****-' . substr($tarjeta->TARJETA, 12, 4);
            $tarjeta_pdf = str_replace('*', 'x', $tarjeta->TARJETA);

            $cedula_buscar = $tarjeta->CEDULA;
            $tarjeta->CEDULA = clear_str($tarjeta->CEDULA);
            $tarjeta->CEDULA = format_identification($tarjeta->CEDULA);

            $tarjeta->NOMBRE1 = cap_str($tarjeta->NOMBRE1);
            $tarjeta->NOMBRE2 = cap_str($tarjeta->NOMBRE2);

            $tarjeta->APELLIDO1 = cap_str($tarjeta->APELLIDO1);
            $tarjeta->APELLIDO2 = cap_str($tarjeta->APELLIDO2);

            $tarjeta->CREDITO_RD = number_format($tarjeta->CREDITO_RD, 2);
            $tarjeta->CREDITO_US = number_format($tarjeta->CREDITO_US, 2);

            $tarjeta->CICLO = intval($tarjeta->CICLO);

            $tarjeta->EDIFICIO = cap_str($tarjeta->EDIFICIO);
            $tarjeta->BARRIO = cap_str($tarjeta->BARRIO);
            $tarjeta->CALLE = cap_str($tarjeta->CALLE);
            $tarjeta->CIUDAD = cap_str($tarjeta->CIUDAD);

            $tarjeta->CODRES = clear_str($tarjeta->CODRES);
            $tarjeta->TELRES = clear_str($tarjeta->TELRES);

            if ($tarjeta->CODRES == 0) {
                $num_encontrado = self::getAltPhone('CUSHPN', $cedula_buscar);
                if ($num_encontrado) {
                    $tarjeta->CODRES = cod_tel($num_encontrado);
                    $tarjeta->TELRES = tel($num_encontrado);
                }
            }

            $tarjeta->CODOFICINA = clear_str($tarjeta->CODOFICINA);
            $tarjeta->TELOFICINA = clear_str($tarjeta->TELOFICINA);
            $tarjeta->EXTENSION = clear_str($tarjeta->EXTENSION);

            if ($tarjeta->CODOFICINA == 0) {
                $num_encontrado = self::getAltPhone('CUSPHN', $cedula_buscar);
                if ($num_encontrado) {
                    $tarjeta->CODOFICINA = cod_tel($num_encontrado);
                    $tarjeta->TELOFICINA = tel($num_encontrado);
                }
            }

            $tarjeta->CODCELULAR = clear_str($tarjeta->CODCELULAR);
            $tarjeta->TELCELULAR = clear_str($tarjeta->TELCELULAR);

            if ($tarjeta->CODCELULAR == 0) {
                $num_encontrado = self::getAltPhone('CUSPH1', $cedula_buscar);
                if ($num_encontrado) {
                    $tarjeta->CODCELULAR = cod_tel($num_encontrado);
                    $tarjeta->TELCELULAR = tel($num_encontrado);
                }
            }

            $tarjeta->COMENTARIO = cap_str($tarjeta->COMENTARIO);

            $tarjeta->TIPO = cap_str($tarjeta->TIPO);
            $tarjeta->TIPOD = cap_str($tarjeta->TIPOD);

            $tarjeta->FOTO = Cliente::getPhotoByIdentification($tarjeta->CEDULA);
        });

        return $tarjetas;
    }

    public static function generatePdf($html, $archivo)
    {
        generate_pdf($html, $archivo);
    }

    /*
    * CUSHPN Residencial
    * CUSPHN Oficina
    * CUSPH1 Celular
    */
    public static function getAltPhone($campo, $cedula)
    {
        $sql = 'SELECT ' . $campo . ' VALOR FROM BADCYFILES.CUMST WHERE CUSLN3 = :p1_cedula or CUSIDN = :p2_cedula';
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute([
            ':p1_cedula' => $cedula,
            ':p2_cedula' => $cedula,
        ]);
        $result = $stmt->fetch();
        return $result ? $result->VALOR : false;
    }

    public static function getCreditCardNumbers($tarjetas)
    {
        return $tarjetas->pluck('TARJETA')->toArray();
    }

    public static function markCreditCards($tarjetas, $estatus = 'P') {
        $sql = 'UPDATE SADENTR00 SET STSEN_ENTR = \'' . $estatus . '\' WHERE NUMTA_ENTR IN (\'' . implode('\', \'', $tarjetas) . '\')';
        return app('con_itc')->prepare($sql)->execute();
    }

    private static function getFields()
    {
        return [
            'TRIM(NUMTA_ENTR) TARJETA',
            'TRIM(IDENT_ENTR) CEDULA',
            'TRIM(NOMB1_ENTR) NOMBRE1',
            'TRIM(NOMB2_ENTR) NOMBRE2',
            'TRIM(APEL1_ENTR) APELLIDO1',
            'TRIM(APEL2_ENTR) APELLIDO2',
            'TRIM(LIMRD_ENTR) CREDITO_RD',
            'TRIM(LIMUS_ENTR) CREDITO_US',
            'TRIM(CICLO_ENTR) CICLO',
            'TRIM(EDIFI_ENTR) EDIFICIO',
            'TRIM(BARRI_ENTR) BARRIO',
            'TRIM(CALLE_ENTR) CALLE',
            'TRIM(CIUDA_ENTR) CIUDAD',
            'TRIM(CODT1_ENTR) CODRES',
            'TRIM(TELRE_ENTR) TELRES',
            'TRIM(CODT2_ENTR) CODOFICINA',
            'TRIM(TELOF_ENTR) TELOFICINA',
            'TRIM(EXTEL_ENTR) EXTENSION',
            'TRIM(CODT3_ENTR) CODCELULAR',
            'TRIM(CELUL_ENTR) TELCELULAR',
            'TRIM(COMEN_ENTR) COMENTARIO',
            'TRIM((SELECT NOMBR_DESC FROM SATDESC00 WHERE PREFI_DESC = \'SAT_TSOL\' AND CODIG_DESC = TIPSO_ENTR)) AS TIPO',
            'TRIM((SELECT DESCR_BIN FROM ENCARTBIN WHERE NUMTA_BIN = SUBSTR(NUMTA_ENTR,1,6))) AS TIPOD'
        ];
    }
}
