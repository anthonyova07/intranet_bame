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
        $theme = new Theme;
        $theme->id = uniqid(true);
        $theme->name = clear_tag(htmlentities($request->name));
        $theme->is_active = $request->active ? true : false;
        $theme->created_by = session()->get('user');

        $theme->save();

        do_log('Creó el Tema de Pregunta Frecuente ( nombre:' . strip_tags($request->name) . ' )');

        if ($theme->is_active) {
            Notification::notify('Nuevo Tema de Pregunta Frecuente', $request->name, '', 'global');
        }

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente fue creada correctamente.');

    }

    public function edit($id)
    {
        $theme = Theme::find($id);

        if (!$theme) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        return view('marketing.faqs.themes.edit')
            ->with('theme', $theme);
    }

    public function update(ThemesRequest $request, $id)
    {
        $theme = Theme::find($id);

        if (!$theme) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        $theme->name = clear_tag(htmlentities($request->name));
        $theme->is_active = $request->active ? true : false;
        $theme->updated_by = session()->get('user');

        $theme->save();

        do_log('Editó el Tema de Pregunta Frecuente ( nombre:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente ha sido modificada correctamente.');
    }
}
