<?php

namespace Bame\Http\Controllers\Marketing\Gallery;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\Gallery\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::lastestFirst()->get();

        return view('marketing.gallery.index')
            ->with('galleries', $galleries);
    }

    public function create(Request $request)
    {
        return view('marketing.gallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'image' => 'required',
            'galdate' => 'required|date_format:"Y-m-d"',
        ]);

        $gallery = new Gallery;

        $gallery->id = uniqid(true);
        $gallery->name = $request->name;

        $image = $request->image;
        $parts = explode('.', $image->getClientOriginalName());
        $ext = array_pop($parts);
        $gallery->image = 'portada.' . $ext;

        $gallery->galdate = $request->galdate;
        $gallery->is_active = $request->is_active ? true : false;
        $gallery->created_by = session()->get('user');

        $gallery->save();

        $path = public_path('files\\gallery\\' . $gallery->id);

        $image->move($path, 'portada.' . $ext);

        do_log('Creó el álbum ( nombre:' . strip_tags($request->name) . ' )');

        if ($gallery->is_active) {
            $noti = new Notification('global');
            $noti->create('Nuevo Álbum', $gallery->name, route('home.gallery', ['gallery' => $gallery->id]));
            $noti->save();
        }

        return redirect(route('marketing.gallery.show', ['gallery' => $gallery->id]))->with('success', 'La álbum fue creado correctamente.');
    }

    public function show(Request $request, $gallery)
    {
        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta álbum no existe!');
        }

        return view('marketing.gallery.show')
            ->with('gallery', $gallery)
            ->with('images', Gallery::getFiles($gallery->id));
    }

    public function edit(Request $request, $gallery)
    {
        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta álbum no existe!');
        }

        return view('marketing.gallery.edit')
            ->with('gallery', $gallery);
    }

    public function update(Request $request, $gallery)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'galdate' => 'required|date_format:"Y-m-d"',
        ]);

        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta álbum no existe!');
        }

        $gallery->name = $request->name;

        if ($request->hasFile('image')) {
            $image = $request->image;
            $parts = explode('.', $image->getClientOriginalName());
            $ext = array_pop($parts);
            $gallery->image = 'portada.' . $ext;

            $path = public_path('files\\gallery\\' . $gallery->id);

            $image->move($path, $gallery->image);
        }

        $gallery->galdate = $request->galdate;
        $gallery->is_active = $request->is_active ? true : false;
        $gallery->updated_by = session()->get('user');

        $gallery->save();

        do_log('Modificó el álbum ( nombre:' . strip_tags($request->name) . ' )');

        if ($gallery->is_active) {
            $noti = new Notification('global');
            $noti->create('Álbum Actualizado', $gallery->name, route('home.gallery', ['gallery' => $gallery->id]));
            $noti->save();
        }

        return redirect(route('marketing.gallery.show', ['gallery' => $gallery->id]))->with('success', 'La álbum fue modificada correctamente.');
    }

    public function destroy($id)
    {
        Gallery::deleteAlbum($id);

        $gallery = Gallery::find($id);

        if (!$gallery) {
            return back()->with('warning', 'Esta álbum no existe!');
        }

        $gallery->delete();

        return back()->with('success', 'El álbum ha sido eliminado correctamente.');
    }

    public function upload(Request $request, $gallery)
    {
        $this->validate($request, ['images' => 'required']);

        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta álbum no existe!');
        }

        if ($request->hasFile('images')) {
            $images = collect($request->file('images'));

            $images->each(function ($image, $index) use ($gallery) {
                $file_name_destination = str_replace(' ', '_', $image->getClientOriginalName());

                $path = public_path('files\\gallery\\' . $gallery->id);

                $image->move($path, remove_accents($file_name_destination));
            });

            $noti = new Notification('global');
            $noti->create('Álbum Actualizado', $gallery->name, route('home.gallery', ['gallery' => $gallery->id]));
            $noti->save();
        }

        return back()->with('success', 'Las imágenes han sido cargadas correctamente.');
    }

    public function delete_image(Request $request, $gallery, $image)
    {
        Gallery::deleteImage($gallery, $image);

        return back()->with('success', 'La imagen ha sido eliminada correctamente.');
    }
}
