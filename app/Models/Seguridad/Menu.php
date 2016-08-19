<?php

namespace Bame\Models\Seguridad;

class Menu
{
    public static function all()
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM BADCYFILES.SRLMENU ORDER BY DESCRIPCION');
        $stmt->execute();
        return collect($stmt->fetchAll());
    }

    public static function get($codigo)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM BADCYFILES.SRLMENU WHERE MEN_CODIGO = :codigo');
        $stmt->execute([
            ':codigo' => $codigo,
        ]);
        return $stmt->fetch();
    }

    public static function getByIds($ids) {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM BADCYFILES.SRLMENU WHERE MEN_CODIGO IN (' . implode(', ', $ids) . ')');
        $stmt->execute();
        return collect($stmt->fetchAll());
    }

    public static function create($descripcion, $estatus, $web)
    {
        $stmt = app('con_ibs')->prepare('INSERT INTO BADCYFILES.SRLMENU (MEN_BANCO, MEN_CODIGO, MEN_DESCRI, MEN_ESTATU, MEN_WEB) VALUES(1, :codigo, :descripcion, :estatus, :web)');
        $stmt->execute([
            ':codigo' => self::getNewCode(),
            ':descripcion' => cap_str($descripcion),
            ':estatus' => get_status($estatus),
            ':web' => get_web($web),
        ]);
    }

    public static function update($descripcion, $estatus, $web, $codigo) {
        $stmt = app('con_ibs')->prepare('UPDATE BADCYFILES.SRLMENU SET MEN_DESCRI = :descripcion, MEN_ESTATU = :estatus, MEN_WEB = :web WHERE MEN_CODIGO = :codigo');
        $stmt->execute([
            ':descripcion' => cap_str($descripcion),
            ':estatus' =>  get_status($estatus),
            ':web' => get_web($web),
            ':codigo' => $codigo,
        ]);
    }

    public static function getNewCode()
    {
        $stmt = app('con_ibs')->prepare('SELECT MEN_CODIGO CODIGO FROM BADCYFILES.SRLMENU ORDER BY MEN_CODIGO DESC FETCH FIRST 1 ROWS ONLY');
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? intval($result->CODIGO) + 1 : 1;
    }

    private static function getFields()
    {
        return [
            'MEN_CODIGO CODIGO',
            'MEN_DESCRI DESCRIPCION',
            'MEN_ESTATU ESTATU',
            'MEN_WEB WEB'
        ];
    }
}
