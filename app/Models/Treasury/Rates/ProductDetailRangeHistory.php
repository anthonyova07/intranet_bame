<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrpdrh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function ranges()
    {
        return $this->hasMany(ProductRangeHistoryDetail::class, 'detail_id', 'id');
    }
}
