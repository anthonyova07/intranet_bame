<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastdca00';

    protected $primaryKey = 'calle_tdca';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->calle_tdca;
    }

    public function getDesc()
    {
        return cap_str($this->desca_tdca);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desca_tdca', '<>', '')->orderBy('desca_tdca', 'asc');
    }
}
