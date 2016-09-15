<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;

use Bame\Models\Mercadeo\Noticias\Noticia;

class HomeController extends Controller {

    public function index(Request $request) {
        $noticia_columna = Noticia::getLastNewColumn();

        $noticias_banners = Noticia::getLastBanners(5);

        return view('home.index', ['noticia_columna' => $noticia_columna, 'noticias_banners' => $noticias_banners]);
    }

}
