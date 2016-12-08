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
        $galleries = Gallery::get();

        return view('marketing.gallery.index')
            ->with('galleries', $galleries);
    }

    public function create(Request $request)
    {
        return view('marketing.gallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|max:150']);

        $gallery = new Gallery;

        $gallery->id = uniqid(true);
        $gallery->name = $request->name;
        $gallery->is_active = $request->is_active ? true : false;
        $gallery->created_by = session()->get('user');

        $gallery->save();

        do_log('Creó el álbum ( nombre:' . strip_tags($request->name) . ' )');

        if ($gallery->is_active) {
            // $noti = new Notification('global');
            // $noti->create('Nuevo Álbum', $event->title, route('home.event', ['id' => $event->id]));
            // $noti->save();
        }

        return redirect(route('marketing.gallery.show', ['gallery' => $gallery->id]))->with('success', 'La galería fue creado correctamente.');
    }

    public function show(Request $request, $gallery)
    {
        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta galería no existe!');
        }

        return view('marketing.gallery.show')
            ->with('gallery', $gallery)
            ->with('images', Gallery::getFiles($gallery->id));
    }

    public function edit(Request $request, $gallery)
    {
        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta galería no existe!');
        }

        return view('marketing.gallery.edit')
            ->with('gallery', $gallery);
    }

    public function update(Request $request, $gallery)
    {
        $this->validate($request, ['name' => 'required|max:150']);

        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta galería no existe!');
        }

        $gallery->name = $request->name;
        $gallery->is_active = $request->is_active ? true : false;
        $gallery->updated_by = session()->get('user');

        $gallery->save();

        do_log('Modificó el álbum ( nombre:' . strip_tags($request->name) . ' )');

        if ($gallery->is_active) {
            // $noti = new Notification('global');
            // $noti->create('Álbum Actualizado', $event->title, route('home.event', ['id' => $event->id]));
            // $noti->save();
        }

        return redirect(route('marketing.gallery.show', ['gallery' => $gallery->id]))->with('success', 'La galería fue modificada correctamente.');
    }

    public function upload(Request $request, $gallery)
    {
        $this->validate($request, ['images' => 'required']);

        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            return back()->with('warning', 'Esta galería no existe!');
        }

        if ($request->hasFile('images')) {
            $images = collect($request->file('images'));

            $images->each(function ($image, $index) use ($gallery) {
                $file_name_destination = str_replace(' ', '_', $image->getClientOriginalName());

                $path = public_path('files\\gallery\\' . $gallery->id);

                $image->move($path, remove_accents($file_name_destination));
            });
        }

        return back()->with('success', 'Las imágenes han sido cargadas correctamente.');
    }

    public function delete_image(Request $request, $gallery, $image)
    {
        Gallery::deleteImage($gallery, $image);

        return back()->with('success', 'La imagen ha sido eliminada correctamente.');
    }
}
