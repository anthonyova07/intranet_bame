<?php

namespace Bame\Models\Customer\Product\CreditCardAddress;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'itc';

    protected $table = 'sastpai00';

    protected $primaryKey = 'codpa_tpai';

    public $incrementing = false;

    public $timestamps = false;

    public function getCode()
    {
        return $this->codpa_tpai;
    }

    public function getDesc()
    {
        return cap_str($this->despa_tpai);
    }

    public function scopeOrderByDesc($query)
    {
        return $query->where('despa_tpai', '<>', '')->orderBy('despa_tpai', 'asc');
    }
}
