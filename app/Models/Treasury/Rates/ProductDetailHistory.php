<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductDetailHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrapdh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(ProductHistory::class, 'pro_id', 'id');
    }
}
