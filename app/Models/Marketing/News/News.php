<?php

namespace Bame\Models\Marketing\News;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranews';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function hasDetail()
    {
        return trim($this->detail) != '';
    }
}
