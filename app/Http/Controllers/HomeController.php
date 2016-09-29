<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;

use DateTime;
use Bame\Models\Marketing\News\News;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Models\Marketing\Event\Event;

class HomeController extends Controller {

    public function index(Request $request) {
        $column_new = News::where('type', 'C')
            ->orderBy('created_at', 'desc')->first();

        $banners_news = News::where('type', 'B')
            ->orderBy('created_at', 'desc')
            ->take(env('BANNERS_QUANTITY'))
            ->get();

        $news = News::where('type', 'N')
            ->orderBy('created_at', 'desc')
            ->take(env('NEWS_QUANTITY'))
            ->get();

        $coco = new Coco();

        $events = Event::where('is_active', true)
            ->where('start_event', '>=', new DateTime)
            ->get();

        return view('home.index', [
            'column_new' => $column_new,
            'banners_news' => $banners_news,
            'news' => $news,
            'coco' => $coco,
            'events' => $events
        ]);
    }

}
