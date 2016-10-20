<?php

namespace Bame\Http\Controllers\Marketing\Coco;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Http\Requests\Marketing\Coco\CocoRequest;

class CocoController extends Controller
{
    public function index(Request $request)
    {
        $coco = new Coco;
        return view('marketing.coco.index', ['coco' => $coco]);
    }

    public function store(CocoRequest $request)
    {
        try {

            $coco = new Coco;

            $lineas_descriptions = explode('<br />', remove_n_r($request->descriptions));

            $descriptions = array();

            foreach ($lineas_descriptions as $value) {
                if (trim($value) != '') {
                    $description = explode('-', $value);
                    $descriptions[] = [
                        'order' => $description[0],
                        'description' => $description[1],
                    ];
                }
            }

            $lineas_awards = explode('<br />', remove_n_r($request->awards));

            $awards = array();

            foreach ($lineas_awards as $value) {
                if (trim($value) != '') {
                    $award = explode('-', $value);
                    $awards[] = [
                        'order' => $award[0],
                        'award' => $award[1],
                    ];
                }
            }

            $coco->create($request->title, $request->active ? true : false, $descriptions, $awards);
            $coco->save();

            if ($request->active) {
                $noti = new Notification('global');
                $noti->create('Concurso Rompete el COCO', $request->title, route('coco'));
                $noti->save();
            }

        } catch (\ErrorException $e) {
            return back()->withInput()->with('error', 'El formato de las descripciones o premios es incorrecta.');
        }

        return back()->with('success', 'La información introducida fue guardada correctamente.');
    }
}
