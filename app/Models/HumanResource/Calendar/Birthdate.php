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

        self::saveFile($birthdates);
    }

    public static function storeImages($files)
    {
        $employees = self::getFile();
        $files = collect($files);

        $files->each(function ($file, $index) use ($employees) {
            $file_name = explode('.', $file->getClientOriginalName());
            $name = self::getName($file_name[0]);

            if ($employees->contains('code', trim($name))) {
                $path = public_path() . '\\files\\employee_images\\';
                $file_path = $path . $name;

                if (file_exists($file_path . '.jpg')) {
                    unlink($file_path . '.jpg');
                }

                if (file_exists($file_path . '.png')) {
                    unlink($file_path . '.png');
                }

                $file->move($path, $name . '.' . $file_name[1]);
            }
        });
    }

    public static function saveFile($birthdates)
    {
        $path = storage_path('app\\calendar\\birthdates.json');

        if (!file_exists(storage_path('app\\calendar'))) {
            mkdir(storage_path('app\\calendar'));
        }

        file_put_contents($path, json_encode($birthdates->values()));
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

    public static function addModifyDeleteOne($data)
    {
        $message = 'El empleado ha sido eliminado correctamente.';

        $birthdates = self::getFile();

        if ($birthdates->contains('code', $data->code)) {
            $birthdates = $birthdates->filter(function ($birthdate, $index) use ($data) {
                return $data->code != $birthdate->code;
            });
        }

        if (trim($data->full_name) != '') {
            $birthdate_parts = explode('-', $data->birthdate);
            $service_parts = explode('-', $data->initial_date);

            $birthdate = new \stdClass;

            $birthdate->code = $data->code;
            $birthdate->full_name = $data->full_name;
            $birthdate->gender = $data->gender;
            $birthdate->month_day = $birthdate_parts[1] .'-'. $birthdate_parts[2];

            $birthdate->services_date = $service_parts[2] . '/' . $service_parts[1] . '/' . $service_parts[0];
            $birthdate->services_month_day = $service_parts[1] .'-'. $service_parts[2];

            $birthdates->push($birthdate);

            $message = 'El empleado ha sido agregado/modificado correctamente.';
        }

        self::saveFile($birthdates);

        return $message;
    }

    //optener el numero de empleado del formato "Nombre Empleado (###).jpg"
    public static function getName($str)
    {
        return str_ireplace(')', '', explode('(', $str)[1]);
    }
}
