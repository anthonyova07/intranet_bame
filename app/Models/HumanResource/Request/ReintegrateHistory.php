<?php

namespace Bame\Models\HumanResource\Request;

use Illuminate\Database\Eloquent\Model;

class ReintegrateHistory extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqrhrh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'perdatfror',
        'perdattor',
        'vacdatfror',
        'vacdattor',
        'pertimtor',
        'pertimfror',
        'observar',
        'created_by',
        'id',
    ];

    protected $dates = [
        'perdatfror',
        'perdattor',
        'vacdatfror',
        'vacdattor',
    ];

    public function scopeLastest($query)
    {
        return $this->orderBy('created_at', 'desc');
    }
}
