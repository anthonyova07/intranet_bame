<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrraprh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(ProductDetailHistory::class, 'pro_id', 'id')->orderBy('sequence', 'ASC');
    }

    public function ranges()
    {
        $ranges = explode(',', $this->ranges);

        foreach ($ranges as $index => $range) {
            $ranges[$index] = trim($range);
        }

        return $ranges;
    }

    public function scopeActiveRates($query)
    {
        return $query->where('rate_type', 'A')->orderBy('name');
    }

    public function scopePassiveRates($query)
    {
        return $query->where('rate_type', 'P')->orderBy('name');
    }
}
