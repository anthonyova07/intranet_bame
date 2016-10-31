<?php

namespace Bame\Models\Security;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Security\Menu;
use Bame\Models\Security\SubMenu;

class Access extends Model
{
    protected $connection = 'ibs';

    protected $table = 'srlaccesos';

    // protected $primaryKey = 'men_codigo';

    public $incrementing = false;

    public $timestamps = false;

    public function setAccCodmenAttibute($value)
    {
        $this->attributes['acc_codmen'] = (int) $value;
    }

    public function setAccSubmenAttibute($value)
    {
        $this->attributes['acc_submen'] = (int) $value;
    }

    public function setAccEstadoAttibute($value)
    {
        $this->attributes['acc_estado'] = (int) $value;
    }

    public static function getUserAccess($user)
    {
        $access = self::where('acc_user', $user)->where('acc_estado', 'A')->get();

        $menus = Menu::where('men_estatu', 'A')
                ->where('men_web', 'S')
                ->whereIn('men_codigo', $access->pluck('acc_codmen')->toArray())
                ->orderBy('men_descri')
                ->get();

        $menus->each(function ($menu, $index) use ($access) {
            $menu->submenus = SubMenu::where('sub_codmen', $menu->men_codigo)
                ->where('sub_estatu', 'A')
                ->where('sub_web', 'S')
                ->whereIn('sub_codigo', $access->where('acc_codmen', $menu->men_codigo)->pluck('acc_submen')->toArray())
                ->orderBy('sub_descri')
                ->get();
        });

       return $menus;
    }
}
