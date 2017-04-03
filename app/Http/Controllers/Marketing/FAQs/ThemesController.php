<?php

namespace Bame\Http\Controllers\Marketing\FAQs;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\FAQs\Theme;
use Bame\Http\Requests\Marketing\FAQs\ThemesRequest;

class ThemesController extends Controller
{
    public function create()
    {
        return view('marketing.faqs.themes.create');
    }

    public function store(ThemesRequest $request)
    {
        $new = new Theme;
        $new->id = uniqid(true);
        $new->title = clear_tag(htmlentities($request->title));
        $new->detail = htmlentities($request->detail);

        if ($request->hasFile('image')) {
            $file_name_destination = $new->id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->image = '/marketing/images/' . $file_name_destination;
        }

        $new->type = $request->type;
        $new->link_name = $request->link_name;
        $new->link = $request->link;
        $new->link_video = $request->link_video;
        $new->created_by = session()->get('user');

        $new->save();

        do_log('Creó la Pregunta Frecuente ( titulo:' . strip_tags($request->title) . ' )');

        $noti = new Notification('global');
        $noti->create('Nueva Pregunta Frecuente', $request->title, route('home.FAQs', ['id' => $new->id]));
        $noti->save();

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente fue creada correctamente.');

    }

    public function edit($id)
    {
        $new = FAQs::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        return view('marketing.faqs.edit')
            ->with('new', $new);
    }

    public function update(ThemesRequest $request, $id)
    {
        $new = FAQs::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        $new->title = clear_tag(htmlentities($request->title));
        $new->detail = htmlentities($request->detail);

        if ($request->hasFile('image')) {
            $file_name = public_path() . str_replace('/', '\\', $new->image);

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            $file_name_destination = $id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->image = '/marketing/images/' . $file_name_destination;
        }

        $new->type = $request->type;
        $new->link_name = $request->link_name;
        $new->link = $request->link;
        $new->link_video = $request->link_video;
        $new->updated_by = session()->get('user');

        if ($request->repost) {
            $new->created_at = new DateTime;
        }

        $new->save();

        do_log('Editó la Pregunta Frecuente ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente ha sido modificada correctamente.');
    }

    public function destroy($id)
    {
        $new = FAQs::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        $file_name = public_path() . str_replace('/', '\\', $new->image);

        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $new->delete();

        do_log('Eliminó la Pregunta Frecuente ( titulo:' . strip_tags($new->title) . ' )');

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente ha sido eliminada correctamente.');
    }
}
