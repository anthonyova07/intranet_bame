<?php

namespace Bame\Models\Mercadeo\Coco;

class Coco
{
    protected $coco;

    public function __construct()
    {
        $this->coco = get_coco_info();

        if ($this->coco) {
            $this->coco->descriptions = collect($this->coco->descriptions);
            $this->coco->awards = collect($this->coco->awards);
        } else {
            $this->create('', false, [], []);
        }
    }

    public function get()
    {
        return $this->coco;
    }

    public function create($title, $active, array $descriptions, array $awards)
    {
        $coco = new \stdClass;
        $coco->title = $title;
        $coco->active = (bool) $active;
        $coco->descriptions = $descriptions;
        $coco->awards = $awards;
        $this->coco = $coco;
    }

    public function save()
    {
        save_coco(json_encode($this->coco));
    }
}
