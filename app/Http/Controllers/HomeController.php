<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;

use Bame\Models\Mercadeo\Noticias\Noticia;
use Bame\Models\Mercadeo\Coco\Coco;

class HomeController extends Controller {

    public function index(Request $request) {
        $noticia_columna = Noticia::getLastNewColumn();

        $noticias_banners = Noticia::getLastBanners(env('BANNERS_QUANTITY'));

        $noticias = Noticia::getLastNews(env('NEWS_QUANTITY'));

        $coco = new Coco();

        return view('home.index', [
            'noticia_columna' => $noticia_columna,
            'noticias_banners' => $noticias_banners,
            'noticias' => $noticias,
            'coco' => $coco
        ]);
    }

}
