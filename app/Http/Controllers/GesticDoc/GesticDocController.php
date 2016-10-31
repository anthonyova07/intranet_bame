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
        $department = GesticDoc::getDepartment($request->path(), true);

        $files = GesticDoc::getFiles($department);

        return view('home.gestic_doc')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function index(Request $request)
    {
        $department = GesticDoc::getDepartment($request->path());

        $files = GesticDoc::getFiles($department);

        return view($department . '.gestic_doc.index')
            ->with('department', $department)
            ->with('files', $files);
    }

    public function store(Request $request)
    {
        $department = GesticDoc::getDepartment($request->path());

        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));
            $files->each(function ($file, $index) use ($department) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $file->move(public_path('files\\gestic_doc\\' . $department), remove_accents($file_name_destination));
            });
        }

        return back()->with('success', 'Los archivos han sido cargados correctamente.');
    }

    public function destroy(Request $request, $file)
    {
        $department = GesticDoc::getDepartment($request->path());

        GesticDoc::deleteFile($department, $file);

        return back()->with('success', 'El archivo ha sido eliminado correctamente.');
    }
}
