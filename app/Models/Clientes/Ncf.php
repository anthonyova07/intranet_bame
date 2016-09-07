<?php

namespace Bame\Models\Clientes;

class Ncf
{
    private static $sql;

    public static function get($factura)
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM BACNCFE,CUMST WHERE ENCCLI = CUSCUN AND ENCFACT = ' . remove_dashes($factura);
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function format($ncf) {
        $ncf->NOMBRE = cap_str($ncf->NOMBRE);

        $ncf->MONTO = number_format($ncf->MONTO, 2);
        $ncf->IMPUESTO = number_format($ncf->IMPUESTO, 2);

        return $ncf;
    }

    public static function addClientCodeFilter($codigo)
    {
        self::$sql .= ' AND ENCCLI = \'' . remove_dashes($codigo) . '\'';
    }

    public static function addProductFilter($producto)
    {
        self::$sql .= ' AND ENCCTA = ' . remove_dashes($producto);
    }

    public static function addMonthProcessFilter($mes)
    {
        self::$sql .= ' AND ENCMESP = ' . remove_dashes($mes);
    }

    public static function addYearProcessFilter($anio)
    {
        self::$sql .= ' AND ENCANIOP = ' . remove_dashes($anio);
    }

    public static function addNcfFilter($ncf)
    {
        self::$sql .= ' AND ENCNCF = \'' . remove_dashes($ncf) . '\'';
    }

    public static function orderByNcf()
    {
        self::$sql .= ' ORDER BY ENCNCF';
    }

    public static function all()
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM BACNCFE,CUMST WHERE ENCCLI = CUSCUN AND ENCSTS = \'A\'' . self::$sql;

        self::$sql = '';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        $result = collect($stmt->fetchAll());

        return $result->count() ? $result : false;
    }

    public static function formatAll($ncfs)
    {
        if (!$ncfs) { return false; }

        $ncfs->each(function ($ncf, $index) {
            $ncf->NOMBRE = cap_str($ncf->NOMBRE);

            $ncf->MONTO = number_format($ncf->MONTO, 2);
            $ncf->IMPUESTO = number_format($ncf->IMPUESTO, 2);
        });

        return $ncfs;
    }

    public static function cancel($ncf)
    {
        $sql = 'UPDATE BACNCFE SET ENCSTS= \'R\' WHERE ENCNCF = \'' . $ncf . '\'';

        return app('con_ibs')->prepare($sql)->execute();
    }

    private static function getFields()
    {
        return [
            'TRIM(ENCFACT) FACTURA',
            'TRIM(ENCCLI) CODIGO_CLIENTE',
            'TRIM(CUSNA1) NOMBRE',
            'TRIM(ENCCTA) PRODUCTO',
            'TRIM(ENCNCF) NCF',
            'TRIM(ENCMESP) MES_PROCESO',
            'TRIM(ENCANIOP) ANIO_PROCESO',
            'TRIM(ENCDIAG) DIA_GENERADO',
            'TRIM(ENCMESG) MES_GENERADO',
            'TRIM(ENCANIOG) ANIO_GENERADO',
            'TRIM(ENCMONTO) MONTO',
            'TRIM(ENCREIM) IMPUESTO'
        ];
    }
}
