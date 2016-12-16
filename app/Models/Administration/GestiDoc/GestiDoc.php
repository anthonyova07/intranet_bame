<?php

namespace Bame\Models\Administration\GestiDoc;

use Illuminate\Database\Eloquent\Model;

class GestiDoc extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intpgesdoc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function getFiles()
    {
        $url_files = storage_path('app\\gesti_doc\\' . $this->id);

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($files, $url_files) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    $parts = explode('.', $item);

                    $file->url = route('administration.gestidoc.download', ['folder' => $this->id, 'file' => $item]);
                    $file->file = $item;
                    $file->name = $parts[0];
                    $file->type = array_pop($parts);

                    $files->push($file);
                }
            });
        }

        return $files;
    }
}
