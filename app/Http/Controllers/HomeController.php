<?php

namespace Bame\Http\Controllers;

use DateTime;
use Bame\Http\Requests;
use Bame\Models\Event\Event;
use Illuminate\Http\Request;
use Bame\Models\Marketing\Coco\Coco;
use Bame\Models\Marketing\News\News;
use Bame\Models\HumanResource\Calendar\Date;
use Bame\Models\HumanResource\Vacant\Vacant;
use Bame\Models\HumanResource\Calendar\Group;
use Bame\Models\Event\Subscription\Subscription;
use Bame\Models\HumanResource\Calendar\Calendar;
use Bame\Models\HumanResource\Employee\Employee;
use Bame\Models\HumanResource\Calendar\Birthdate;
use Bame\Models\Event\Subscription\Accompanist as SubscriptionAccompanist;

class HomeController extends Controller {

    public function index(Request $request) {
        $datetime = new DateTime;

        $column_new = News::column()
            ->where('is_active', true)
            ->where('menu', false)
            ->orderBy('created_at', 'desc')->first();

        $banners_news = News::banners()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(config('bame.banners_quantity'))
            ->get();

        $news = News::news()
            ->where('is_active', true)
            ->where('menu', false)
            ->orderBy('created_at', 'desc')
            ->take(config('bame.news_quantity'))
            ->get();

        $coco = new Coco();

        $events = Event::where('is_active', true)
            ->where('end_subscriptions', '>=', new DateTime)
            ->orderBy('created_at', 'desc')
            ->get();

        $vacancies = Vacant::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $dates = Date::get();

        $day_events = $events->filter(function ($event, $key) use ($datetime) {
            return !(stripos($event->start_event, $datetime->format('Y-m-d')) === FALSE);
        });

        $day_dates = $dates->filter(function ($date, $key) use ($datetime) {
            return !(stripos($date->startdate, $datetime->format('Y-m-d')) === FALSE || !$date->group->showinday);
        });

        $all_birthdate_service_date = $this->all_birthdate_service_date();

        return view('home.index', [
            'column_new' => $column_new,
            'banners_news' => $banners_news,
            'news' => $news,
            'coco' => $coco,
            'events' => $events,
            'vacancies' => $vacancies,
            'datetime' => $datetime,
            'payments_days' => Calendar::getPaymentsDays(),
            'birthdates' => $all_birthdate_service_date['birthdates'],
            'dates' => $dates,
            'day_events' => $day_events,
            'day_birthdays' => $all_birthdate_service_date['day_birthdays'],
            'day_services' => $all_birthdate_service_date['day_services'],
            'day_dates' => $day_dates,
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

    public function all_birthdate_service_date()
    {
        $datetime = datetime();

        $birthdates = Employee::active()->get();

        $day_birthdays = collect();
        $day_services = collect();

        $birthdates->each(function ($employee, $index) use ($datetime, $day_birthdays, $day_services) {
            $current_md = $datetime->format('m-d');
            $birthdate = date_create($employee->birthdate);
            $servicedat = date_create($employee->servicedat);

            if ($birthdate->format('m-d') == $current_md) {
                $day_birthdays->push($employee);
            }

            if ($servicedat->format('m-d') == $current_md) {
                $day_services->push($employee);
            }

            $employee->service_text = $employee->full_name . ' cumple ' . calculate_year_of_service($employee->servicedat);
            $employee->month_day = $birthdate->format('m-d');
            $employee->services_month_day = $servicedat->format('m-d');
        });

        return [
            'birthdates' => $birthdates,
            'day_birthdays' => $day_birthdays,
            'day_services' => $day_services,
        ];
    }
}
