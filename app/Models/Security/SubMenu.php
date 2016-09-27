<?php

namespace Bame\Models\Security;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $connection = 'ibs';

    protected $table = 'srlsubmenu';

    protected $primaryKey = 'sub_codigo';

    public $incrementing = false;

    public $timestamps = false;

    public function setSubCodmenAttibute($value)
    {
        $this->attributes['sub_codmen'] = (int) $value;
    }

    public function setSubCodigoAttibute($value)
    {
        $this->attributes['sub_codigo'] = (int) $value;
    }

    public function setSubDescriAttribute($value)
    {
        $this->attributes['sub_descri'] = cap_str($value);
    }

    public function setSubCaptionAttribute($value)
    {
        $this->attributes['sub_caption'] = cap_str($value);
    }
}
