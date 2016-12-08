<?php

namespace Bame\Models\Marketing\Gallery;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intgalalb';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public static function getFiles($id)
    {
        $url_files = public_path('files\\gallery\\'. $id);

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($id, $files, $url_files) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    if (is_file($url_files . '\\' . $item)) {
                        $file->url = route('home') . '/files/gallery/' . $id . '/' . $item;
                        $file->file = $item;
                    }

                    $files->push($file);
                }
            });
        }

        return $files;
    }

    public function scopeOnlyActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function deleteImage($gallery, $image)
    {
        $file_name = public_path('files\\gallery\\' . $gallery . '\\' . $image);

        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}
