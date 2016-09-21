<?php

namespace Bame\Http\Controllers\Mercadeo;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Mercadeo\Noticias\Noticia;
use Bame\Models\Mercadeo\Coco\Coco;

class MercadeoController extends Controller
{
    public function noticia(Request $request, $id)
    {
        $noticia = Noticia::getById($id);

        if (!$noticia) {
            return back()->with('warning', 'Esta noticia no existe.');
        }

        return view('home.mercadeo.noticia', ['noticia' => $noticia]);
    }

    public function banner(Request $request, $id)
    {
        $banner = Noticia::getById($id);

        if (!$banner) {
            return back()->with('warning', 'Esta noticia no existe.');
        }

        return view('home.mercadeo.banner', ['banner' => $banner]);
    }

    public function coco(Request $request)
    {
        $coco = new Coco;

        return view('home.mercadeo.coco', ['coco' => $coco]);
    }
}
