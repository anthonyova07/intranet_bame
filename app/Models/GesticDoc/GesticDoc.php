<?php

namespace Bame\Models\GesticDoc;

use Bame\Models\Department\Department;

class GesticDoc
{
    use Department;

    public static function getFiles($department)
    {
        $url_files = public_path('files\\gestic_doc\\' . $department);

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($files, $department) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    $parts = explode('.', $item);

                    $file->url = route('home') . '/files/gestic_doc/' . $department . '/' . $item;

                    $file->file = $item;
                    $file->name = $parts[0];
                    $file->type = array_pop($parts);

                    $files->push($file);
                }
            });
        }

        return $files;
    }

    public static function deleteFile($department, $file)
    {
        $file_name = public_path('files\\gestic_doc\\' . $department . '\\' . $file);

        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}
