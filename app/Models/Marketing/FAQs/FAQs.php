<?php

namespace Bame\Models\Marketing\FAQs;

use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrafaqs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
