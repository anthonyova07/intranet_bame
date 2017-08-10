<?php

namespace Bame\Http\Controllers\Event;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Event\Event;
use Bame\Models\Event\Subscription\Subscription;
use Bame\Models\Event\Subscription\Accompanist as SubscriptionAccompanist;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, $id)
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

                $this->validate($request, [
                    'unsubscription_reason' => 'required|max:150',
                ]);

                Subscription::where('event_id', $event->id)
                    ->where('username', session()->get('user'))
                    ->update([
                        'is_subscribe' => false,
                        'unsubscription_reason' => ucfirst($request->unsubscription_reason),
                    ]);

                SubscriptionAccompanist::where('event_id', $event->id)
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
                    'unsubscription_reason' => '',
                ]);

            return redirect(route('home.event', ['id' => $event->id]))->with('success', 'Usted ha sido suscrito al evento correctamente!');
        }

        if (!$event->canSubscribe()) {
            return $redirect->with('warning', 'Este evento no tiene cupo disponible!');
        }

        $subscription = new Subscription;

        $subscription->event_id = $id;
        $subscription->username = session()->get('user');
        $subscription->names = cap_str(session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName());
        $subscription->unsubscription_reason = '';
        $subscription->is_subscribe = true;

        $subscription->save();

        return redirect(route('home.event', ['id' => $event->id]))->with('success', 'Usted ha sido suscrito al evento correctamente!');
    }

    public function unsubscribe(Request $request, $event, $user)
    {
        $this->validate($request, [
            'unsubscription_reason' => 'required|max:150',
        ]);

        Subscription::where('event_id', $event)
            ->where('username', $user)
            ->update([
                'is_subscribe' => false,
                'unsubscription_reason' => ucfirst($request->unsubscription_reason),
            ]);

        SubscriptionAccompanist::where('event_id', $event)
            ->where('owner', $user)
            ->update([
                'is_subscribe' => false,
            ]);

        return redirect(route($request->department . '.event.show', ['id' => $event, 'department' => $request->department]))->with('success', 'Al usuario e invitados se le han dado de baja correctamente!');
    }

    public function unsubscribe_reason(Request $request, $id)
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

        return view('event.unsubscription_reason')
            ->with('event_id', $id)
            ->with('user', $request->user);
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
                SubscriptionAccompanist::where('event_id', $event->id)
                    ->where('owner', session()->get('user'))
                    ->where('accompanist_id', $accompanist)
                    ->update([
                        'is_subscribe' => false,
                    ]);

                return back()->with('success', 'La suscripción al evento de su Invitado ha sido cancelada correctamente!');
            }

            if (!$event->canSubscribe()) {
                return redirect(route('home.event', ['id' => $event->id]))->with('warning', 'Usted ha excedido el limite de Invitados para este evento o no hay cupo disponible!');
            }

            SubscriptionAccompanist::where('event_id', $event->id)
                ->where('owner', session()->get('user'))
                ->where('accompanist_id', $accompanist)
                ->update([
                    'is_subscribe' => true,
                ]);

            return back()->with('success', 'Su Invitado ha sido suscrito al evento correctamente!');
        }

        if (!$event->canSubscribe()) {
            return redirect(route('home.event', ['id' => $event->id]))->with('warning', 'Usted ha excedido el limite de Invitados para este evento o no hay cupo disponible!');
        }

        $subscription = new SubscriptionAccompanist;

        $subscription->event_id = $event->id;
        $subscription->owner = session()->get('user');
        $subscription->accompanist_id = $accompanist;
        $subscription->is_subscribe = true;

        $subscription->save();

        return back()->with('success', 'Su Invitado ha sido suscrito al evento correctamente!');
    }

    public function unsubscribeAccompanist($event, $user, $accompanist)
    {
        SubscriptionAccompanist::where('event_id', $event)
            ->where('owner', $user)
            ->where('accompanist_id', $accompanist)
            ->update([
                'is_subscribe' => false,
            ]);

        return back()->with('success', 'Al invitado se le ha dado de baja correctamente!');
    }

    public function print($event, $format)
    {
        $datetime = new DateTime;
        $event = Event::find($event);

        $subscriptions = Subscription::where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->orderBy('names')
                                        ->get();

        $accompanist_subscriptions = SubscriptionAccompanist::with('accompanist')
                                        ->where('event_id', $event->id)
                                        ->where('is_subscribe', '1')
                                        ->get();

        $subscriptions->each(function ($subscription, $index) use ($accompanist_subscriptions) {
            $subscription->accompanists = $accompanist_subscriptions->where('owner', $subscription->username)->values();
        });

        return view('pdfs.event.subscribers')
            ->with('event', $event)
            ->with('subscriptions', $subscriptions)
            ->with('accompanist_subscriptions', $accompanist_subscriptions)
            ->with('format', $format)
            ->with('datetime', $datetime);
    }
}
