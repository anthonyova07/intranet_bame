<?php

namespace Bame\Http\Controllers\Marketing\GesticDoc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\GesticDoc\GesticDoc;

class GesticDocController extends Controller
{
    public function index()
    {
        $files = GesticDoc::getFiles('marketing');

        return view('marketing.gestic_doc.index')
            ->with('files', $files);
    }

    public function store(Request $request)
    {
        $ruta = 'marketing';

        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));
            $files->each(function ($file, $index) use ($ruta) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move(public_path('files\\gestic_doc\\' . $ruta), $file_name_destination);
            });
        }

        return back()->with('success', 'Los archivos han sido cargados correctamente.');
    }

    public function destroy($file)
    {
        GesticDoc::deleteFile('marketing', $file);

        return back()->with('success', 'El archivo ha sido eliminado correctamente.');
    }
}
