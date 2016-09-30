<?php

namespace Bame\Http\Controllers\Marketing\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Marketing\Event\Event;
use Bame\Models\Marketing\Event\Subscription\Subscription;

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

            return redirect(route('home.event', ['id' => $event->id]))->with('success', 'Usted ha sido suscrito al evento correctamente!');
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
}
