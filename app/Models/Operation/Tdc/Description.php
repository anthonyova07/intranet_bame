<?php

namespace Bame\Models\Operation\Tdc;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $connection = 'itc';

    protected $table = 'satdesc00';

    // protected $primaryKey = 'numtc_atrn';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->codig_desc;
    }

    public function getDescription()
    {
        return cap_str($this->nombr_desc);
    }

    public function getProcessDate()
    {
        return cap_str($this->fecpr_atrn);
    }

    public function scopeWherePrefix($query, $prefix)
    {
        return $query->where('prefi_desc', $prefix);
    }

    public function scopeOrderByDescription($query)
    {
        return $query->orderBy('nombr_desc', 'asc');
    }
}
