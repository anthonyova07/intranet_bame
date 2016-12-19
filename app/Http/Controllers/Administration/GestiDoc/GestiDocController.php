<?php

namespace Bame\Http\Controllers\Administration\GestiDoc;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Administration\GestiDoc\GestiDoc;
use Bame\Models\Notification\Notification;

class GestiDocController extends Controller
{
    public function download(Request $request, $folder, $file)
    {
        $gestidoc = GestiDoc::where('id', $folder);

        if (can_not_do('adm_gestidoc_maintenance')) {
            $gestidoc = $gestidoc->where('usrsaccess', 'like', '%'.session()->get('user').'%');
        }

        $gestidoc = $gestidoc->first();

        if (!$gestidoc) {
            return back()->with('warning', 'La carpeta indicada no existe o no tiene acceso a la misma.');
        }

        $path = storage_path('app\\gesti_doc\\' . $folder. '\\' . $file);

        return response()->download($path);
    }

    public function index(Request $request)
    {
        $can_not_do = can_not_do('adm_gestidoc_maintenance');

        $gestidoc = GestiDoc::where('id', $request->folder);

        if ($can_not_do) {
            $gestidoc = $gestidoc->where(function ($query) {
                $query->where('usrsaccess', 'like', '%'.session()->get('user').'%')->orWhere('usrsaccess', null)->orWhere('usrsaccess', '');
            });
        }

        $gestidoc = $gestidoc->first();

        $files = $gestidoc ? $gestidoc->getFiles() : collect();

        if ($can_not_do) {
            $gestidocs = GestiDoc::where('parent_id', $request->folder ?? '')->where(function ($query) {
                $query->where('usrsaccess', 'like', '%'.session()->get('user').'%')->orWhere('usrsaccess', null)->orWhere('usrsaccess', '');
            })->get();
        } else {
            $gestidocs = GestiDoc::where('parent_id', $request->folder ?? '')->get();
        }

        return view('administration.gestidoc.index')
            ->with('gestidoc', $gestidoc)
            ->with('files', $files)
            ->with('gestidocs', $gestidocs)
            ->with('folder', $request->folder)
            ->with('can_not_do', $can_not_do);
    }

    public function store(Request $request)
    {
        if (can_not_do('adm_gestidoc_maintenance')) {
            return back()->with('error', 'Usted no tiene permiso para realizar esta acción.');
        }

        if ($request->type) {
            if ($request->type == 'folder') {
                $this->validate($request, [
                    'folder_name' => 'required|max:150'
                ]);

                $gestidoc = new GestiDoc;

                $gestidoc->id = uniqid(true);
                $gestidoc->parent_id = $request->folder;
                $gestidoc->name = $request->folder_name;
                $gestidoc->created_by = session()->get('user');

                $gestidoc->save();

                return back()->with('success', 'Carpeta creada correctamente.');
            }

            if ($request->type == 'files') {
                $gestidoc = GestiDoc::find($request->folder);

                if (!$gestidoc) {
                    return back()->with('warning', 'La carpeta indicada no existe.');
                }

                if ($request->hasFile('files')) {
                    $files = collect($request->file('files'));

                    $files->each(function ($file, $index) use ($request, $gestidoc) {
                        $file_name_destination = remove_accents(str_replace(' ', '_', $file->getClientOriginalName()));

                        $path = storage_path('app\\gesti_doc\\' . $gestidoc->id);

                        $file->move($path, $file_name_destination);
                    });

                    return back()->with('success', 'Los archivos han sido cargados correctamente.');
                }

                return back()->with('warning', 'Debe seleccionar los archivos a cargar.');
            }
        }
    }

    public function update(Request $request, $gestidoc)
    {
        if (can_not_do('adm_gestidoc_maintenance')) {
            return back()->with('error', 'Usted no tiene permiso para realizar esta acción.');
        }

        if ($request->type) {
            $gestidoc = GestiDoc::find($gestidoc);

            if (!$gestidoc) {
                return back()->with('warning', 'La carpeta indicada no existe.');
            }

            if ($request->type == 'rename') {
                if ($request->folder_name) {
                    $gestidoc->name = $request->folder_name;
                    $gestidoc->updated_by = session()->get('user');

                    $gestidoc->save();
                }
            }

            if ($request->type == 'access') {
                $gestidoc->usrsaccess = $request->usrsaccess;
                $gestidoc->updated_by = session()->get('user');

                $gestidoc->save();
            }
        }

        return back();
    }

    public function destroy(Request $request, $gestidoc)
    {
        if (can_not_do('adm_gestidoc_maintenance')) {
            return back()->with('error', 'Usted no tiene permiso para realizar esta acción.');
        }

        $gestidoc = GestiDoc::find($gestidoc);

        if (!$gestidoc) {
            return back()->with('warning', 'La carpeta indicada no existe.');
        }

        $gestidoc->deleteFile($request->file);

        return back()->with('success', 'El archivo ha sido eliminado correctamente.');
    }
}
