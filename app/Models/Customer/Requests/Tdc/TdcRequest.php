<?php

namespace Bame\Models\Customer\Requests\Tdc;

use Illuminate\Database\Eloquent\Model;
use Bame\Models\HumanResource\Employee\Employee;

class TdcRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcuretdc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByNumber($query, $reqnumber)
    {
        return $query->where('reqnumber', $reqnumber);
    }

    public function isDeleted()
    {
        return $this->deleted_at != null;
    }

    public function isNotDeleted()
    {
        return !$this->isDeleted();
    }

    public static function searchFromDBFile($identification)
    {
        $channel = strtolower(Employee::getChannel());

        if ($channel == 'cce') {
            $path = config('bame.requests.db.url') . 'solicitudes_tdc_db_' . strtolower(Employee::getChannel()) . '_' . auth()->user()->busi_id . '.csv';
        } else {
            $path = config('bame.requests.db.url') . 'solicitudes_tdc_db_'.strtolower(Employee::getChannel()).'.csv';
        }

        if (!file_exists($path)) {
            return null;
        }

        $lines = file($path);

        foreach ($lines as $index => $line) {
            if ($index == 0) {
                continue;
            }

            $parts = explode(',', $line);

            if ($identification == $parts[0]) {
                $object = new \stdClass;

                $object->identification = $parts[0];
                $object->names = $parts[1];
                $object->nationality = $parts[2];

                if (strlen(trim($parts[3])) == 7) {
                    $day = substr($parts[3], 0, 1);
                    $month = substr($parts[3], 1, 2);
                    $year = substr($parts[3], 3, 4);
                } else {
                    $day = substr($parts[3], 0, 2);
                    $month = substr($parts[3], 2, 2);
                    $year = substr($parts[3], 4, 4);
                }

                $object->birthdate = "$year-$month-" . str_pad($day, 2, 0, STR_PAD_LEFT);
                $object->gender = strtolower($parts[4]);
                $object->product = $parts[5];
                $object->limit_rd = $parts[6];
                $object->limit_us = $parts[7];
                $object->phones_cel = [$parts[8], $parts[9], $parts[10]];
                $object->phones_house = [$parts[11], $parts[12], $parts[13]];
                $object->phones_work = [$parts[14], $parts[15], $parts[16]];
                $object->phones_other = [$parts[17], $parts[18], $parts[19]];
                $object->campaign = trim($parts[20]);
                $object->committee = $parts[21];

                if (strlen(trim($parts[22])) == 7) {
                    $day = substr($parts[22], 0, 1);
                    $month = substr($parts[22], 1, 2);
                    $year = substr($parts[22], 3, 4);
                } else {
                    $day = substr($parts[22], 0, 2);
                    $month = substr($parts[22], 2, 2);
                    $year = substr($parts[22], 4, 4);
                }

                $object->committee_date = "$year-$month-" . str_pad($day, 2, 0, STR_PAD_LEFT);

                return $object;
            }
        }
    }

    public function scopeRequestsCreated($query, $identification)
    {
        return $query->where('identifica', $identification)->where('deleted_at', null);
    }
}
