<?php

namespace Bame\Http\Controllers\Mercadeo\Noticias;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Mercadeo\Noticias\Noticia;
use Bame\Http\Requests\Mercadeo\Noticias\NoticiaRequest;

class NoticiaController extends Controller
{
    public function getLista(Request $request) {
        Noticia::orderByCreatedAtDesc();
        $noticias = Noticia::all($request->session()->get('usuario'));

        if (!$noticias) {
            $noticias = collect();
        }

        return view('mercadeo.noticias.lista', ['noticias' => $noticias]);
    }

    public function postLista(Request $request) {
        //
    }

    public function getNueva() {
        return view('mercadeo.noticias.nueva');
    }

    public function postNueva(NoticiaRequest $request) {
        $fileName = $request->file('image')->getClientOriginalName();
        $nameParts = explode('.', $fileName);
        $ext = array_pop($nameParts);

        $destinationFileName = uniqid(true) . '.' . $ext;

        if ($request->hasFile('image')) {
            $request->file('image')->move(public_path() . '\\mercadeo\\images\\', $destinationFileName);
        }

        Noticia::create($request->title, $request->detail, '/mercadeo/images/' . $destinationFileName, $request->type);

        return redirect()->route('mercadeo::noticias::lista')->with('success', 'La noticia ha sido guardada correctamente.');
    }
}
