<?php

namespace Bame\Models\Clientes;

class Cliente
{
    public static function getByIdentification($identificacion) {
        $sql = 'SELECT ' . implode(', ', self::getFields()) . ' FROM CUMST WHERE CUSLN3 = \'' . remove_dashes($identificacion) . '\' OR CUSIDN = \'' . remove_dashes($identificacion) . '\'';
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getPhotoByIdentification($identificacion)
    {
        $identificacion = format_identification(remove_dashes($identificacion));

        $ced_1 = substr($identificacion, 0, 3);
        $ced_2 = substr($identificacion, 4, 2);
        $ced_3 = substr($identificacion, 6, 2);

        $foto = env('ENCARTES_CARPETA_FOTO') . $ced_1 . '\\' . $ced_2 . '\\' . $ced_3 . '\\' . $identificacion . '.jpg';

        if (!file_exists($foto)) {
            $foto = base_path('\\public\\images\\noFoto.jpg');
        }

        return $foto;
    }

    public static function getByIdentificationAlt($identificacion)
    {
        $sql = 'SELECT ' . implode(', ', self::getAltFields()) . ' FROM BAGRPLIB.CEDPAD WHERE CEDIDN = \'' . remove_dashes($identificacion) . '\'';
        $stmt = app('con_ibs')->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    private static function getFields()
    {
        return [
            'TRIM(CUSIDN) PASAPORTE',
            'TRIM(CUSLN3) CEDULA',
            'CONCAT(CONCAT(TRIM(CUSFNA), \' \'), TRIM(CUSFN2)) NOMBRES',
            'CONCAT(CONCAT(TRIM(CUSLN1), \' \'), TRIM(CUSLN2)) APELLIDOS',
            'TRIM(CUSSEX) SEXO',
            'TRIM(CUSCCS) CODNACION',
            'TRIM(CUSMST) ESTCIVIL',
            'CONCAT(CONCAT(CONCAT(CUSBDD, \'/\'), CONCAT(CUSBDM, \'/\')), CUSBDY) FECHANAC',
            'TRIM(CUSNA2) CALLE',
            'TRIM(CUSNA3) CASA',
            'TRIM(CUSNA4) EDIFICIO',
            'TRIM(CUSPH1) TELEFONO'
        ];
    }

    private static function getAltFields()
    {
        return [
            'TRIM(CEDIDN) CEDULA',
            'CONCAT(CONCAT(TRIM(CEDNO1), \' \'), TRIM(CEDNO2)) NOMBRES',
            'CONCAT(CONCAT(TRIM(CEDAP1), \' \'), TRIM(CEDAP2)) APELLIDOS'
        ];
    }
}
