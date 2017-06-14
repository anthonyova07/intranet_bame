<?php

namespace Bame\Models\Treasury\Rates;

use Illuminate\Database\Eloquent\Model;

class DateHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'inttrradah';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['effec_date'];

    public function products()
    {
        return $this->hasMany(ProductHistory::class, 'date_id', 'id');
    }

    public function scopeLast($query)
    {
        return $query->orderBy('created_at', 'desc')->take(1);
    }
}
