<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductDetailRangeHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrpdrh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;    
}
