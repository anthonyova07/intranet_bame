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

    public function products()
    {
        return $this->hasMany(ProductHistory::class, 'date_id', 'id');
    }
}
