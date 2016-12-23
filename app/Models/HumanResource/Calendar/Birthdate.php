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
            $birthdate->first_name = utf8_encode($parts[3]);
            $birthdate->last_name = utf8_encode($parts[2]);
            $birthdate->gender = $parts[4];
            $birthdate->day = $parts['5'];
            $birthdate->month = $parts['6'];

            $birthdates->push($birthdate);
        }

        $path = storage_path('app\\birthdates.json');
        file_put_contents($path, $birthdates->toJson());
    }

    public static function getFile()
    {
        if (file_exists(storage_path('app\\birthdates.json'))) {
            $birthdates = collect(json_decode(file_get_contents(storage_path('app\\birthdates.json'))));
        } else {
            $birthdates = collect();
        }

        return $birthdates;
    }
}
