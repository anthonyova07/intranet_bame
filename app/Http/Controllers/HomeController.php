<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;

use Bame\Models\Mercadeo\Noticias\Noticia;

class HomeController extends Controller {

    public function index(Request $request) {
        $noticia_columna = Noticia::getLastNewColumn();

        $noticias_banners = Noticia::getLastBanners(5);

        $noticias = Noticia::getLastNews(5);

        return view('home.index', ['noticia_columna' => $noticia_columna, 'noticias_banners' => $noticias_banners, 'noticias' => $noticias]);
    }

    public function noticia(Request $request, $id) {
        $noticia = Noticia::getById($id);

        if (!$noticia) {
            return back()->with('warning', 'Esta noticia no existe.');
        }

        return view('home.noticia', ['noticia' => $noticia]);
    }

    public function banners(Request $request) {
        $noticias_banners = Noticia::getLastBanners(10);

        return view('home.banners', ['noticias_banners' => $noticias_banners]);
    }

}
