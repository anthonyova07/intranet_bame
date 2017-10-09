<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastdba00';

    protected $primaryKey = 'barri_tdba';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->barri_tdba;
    }

    public function getDesc()
    {
        return cap_str($this->desba_tdba);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desba_tdba', '<>', '')->orderBy('desba_tdba', 'asc');
    }
}
