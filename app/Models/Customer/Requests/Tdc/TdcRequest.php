<?php

namespace Bame\Models\Customer\Requests\Tdc;

use Illuminate\Database\Eloquent\Model;

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

    public static function searchFromDBFile($identification)
    {
        $path = storage_path('app\\solicitudes_tdc_db.csv');

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

                $day = substr($parts[3], 0, 2);
                $month = substr($parts[3], 2, 2);
                $year = substr($parts[3], 4, 4);

                $object->birthdate = "$year-$month-$day";
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

                $day = substr($parts[22], 0, 2);
                $month = substr($parts[22], 2, 2);
                $year = substr($parts[22], 4, 4);

                $object->committee_date = "$year-$month-$day";

                return $object;
            }
        }
    }
}
