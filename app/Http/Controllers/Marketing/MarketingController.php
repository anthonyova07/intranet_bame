<?php

namespace Bame\Http\Controllers\Marketing;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\News\News;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Models\Marketing\Coco\Idea;
use Bame\Models\Marketing\Gallery\Gallery;

class MarketingController extends Controller
{
    public function news($id)
    {
        $new = News::find($id);

        if (!$new) {
            return back()->with('warning', 'Esta noticia no existe.');
        }

        if ($new->type == 'C' || $new->type == 'N') {
            return view('home.marketing.new')
                ->with('new', $new);
        }

        if ($new->type == 'B') {
            return view('home.marketing.banner')
                ->with('banner', $new);
        }

        return view('home.marketing.new.index');
    }

    public function coco()
    {
        $coco = new Coco;

        return view('home.marketing.coco')
            ->with('coco', $coco);
    }

    public function idea(Request $request)
    {
        $idea = new Idea;

        $idea->id = uniqid(true);
        $created_by = $request->mail;

        if (session()->has('user')) {
            $idea->names = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
            $idea->mail = session()->get('user') . '@bancamerica.com.do';
        } else {
            $request->replace([
                'name_last_name' => $request->name_last_name,
                'mail' => $request->mail . '@bancamerica.com.do',
                'idea' => $request->idea,
            ]);

            $this->validate($request, [
                'name_last_name' => 'required|max:150',
                'mail' => 'required|email|max:45',
            ]);

            $idea->names = clear_tag($request->name_last_name);
            $idea->mail = clear_tag($request->mail);
        }

        $this->validate($request, [
            'idea' => 'required|max:10000',
        ]);

        $idea->idea = clear_tag(nl2br($request->idea));
        $idea->created_by = session()->has('user') ? session()->get('user') : $created_by;

        $idea->save();

        return redirect(route('home'))->with('success', 'La idea fue creada correctamente.');
    }

    public function gallery(Request $request, $gallery = null)
    {
        $galleries = collect();

        if ($gallery) {
            $gallery = Gallery::find($gallery);

            if (!$gallery) {
                return back()->with('warning', 'Esta galería no existe!');
            }
        } else {
            $galleries = Gallery::onlyActive()->get();
        }

        return view('home.marketing.gallery')
            ->with('gallery', $gallery)
            ->with('images', $gallery ? Gallery::getFiles($gallery->id) : collect())
            ->with('galleries', $galleries);
    }

}
