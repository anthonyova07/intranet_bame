<?php

namespace Bame\Http\Controllers\Marketing\FAQs;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\FAQs\FAQs;
use Bame\Models\Marketing\FAQs\Theme;
use Bame\Http\Requests\Marketing\FAQs\FAQsRequest;

class FAQsController extends Controller
{
    public function index(Request $request)
    {
        $faqs = FAQs::all();

        $themes = Theme::all();

        return view('marketing.faqs.index')
            ->with('themes', $themes)
            ->with('faqs', $faqs);
    }

    public function create()
    {
        $themes = Theme::all();

        return view('marketing.faqs.create')
            ->with('themes', $themes);
    }

    public function store(FAQsRequest $request)
    {
        $faq = new FAQs;
        $faq->id = uniqid(true);
        $faq->theme_id = $request->theme;
        $faq->question = clear_tag(htmlentities($request->question));
        $faq->answer = htmlentities($request->answer);
        $faq->is_active = $request->active ? true : false;

        $faq->created_by = session()->get('user');

        $faq->save();

        do_log('Creó la Pregunta Frecuente ( pregunta:' . strip_tags($request->question) . ' )');

        if ($faq->is_active) {
            // Notification::notify('Nueva Pregunta Frecuente', $request->question, route('home.FAQs', ['id' => $faq->id]), 'global');
        }

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente fue creada correctamente.');

    }

    public function edit($id)
    {
        $faq = FAQs::find($id);

        if (!$faq) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        $themes = Theme::all();

        return view('marketing.faqs.edit')
            ->with('themes', $themes)
            ->with('faq', $faq);
    }

    public function update(FAQsRequest $request, $id)
    {
        $faq = FAQs::find($id);

        if (!$faq) {
            return back()->with('warning', 'Esta Pregunta Frecuente no existe!');
        }

        $faq->theme_id = $request->theme;
        $faq->question = clear_tag(htmlentities($request->question));
        $faq->answer = htmlentities($request->answer);
        $faq->is_active = $request->active ? true : false;

        $faq->updated_by = session()->get('user');

        $faq->save();

        do_log('Editó la Pregunta Frecuente ( pregunta:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.faqs.index'))->with('success', 'La Pregunta Frecuente ha sido modificada correctamente.');
    }
}
