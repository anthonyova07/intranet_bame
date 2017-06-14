<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrrapde';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true)->orderBy('sequence');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'id');
    }

    public function old_values()
    {
        $old_values = explode('|', $this->old_value);

        foreach ($old_values as $index => $old_value) {
            $old_values[$index] = trim($old_value);
        }

        return $old_values;
    }
}
