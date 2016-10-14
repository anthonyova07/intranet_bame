<?php

namespace Bame\Http\Controllers\Marketing;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\News\News;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Models\Marketing\Event\Event;

class MarketingController extends Controller
{
    public function gesticdoc()
    {
        $url_files = public_path('files\\gestic_doc\\marketing');

        $files = collect();

        if (file_exists($url_files)) {
            $list = collect(scandir($url_files));

            $list->each(function ($item, $index) use ($files) {
                if ($item != '.' && $item != '..') {
                    $file = new \stdClass;

                    $parts = explode('.', $item);

                    $file->url = route('home') . '/files/gestic_doc/marketing/' . $item;

                    $file->name = $parts[0];
                    $file->type = array_pop($parts);

                    $files->push($file);
                }
            });
        }

        return view('home.marketing.gestic_doc')
            ->with('files', $files);
    }

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

    public function event($id)
    {
        $event = Event::find($id);

        return view('home.marketing.event')
            ->with('event', $event);
    }

    public function coco()
    {
        $coco = new Coco();

        return view('home.marketing.coco')
            ->with('coco', $coco);
    }

    public function post_coco()
    {
        return back()->with('info', 'El concurso pronto estará disponible.');
    }

}
