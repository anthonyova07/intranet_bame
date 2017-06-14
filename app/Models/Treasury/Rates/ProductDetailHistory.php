<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductDetailHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrapdh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    public function ranges()
    {
        return $this->hasMany(ProductDetailRangeHistory::class, 'detail_id', 'id');
    }
}
