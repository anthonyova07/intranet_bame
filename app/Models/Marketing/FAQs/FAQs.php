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

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }
}
