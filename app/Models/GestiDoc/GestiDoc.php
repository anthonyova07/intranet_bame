<?php

namespace Bame\Models\GestiDoc;

use Bame\Models\Department\Department;

class GestiDoc
{
    use Department;

    public static function getFiles($department, $folder = null, $is_maintenance = false)
    {
        $url_files = public_path('files\\gesti_doc\\' . $department . ($folder ? '\\' . $folder : ''));

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($files, $department, $url_files, $folder, $is_maintenance) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    $parts = explode('.', $item);

                    if (is_dir($url_files . '\\' . $item)) {
                        if ($is_maintenance) {
                            $file->url = route($department . '.gestidoc.index', ['folder' => ($folder ? $folder . '\\' . $item : $item)]);
                        } else {
                            $file->url = route('gestidoc.' . $department, ['folder' => ($folder ? $folder . '\\' . $item : $item)]);
                        }
                        $file->file = $item;
                        $file->name = $parts[0];
                        $file->type = 'directory';
                    }

                    if (is_file($url_files . '\\' . $item)) {
                        $file->url = route('home') . '/files/gesti_doc/' . $department . '/' . ($folder ? str_replace('\\', '/', $folder) : '') . '/' . $item;
                        $file->file = $item;
                        $file->name = $parts[0];
                        $file->type = array_pop($parts);
                    }

                    $files->push($file);
                }
            });
        }

        return $files;
    }

    public static function deleteFile($department, $file, $folder = null)
    {
        $file_name = public_path('files\\gesti_doc\\' . $department . '\\' . ($folder ? $folder . '\\' : '') . $file);

        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}
