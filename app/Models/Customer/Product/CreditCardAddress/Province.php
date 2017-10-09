<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastprv00';

    protected $primaryKey = 'provi_tprv';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->provi_tprv;
    }

    public function getDesc()
    {
        return cap_str($this->despv_tprv);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('despv_tprv', '<>', '')->orderBy('despv_tprv', 'asc');
    }
}
