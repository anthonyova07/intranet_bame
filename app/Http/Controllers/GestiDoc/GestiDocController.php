<?php

namespace Bame\Http\Controllers\GestiDoc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\GestiDoc\GestiDoc;

class GestiDocController extends Controller
{
    public function gestidoc(Request $request)
    {
        $department = GestiDoc::getDepartment($request->url(), true);

        $files = GestiDoc::getFiles($department, $request->folder);

        return view('home.gesti_doc')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function index(Request $request)
    {
        $department = GestiDoc::getDepartment($request->path());

        $files = GestiDoc::getFiles($department, $request->folder, true);

        return view($department . '.gesti_doc.index')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function store(Request $request)
    {
        $department = GestiDoc::getDepartment($request->path());

        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));
            $files->each(function ($file, $index) use ($department, $request) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $path = public_path('files\\gesti_doc\\' . $department . ($request->folder ? '\\' . str_replace(' ', '_', remove_accents($request->folder)) : ''));

                $file->move($path, remove_accents($file_name_destination));
            });
        }

        return back()->with('success', 'Los archivos han sido cargados correctamente.');
    }

    public function destroy(Request $request, $file)
    {
        $department = GestiDoc::getDepartment($request->path());

        GestiDoc::deleteFile($department, $file, $request->folder);

        return back()->with('success', 'El archivo ha sido eliminado correctamente.');
    }
}
