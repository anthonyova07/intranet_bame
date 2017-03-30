<?php

namespace Bame\Models\HumanResource\Vacant\Applicant;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrvacapp';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
