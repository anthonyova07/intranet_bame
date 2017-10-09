<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastdse00';

    protected $primaryKey = 'secto_tdse';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->secto_tdse;
    }

    public function getDesc()
    {
        return cap_str($this->desse_tdse);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desse_tdse', '<>', '')->orderBy('desse_tdse', 'asc');
    }
}
