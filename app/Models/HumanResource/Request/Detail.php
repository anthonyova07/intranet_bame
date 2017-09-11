<?php

namespace Bame\Models\HumanResource\Request;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqrhde';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [
        'perdatfrom',
        'perdatto',
        'perdatfror',
        'perdattor',
        'vacdatfror',
        'vacdattor',
    ];

    public function scopeLastestFirst($query)
    {
        return $this->orderBy('created_at', 'desc');
    }
}
