<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Marketing\Event\Event;
use Bame\Models\Marketing\Event\Subscription\Subscription;
use Bame\Models\Marketing\Event\Subscription\Accompanist as AccompanistSubscription;

class SubscriptionController extends Controller
{
    public function subscribe($id)
    {
        $redirect =  redirect(route('home'));
        $datetime = new DateTime;

        $event = Event::find($id);

        if (!$event) {
            return $redirect->with('error', 'El evento solicitado no existe!');
        }

        if ($datetime >= $event->end_subscriptions || !$event->is_active) {
            return $redirect->with('warning', 'La fecha de suscripción del evento ha caducado o esta inactivo!');
        }

        $user_subscription = $event->userSubscription();

        if ($user_subscription) {
            if ($user_subscription->is_subscribe) {
                Subscription::where('event_id', $event->id)
                    ->where('username', session()->get('user'))
                    ->update([
                        'is_subscribe' => false,
                    ]);

                AccompanistSubscription::where('event_id', $event->id)
                    ->where('owner', session()->get('user'))
                    ->update([
                        'is_subscribe' => false,
                    ]);

                return redirect(route('home.event', ['id' => $event->id]))->with('success', 'Su suscripción al evento ha sido cancelada correctamente!');
            }

            if (!$event->canSubscribe()) {
                return $redirect->with('warning', 'Este evento no tiene cupo disponible!');
            }

            Subscription::where('event_id', $event->id)
                ->where('username', session()->get('user'))
                ->update([
                    'is_subscribe' => true,
                ]);

            return redirect(route('marketing.event.accompanist.index', ['event' => $event->id]))->with('success', 'Usted ha sido suscrito al evento correctamente!');
        }

        if (!$event->canSubscribe()) {
            return $redirect->with('warning', 'Este evento no tiene cupo disponible!');
        }

        $subscription = new Subscription;

        $subscription->event_id = $id;
        $subscription->username = session()->get('user');
        $subscription->is_subscribe = true;

        $subscription->save();

        return redirect(route('home.event', ['id' => $event->id]))->with('success', 'Usted ha sido suscrito al evento correctamente!');
    }

    public function unsubscribe($event, $user)
    {
        Subscription::where('event_id', $event)
            ->where('username', $user)
            ->update([
                'is_subscribe' => false,
            ]);

        AccompanistSubscription::where('event_id', $event)
            ->where('owner', $user)
            ->update([
                'is_subscribe' => false,
            ]);

        return back()->with('success', 'Al usuario y acompañantes se le han dado de baja correctamente!');
    }

    public function subscribeAccompanist($event, $accompanist)
    {
        $redirect =  redirect(route('home'));
        $datetime = new DateTime;

        $event = Event::find($event);

        if (!$event) {
            return $redirect->with('error', 'El evento solicitado no existe!');
        }

        if ($datetime >= $event->end_subscriptions || !$event->is_active) {
            return $redirect->with('warning', 'La fecha de suscripción del evento ha caducado o esta inactivo!');
        }

        $accompanist_subscription = $event->accompanistSubscription($accompanist);

        if ($accompanist_subscription) {
            if ($accompanist_subscription->is_subscribe) {
                AccompanistSubscription::where('event_id', $event->id)
                    ->where('owner', session()->get('user'))
                    ->where('accompanist_id', $accompanist)
                    ->update([
                        'is_subscribe' => false,
                    ]);

                return back()->with('success', 'La suscripción al evento de su acompañante ha sido cancelada correctamente!');
            }

            if (!$event->canSubscribe()) {
                return redirect(route('home.event', ['id' => $event->id]))->with('warning', 'Usted ha excedido el limite de acompañantes para este evento!');
            }

            AccompanistSubscription::where('event_id', $event->id)
                ->where('owner', session()->get('user'))
                ->where('accompanist_id', $accompanist)
                ->update([
                    'is_subscribe' => true,
                ]);

            return back()->with('success', 'Su Acompañante ha sido suscrito al evento correctamente!');
        }

        if (!$event->canSubscribe()) {
            return redirect(route('home.event', ['id' => $event->id]))->with('warning', 'Usted ha excedido el limite de acompañantes para este evento!');
        }

        $subscription = new AccompanistSubscription;

        $subscription->event_id = $event->id;
        $subscription->owner = session()->get('user');
        $subscription->accompanist_id = $accompanist;
        $subscription->is_subscribe = true;

        $subscription->save();

        return back()->with('success', 'Su Acompañante ha sido suscrito al evento correctamente!');
    }
}
