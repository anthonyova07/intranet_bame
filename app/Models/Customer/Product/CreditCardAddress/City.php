<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastciu00';

    protected $primaryKey = 'ciuda_tciu';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->ciuda_tciu;
    }

    public function getDesc()
    {
        return cap_str($this->desci_tciu);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('desci_tciu', '<>', '')->orderBy('desci_tciu', 'asc');
    }
}
