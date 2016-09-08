<?php

namespace Bame\Models\Operaciones;

class TransaccionesCaja
{
    private static $sql;

    public static function addApplicationCodeFilter($codigo_app = '05')
    {
        self::$sql .= ' AND TICACD = \'' . remove_dashes($codigo_app) . '\'';
    }

    public static function addAmountGreaterThanFilter($monto = 0)
    {
        self::$sql .= ' AND TICDCH > ' . remove_dashes($monto);
    }

    public static function addDayGreaterThanFilter($dia)
    {
        self::$sql .= ' AND TICRDD >= ' . remove_dashes($dia);
    }

    public static function addDayLowerThanFilter($dia)
    {
        self::$sql .= ' AND TICRDD <= ' . remove_dashes($dia);
    }

    public static function addMonthFilter($mes)
    {
        self::$sql .= ' AND TICRDM = ' . remove_dashes($mes);
    }

    public static function addYearFilter($anio)
    {
        self::$sql .= ' AND TICRDY = ' . remove_dashes($anio);
    }

    public static function addCustomerFilter($codigo_cliente)
    {
        self::$sql .= ' AND TICOCS = ' . remove_dashes($codigo_cliente);
    }

    public static function all()
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM TICASHH WHERE TICOCS <> 0' . self::$sql;
        $sql .= ' UNION ALL ';
        $sql .= 'SELECT ' . implode(', ', self::getFields()) . ' FROM TICASH WHERE TICOCS <> 0' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        $result = collect($stmt->fetchAll());

        return $result->count() ? $result : false;
    }

    public static function formatAll($transacciones)
    {
        if (!$transacciones) { return false; }

        $transacciones->each(function ($transaccion, $index) {
            $transaccion->ID = $index;

            $transaccion->DESCRIPCION = cap_str($transaccion->DESCRIPCION);
        });

        return $transacciones;
    }

    private static function getFields()
    {
        return [
            'TRIM(TICIDN) IDENTIFICACION',
            'TRIM(\'CARGO POR TRANSFERENCIA\') DESCRIPCION',
            '(TICDCH * TICEXR) MONTO',
            'TRIM(TICCCY) MONEDA',
            '1 CANTIDAD',
            '\'D\' TIPO',
            'TICOCS CODIGO_CLIENTE',
            'TICRDD DIA',
            'TICRDM MES',
            'TICRDY ANIO'
        ];
    }
}
