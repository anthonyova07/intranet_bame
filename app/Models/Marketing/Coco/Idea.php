<?php

namespace Bame\Models\Marketing\Coco;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrcocoid';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
