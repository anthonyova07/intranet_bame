<?php

namespace Bame\Models\Clientes;

class NcfDetalle
{
    public static function get($factura, $secuencia)
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM BACNCFD WHERE DETFAC = ' . remove_dashes($factura) . ' AND DETSEC = ' . remove_dashes($secuencia);
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function all($factura, $activos = false)
    {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM BACNCFD WHERE ' . ($activos ? 'DEASTS = \'A\' AND ':'') . 'DETFAC = \'' . $factura . '\' ORDER BY DETSEC';

        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        $result = collect($stmt->fetchAll());

        return $result->count() ? $result : false;
    }

    public static function formatAll($ncfs)
    {
        if (!$ncfs) { return false; }

        $ncfs->each(function ($ncf, $index) {
            $ncf->DESCRIPCION = cap_str($ncf->DESCRIPCION);

            $ncf->CANTIDAD = number_format($ncf->CANTIDAD);
            $ncf->MONTO = number_format($ncf->MONTO, 2);
        });

        return $ncfs;
    }

    public static function cancel($factura, $secuencia)
    {
        $monto = self::get($factura, $secuencia)->MONTO;

        $sql = 'UPDATE BACNCFE SET ENCMONTO = ENCMONTO - ' . $monto . ' WHERE ENCFACT = ' . $factura;

        app('con_ibs')->prepare($sql)->execute();

        $sql = 'UPDATE BACNCFD SET DEASTS= \'R\' WHERE DETFAC = ' . $factura . ' AND DETSEC = ' . $secuencia;

        return app('con_ibs')->prepare($sql)->execute();
    }

    public static function active($factura, $secuencia)
    {
        $monto = self::get($factura, $secuencia)->MONTO;

        $sql = 'UPDATE BACNCFE SET ENCMONTO = ENCMONTO + ' . $monto . ' WHERE ENCFACT = ' . $factura;

        app('con_ibs')->prepare($sql)->execute();

        $sql = 'UPDATE BACNCFD SET DEASTS= \'A\' WHERE DETFAC = ' . $factura . ' AND DETSEC = ' . $secuencia;

        return app('con_ibs')->prepare($sql)->execute();
    }

    public static function generatePdf($html, $archivo)
    {
        generate_pdf($html, $archivo);
    }

    private static function getFields()
    {
        return [
            'TRIM(DETCANT) CANTIDAD',
            'TRIM(DETFAC) FACTURA',
            'TRIM(DETCTA) PRODUCTO',
            'TRIM(DETSEC) SECUENCIA',
            'TRIM(DETDESC) DESCRIPCION',
            'TRIM(DETCCY) MONEDA',
            'TRIM(DETTAS) TAZA',
            'TRIM(DETMTO) MONTO',
            'TRIM(DETDIA) DIA_GENERADO',
            'TRIM(DETMES) MES_GENERADO',
            'TRIM(DETANIO) ANIO_GENERADO',
            'TRIM(DEASTS) ESTATUS'
        ];
    }
}
