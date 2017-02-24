<?php

namespace Bame\Models\HumanResource\Calendar;

use Illuminate\Database\Eloquent\Model;

use File;
use DateTime;

class Birthdate extends Model
{
    // protected $connection = 'ibs';

    // protected $table = 'ninguna';

    // protected $primaryKey = 'id';

    // public $incrementing = false;

    // public $timestamps = true;

    // protected $dates = ['startdate', 'enddate'];

    public static function storeFile($file)
    {
        $content = file($file->path());

        $birthdates = collect();

        foreach ($content as $index => $line) {
            if ($index < 2) {
                continue;
            }

            $parts = explode(',', $line);

            $birthdate = new \stdClass;

            $birthdate->code = $parts[1];
            $birthdate->full_name = utf8_encode($parts[3]) . ' ' . utf8_encode($parts[2]);
            $birthdate->gender = $parts[4];
            $birthdate->month_day = str_pad($parts['6'], 2, '0', STR_PAD_LEFT) .'-'. str_pad($parts['5'], 2, '0', STR_PAD_LEFT);

            $service_parts = explode('/', $parts['14']);
            $birthdate->services_date = trim($parts['14']);
            $birthdate->services_month_day = str_pad($service_parts[1], 2, '0', STR_PAD_LEFT) .'-'. str_pad($service_parts[0], 2, '0', STR_PAD_LEFT);

            $birthdates->push($birthdate);
        }

        $path = storage_path('app\\calendar\\birthdates.json');

        if (!file_exists(storage_path('app\\calendar'))) {
            mkdir(storage_path('app\\calendar'));
        }

        file_put_contents($path, $birthdates->toJson());
    }

    public static function getFile()
    {
        if (file_exists(storage_path('app\\calendar\\birthdates.json'))) {
            $birthdates = collect(json_decode(file_get_contents(storage_path('app\\calendar\\birthdates.json'))));
        } else {
            $birthdates = collect();
        }

        return $birthdates;
    }
}
