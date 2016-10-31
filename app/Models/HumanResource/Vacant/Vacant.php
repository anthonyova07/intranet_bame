<?php

namespace Bame\Models\HumanResource\Vacant;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\HumanResource\Vacant\Applicant\Applicant;

class Vacant extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_vacancies';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function isSubscribe()
    {
        return (bool) $this->applicants
            ->where('username', session()->get('user'))
            ->count();
    }
}
