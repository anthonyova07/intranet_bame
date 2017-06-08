<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrraprh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function details()
    {
        return $this->hasMany(ProductDetailHistory::class, 'pro_id', 'id');
    }
}
