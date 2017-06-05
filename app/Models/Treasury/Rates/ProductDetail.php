<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrapde';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }
}
