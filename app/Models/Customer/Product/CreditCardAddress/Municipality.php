<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastmun00';

    protected $primaryKey = 'munic_tmun';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->munic_tmun;
    }

    public function getDesc()
    {
        return cap_str($this->desmc_tmun);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desmc_tmun', '<>', '')->orderBy('desmc_tmun', 'asc');
    }
}
