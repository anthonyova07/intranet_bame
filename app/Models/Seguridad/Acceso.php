<?php

namespace Bame\Models\Seguridad;

use \Bame\Models\Seguridad\Menu;

class Acceso
{
    public static function allByUser($usuario)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM BADCYFILES.SRLACCESOS WHERE ACC_USER = :usuario AND ACC_ESTADO = \'A\'');
        $stmt->execute([
            'usuario' => $usuario,
        ]);

        return collect($stmt->fetchAll());
    }

    public static function getAccessMenus($usuario) {
        $accesos = self::allByUser($usuario);

        if ($accesos->count()) {
            $menus_id = $accesos->pluck('MENU')->toArray();

            $menus = Menu::getByIds($menus_id);

            $menus->each(function ($menu, $index) use ($usuario) {
                $menu->submenus = SubMenu::getByMenuAccess($menu->CODIGO, $usuario);
            });

            return $menus;
        }

        return false;
    }

    public static function create($usuario, $menu, $submenu, $estado)
    {
        if (self::exists($usuario, $menu, $submenu)) {
            self::enabled($usuario, $menu, $submenu);
        } else {
            $stmt = app('con_ibs')->prepare('INSERT INTO BADCYFILES.SRLACCESOS (ACC_USER, ACC_CODMEN, ACC_SUBMEN, ACC_ESTADO) VALUES(:usuario, :menu, :submenu, :estado)');
            $stmt->execute([
                ':usuario' => clear_str($usuario),
                ':menu' => $menu,
                ':submenu' => $submenu,
                ':estado' => get_status($estado),
            ]);
        }
    }

    public static function delete($usuario, $menu, $submenu)
    {
        $stmt = app('con_ibs')->prepare('DELETE FROM BADCYFILES.SRLACCESOS WHERE ACC_USER = :usuario AND ACC_CODMEN = :menu AND ACC_SUBMEN = :submenu');
        $stmt->execute([
            ':usuario' => clear_str($usuario),
            ':menu' => $menu,
            ':submenu' => $submenu,
        ]);
    }

    public static function disabled($usuario, $menu, $submenu)
    {
        $stmt = app('con_ibs')->prepare('UPDATE BADCYFILES.SRLACCESOS SET ACC_ESTADO = \'I\' WHERE ACC_USER = :usuario AND ACC_CODMEN = :menu AND ACC_SUBMEN = :submenu');
        $stmt->execute([
            ':usuario' => clear_str($usuario),
            ':menu' => $menu,
            ':submenu' => $submenu,
        ]);
    }

    public static function enabled($usuario, $menu, $submenu)
    {
        $stmt = app('con_ibs')->prepare('UPDATE BADCYFILES.SRLACCESOS SET ACC_ESTADO = \'A\' WHERE ACC_USER = :usuario AND ACC_CODMEN = :menu AND ACC_SUBMEN = :submenu');
        $stmt->execute([
            ':usuario' => clear_str($usuario),
            ':menu' => $menu,
            ':submenu' => $submenu,
        ]);
    }

    public static function exists($usuario, $menu, $submenu)
    {
        $stmt = app('con_ibs')->prepare('SELECT ' . implode(', ', self::getFields()) . ' FROM BADCYFILES.SRLACCESOS WHERE ACC_USER = :usuario AND ACC_CODMEN = :menu AND ACC_SUBMEN = :submenu');
        $stmt->execute([
            ':usuario' => clear_str($usuario),
            ':menu' => $menu,
            ':submenu' => $submenu,
        ]);
        return $stmt->fetch() ? true : false;
    }

    private static function getFields()
    {
        return [
            'ACC_USER USUARIO',
            'ACC_CODMEN MENU',
            'ACC_SUBMEN SUBMENU',
            'ACC_ESTADO ESTADO'
        ];
    }
}
