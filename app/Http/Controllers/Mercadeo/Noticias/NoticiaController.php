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

        if ($request->fecha_desde) {
            Noticia::addCreatedAtFromFilter($request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            Noticia::addCreatedAtToFilter($request->fecha_hasta);
        }

        if ($request->termino) {
            Noticia::addFilter($request->termino);
        }

        Noticia::orderByCreatedAtDesc();

        $noticias = Noticia::all($request->session()->get('usuario'));

        if (!$noticias) {
            $noticias = collect();
        }

        return view('mercadeo.noticias.lista', ['noticias' => $noticias]);
    }

    public function getNueva() {
        return view('mercadeo.noticias.nueva');
    }

    public function postNueva(NoticiaRequest $request) {
        $id = uniqid(true);

        $file_name_destination = $id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

        if ($request->hasFile('image')) {
            $request->file('image')->move(public_path() . '\\mercadeo\\images\\', $file_name_destination);
        }

        Noticia::create($id, clear_tag($request->title), clear_tag($request->detail), $file_name_destination, $request->type);

        do_log('Creó la Noticia ( titulo:' . strip_tags($request->title) . ' )');

        return redirect()->route('mercadeo::noticias::lista')->with('success', 'La noticia ha sido guardada correctamente.');
    }

    public function getEditar(Request $request, $id) {
        $noticia = Noticia::getById($id);

        if (!$noticia) {
            return back()->with('warning', 'El id: ' . $id . ' de noticia no existe.');
        }

        return view('mercadeo.noticias.editar', ['noticia' => $noticia]);
    }

    public function postEditar(NoticiaRequest $request, $id) {
        $noticia = Noticia::getById($id);

        if (!$noticia) {
            return back()->with('warning', 'El id: ' . $id . ' de noticia no existe.');
        }

        $file_name_destination = null;

        if ($request->hasFile('image')) {
            $file_name = public_path() . str_replace('/', '\\', $noticia->IMAGE);

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            $file_name_destination = $id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());
            $request->file('image')->move(public_path() . '\\mercadeo\\images\\', $file_name_destination);
        }

        Noticia::update($id, clear_tag($request->title), clear_tag($request->detail), $request->type, $file_name_destination, $request->repost);

        do_log('Editó la Noticia ( titulo:' . strip_tags($request->title) . ' )');

        return redirect()->route('mercadeo::noticias::lista')->with('success', 'La noticia ha sido modificada correctamente.');
    }

    public function getEliminar(Request $request, $id) {
        Noticia::delete($request->session()->get('usuario'), $id);

        return back()->with('success', 'La noticia ha sido eliminada correctamente.');
    }
}
