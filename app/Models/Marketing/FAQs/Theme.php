<?php

namespace Bame\Models\Marketing\FAQs;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrafaqth';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function questions()
    {
        return $this->hasMany(FAQs::class, 'theme_id', 'id')->where('is_active', '1')->orderBy('question');
    }
}
