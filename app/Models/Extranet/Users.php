<?php

namespace Bame\Models\Extranet;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intextuser';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function business()
    {
        return $this->belongsTo(Business::class, 'busi_id', 'id');
    }
}
