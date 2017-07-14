<?php

namespace Bame\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'ibs';

    protected $table = 'srlmenu';

    protected $primaryKey = 'men_codigo';

    public $incrementing = false;

    public $timestamps = false;

    public function setMenCodigoAttibute($value)
    {
        $this->attributes['men_codigo'] = (int) $value;
    }

    public function setMenDescriAttribute($value)
    {
        $this->attributes['men_descri'] = cap_str($value);
    }

    public function scopeOnlyWeb($query)
    {
        return $this->where('men_web', 'S')->orderBy('men_descri');
    }
}
