<?php

namespace Bame\Models\HumanResource\Employee;

use Bame\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhemplo';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [];

    public function getFullNameAttribute($value)
    {
        return $this->name . ' ' .$this->name_2 . ' ' . $this->lastname . ' ' . $this->lastname_2;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function small_name()
    {
        return $this->name . ' ' . $this->lastname;
    }

    public function full_name()
    {
        return $this->name . ' ' . $this->name_2 . ' ' . $this->lastname . ' ' . $this->lastname_2;
    }

    public function department()
    {
        return $this->hasOne(Param::class, 'id', 'id_dep');
    }

    public function position()
    {
        return $this->hasOne(Param::class, 'id', 'id_pos');
    }

    public function supervisor()
    {
        return $this->hasOne(Param::class, 'id', 'id_sup');
    }

    public function supervisor_emp()
    {
        return $this->hasOne(Employee::class, 'id_pos', 'id_sup');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'id_sup', 'id_pos');
    }

    public function scopeByUser($query, $user = null)
    {
        if ($user) {
            return $query->where('useremp', $user);
        }

        return $query->where('useremp', session('user'));
    }

    public function getOffice()
    {
        return session('user_info')->physicaldeliveryofficename[0];
    }

    public function getTitle($clean = true)
    {
        return $clean ? strtolower(trim(session('user_info')->getTitle())) : session('user_info')->getTitle();
    }

    public function isCallCenter()
    {
        return str_contains($this->getTitle(), 'call center');
    }

    public function isBusinessOfficer()
    {
        return str_contains($this->getTitle(), 'oficial') ||
            str_contains($this->getTitle(), 'ejecutivo') ||
            str_contains($this->getTitle(), 'supervisor') ||
            str_contains($this->getTitle(), 'gerente') ||
            str_contains($this->getTitle(), 'cajero') ||
            str_contains($this->getTitle(), 'negocio');
    }

    public static function getChannel($description = false)
    {
        if (session()->has('employee')) {
            $employee = session('employee');

            $office = $employee->getOffice();

            if ($employee->isBusinessOfficer()) {
                if ($description) {
                    return get_office_code($office, $description);
                }

                return get_channel_officer(get_office_code($office));
            }

            if ($employee->isCallCenter()) {
                return $description ? 'Call Center Interno':'CCI';
            }

            return $description ? 'Empleado':'EMP';
        }

        return $description ? 'Call Center Externo':'CCE';
    }

    public function isSupervisor()
    {
        return (bool) $this->subordinates->count();
    }

    public function getSubordinatesUsers()
    {
        return $this->subordinates->pluck('useremp')->toArray();
    }

    public function getMaxDayTakeVac($min = 1)
    {
        $years = get_year_of_service($this->servicedat);

        if ($years >= $min && $years < 5) {
            return 14;
        }

        if ($years >= 5) {
            return 18;
        }

        return 0;
    }

    public function applyBonus($days)
    {
        $years = get_year_of_service($this->servicedat);

        if ($years >= 1 && $years <= 5) {
            return $days >= 8;
        }

        if ($years > 5) {
            return $days >= 10;
        }

        return false;
    }

    public function hasMonth($month)
    {
        $months = get_month_of_service($this->servicedat);

        return $months > $month;
    }

    public function noHasMonth($month)
    {
        return !$this->hasMonth($month);
    }

    public function accounts_sav()
    {
        $customer = Customer::byIdn(remove_dashes($this->identifica))->first();

        if ($customer) {
            return $customer->accounts_sav;
        }

        return collect();
    }

    public function payroll_account()
    {
        $customer = Customer::byIdn(remove_dashes($this->identifica))->first();

        if ($customer) {
            return $customer->payroll_account;
        }

        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
