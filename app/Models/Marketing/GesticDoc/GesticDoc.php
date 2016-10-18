<?php

namespace Bame\Models\Marketing\GesticDoc;

class GesticDoc
{
    public static function getFiles($ruta)
    {
        $url_files = public_path('files\\gestic_doc\\' . $ruta);

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($files, $ruta) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    $parts = explode('.', $item);

                    $file->url = route('home') . '/files/gestic_doc/' . $ruta . '/' . $item;

                    $file->file = $item;
                    $file->name = $parts[0];
                    $file->type = array_pop($parts);

                    $files->push($file);
                }
            });
        }

        return $files;
    }

    public static function deleteFile($ruta, $file)
    {
        $file_name = public_path('files\\gestic_doc\\' . $ruta . '\\' . $file);

        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}
