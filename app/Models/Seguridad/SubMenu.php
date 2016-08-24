<?php

namespace Bame\Models\Seguridad;

class SubMenu
{
    public static function all($menu)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM SRLSUBMENU WHERE SUB_CODMEN = :menu ORDER BY DESCRIPCION');
        $stmt->execute([
            ':menu' => $menu,
        ]);
        return collect($stmt->fetchAll());
    }

    public static function get($menu, $codigo)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM SRLSUBMENU WHERE SUB_CODMEN = :menu AND SUB_CODIGO = :codigo');
        $stmt->execute([
            ':menu' => $menu,
            ':codigo' => $codigo,
        ]);
        return $stmt->fetch();
    }

    public static function getByMenuAccess($menu, $usuario) {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM SRLSUBMENU S, SRLACCESOS A WHERE S.SUB_CODMEN = :menu AND A.ACC_ESTADO = \'A\' AND S.SUB_ESTATU = \'A\' AND S.SUB_WEB = \'S\' AND S.SUB_CODMEN = A.ACC_CODMEN AND S.SUB_CODIGO = A.ACC_SUBMEN AND A.ACC_USER = :usuario');
        $stmt->execute([
            ':menu' => $menu,
            ':usuario' => $usuario,
        ]);
        return collect($stmt->fetchAll());
    }

    public static function create($menu, $descripcion, $caption, $estatus, $web, $link, $coduni)
    {
        $stmt = app('con_ibs')->prepare('INSERT INTO SRLSUBMENU (SUB_BANCO, SUB_CODMEN, SUB_CODIGO, SUB_DESCRI, SUB_CAPTION, SUB_ESTATU, SUB_WEB, SUB_LINK, SUB_CODUNI) VALUES(1, :menu, :codigo, :descripcion, :caption, :estatus, :web, :link, :coduni)');
        $stmt->execute([
            ':menu' => $menu,
            ':codigo' => self::getNewCode($menu),
            ':descripcion' => cap_str($descripcion),
            ':caption' => cap_str($caption),
            ':estatus' => get_status($estatus),
            ':web' => get_web($web),
            ':link' => clear_str($link),
            ':coduni' => clear_str($coduni),
        ]);
    }

    public static function update($menu_nuevo, $codigo_nuevo, $descripcion, $caption, $estatus, $web, $link, $coduni, $menu_viejo, $codigo_viejo) {
        $stmt = app('con_ibs')->prepare('UPDATE SRLSUBMENU SET SUB_CODMEN = :menu_nuevo, SUB_CODIGO = :codigo_nuevo, SUB_DESCRI = :descripcion, SUB_CAPTION = :caption, SUB_ESTATU = :estatus, SUB_WEB = :web, SUB_LINK = :link, SUB_CODUNI = :coduni WHERE SUB_CODMEN = :menu_viejo AND SUB_CODIGO = :codigo_viejo');
        $stmt->execute([
            ':menu_nuevo' => $menu_nuevo,
            ':codigo_nuevo' => $codigo_nuevo,
            ':descripcion' => cap_str($descripcion),
            ':caption' => cap_str($caption),
            ':estatus' => get_status($estatus),
            ':web' => get_web($web),
            ':link' => clear_str($link),
            ':coduni' => clear_str($coduni),
            ':menu_viejo' => $menu_viejo,
            ':codigo_viejo' => $codigo_viejo,
        ]);
    }

    public static function getNewCode($menu)
    {
        $stmt = app('con_ibs')->prepare('SELECT SUB_CODIGO CODIGO FROM SRLSUBMENU WHERE SUB_CODMEN = :menu ORDER BY SUB_CODIGO DESC FETCH FIRST 1 ROWS ONLY');
        $stmt->execute([
            ':menu' => $menu
        ]);
        $result = $stmt->fetch();
        return $result ? intval($result->CODIGO) + 1 : 1;
    }

    public static function exists_coduni($coduni, $codigo = 0)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . self::getFields()[7] . ' FROM SRLSUBMENU WHERE SUB_CODUNI = :coduni AND SUB_CODIGO <> :codigo');
        $stmt->execute([
            ':coduni' => clear_str($coduni),
            ':codigo' => $codigo,
        ]);
        return $stmt->fetch() ? true : false;
    }

    private static function getFields()
    {
        return [
            'SUB_CODMEN MENU',
            'SUB_CODIGO CODIGO',
            'SUB_DESCRI DESCRIPCION',
            'SUB_CAPTION CAPTION',
            'SUB_ESTATU ESTATU',
            'SUB_WEB WEB',
            'SUB_LINK LINK',
            'SUB_CODUNI CODUNI',
        ];
    }
}
