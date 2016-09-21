<?php

namespace Bame\Http\Controllers\Mercadeo\Coco;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Mercadeo\Coco\Coco;
use Bame\Http\Requests\Mercadeo\Coco\MantenimientoRequest;

class CocoController extends Controller
{
    public function getMantenimiento(Request $request)
    {
        $coco = new Coco;
        return view('mercadeo.coco.mantenimiento', ['coco' => $coco]);
        // $coco = new Coco;
        // dd($coco->get());

        // $coco = new Coco;
        // $coco->create('Este es el titulo del coco', true, [[
        //     'order' => 1,
        //     'description' => 'primera description',
        // ],[
        //     'order' => 2,
        //     'description' => 'segunda description',
        // ]], [[
        //     'order' => 1,
        //     'award' => 'primera award',
        // ],[
        //     'order' => 2,
        //     'award' => 'segunda award',
        // ]]);
        // $coco->save();
    }

    public function postMantenimiento(MantenimientoRequest $request)
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

            $coco->create($request->title, $request->active ? true:false, $descriptions, $awards);
            $coco->save();

        } catch (\ErrorException $e) {
            return back()->withInput()->with('error', 'El formato de las descripciones o premios es incorrecta.');
        }

        return back()->with('success', 'La información introducida fue guardada correctamente.');
    }
}
