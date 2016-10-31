<?php

namespace Bame\Models\HumanResource\Vacant\Applicant;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_vacancies_applicants';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
