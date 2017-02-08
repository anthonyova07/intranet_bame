<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests;

use DateTime;
use Bame\Models\Event\Event;
use Bame\Models\Marketing\News\News;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Models\HumanResource\Vacant\Vacant;
use Bame\Models\Event\Subscription\Subscription;
use Bame\Models\Event\Subscription\Accompanist as SubscriptionAccompanist;

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
            ->where('end_subscriptions', '>=', new DateTime)
            ->orderBy('created_at', 'desc')
            ->get();

        $vacancies = Vacant::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home.index', [
            'column_new' => $column_new,
            'banners_news' => $banners_news,
            'news' => $news,
            'coco' => $coco,
            'events' => $events,
            'vacancies' => $vacancies,
        ]);
    }

    public function event($id)
    {
        $event = Event::find($id);

        return view('home.event.index')
            ->with('event', $event);
    }

    public function subscribers($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->with('warning', 'Este evento no existe!');
        }

        $subscriptions = Subscription::where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->get();

        $accompanist_subscriptions = SubscriptionAccompanist::with('accompanist')
                                        ->where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->get();

        return view('home.event.subscribers')
            ->with('event', $event)
            ->with('subscriptions', $subscriptions)
            ->with('accompanist_subscriptions', $accompanist_subscriptions);

        return view('home.event.subscribers')
            ->with('event', $event);
    }
}
