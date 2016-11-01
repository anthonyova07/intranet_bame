<?php

namespace Bame\Http\Controllers\GesticDoc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\GesticDoc\GesticDoc;

class GesticDocController extends Controller
{
    public function gesticdoc(Request $request)
    {
        $department = GesticDoc::getDepartment($request->url(), true);

        $files = GesticDoc::getFiles($department, $request->folder);

        return view('home.gestic_doc')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function index(Request $request)
    {
        $department = GesticDoc::getDepartment($request->path());

        $files = GesticDoc::getFiles($department, $request->folder, true);

        return view($department . '.gestic_doc.index')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function store(Request $request)
    {
        $department = GesticDoc::getDepartment($request->path());

        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));
            $files->each(function ($file, $index) use ($department, $request) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $path = public_path('files\\gestic_doc\\' . $department . ($request->folder ? '\\' . str_replace(' ', '_', remove_accents($request->folder)) : ''));
                // dd($path);
                $file->move($path, remove_accents($file_name_destination));
            });
        }

        return back()->with('success', 'Los archivos han sido cargados correctamente.');
    }

    public function destroy(Request $request, $file)
    {
        $department = GesticDoc::getDepartment($request->path());

        GesticDoc::deleteFile($department, $file, $request->folder);

        return back()->with('success', 'El archivo ha sido eliminado correctamente.');
    }
}
