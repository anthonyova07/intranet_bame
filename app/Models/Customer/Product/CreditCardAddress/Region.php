<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastreg00';

    protected $primaryKey = 'regio_treg';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->regio_treg;
    }

    public function getDesc()
    {
        // return cap_str($this->desrg_treg);
        return $this->desrg_treg;
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desrg_treg', '<>', '')->orderBy('desrg_treg', 'asc');
    }
}
