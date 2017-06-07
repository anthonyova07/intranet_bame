<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrapro';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'pro_id', 'id');
    }
}
