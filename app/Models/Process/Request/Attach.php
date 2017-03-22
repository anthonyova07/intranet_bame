<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class Attach extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqprat';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function delete_attach()
    {
        $path = storage_path('app\\process_request\\attaches\\' . $this->claim_id . '\\' . $this->file);

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
