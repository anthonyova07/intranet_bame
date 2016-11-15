@extends('layouts.master')

@section('title', 'Home')

@section('page_title', $event->title)

@section('contents')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    @if (session()->has('user'))
                        @if ($event->isSubscribe())
                            <a href="{{ route('event.unsubscribe_reason', ['id' => $event->id]) }}" class="btn btn-danger btn-block bame_shake">Cancelar Suscripción</a>
                            <a href="{{ route('events.accompanist.index', ['event' => $event->id]) }}" class="btn btn-success btn-block bame_tada">Ver mis invitados</a>
                        @else
                            @if ($event->canSubscribe())
                                <a href="{{ route('event.subscribe', ['id' => $event->id]) }}" class="btn btn-success btn-block bame_tada">Suscribirse</a>
                            @else
                                <button class="btn btn-default btn-block bame_bounce" style="font-weight: bold;" disabled>No hay cupo disponible</button>
                            @endif
                        @endif
                    @else
                        @if ($event->canSubscribe())
                            <a href="{{ route('event.subscribe', ['id' => $event->id]) }}" class="btn btn-success btn-block bame_tada">Suscribirse</a>
                        @else
                            <button class="btn btn-default btn-block bame_bounce" style="font-weight: bold;" disabled>No hay cupo disponible</button>
                        @endif
                    @endif

                    <a href="{{ route('home.event.subscribers', ['id' => $event->id]) }}" class="btn btn-info btn-block bame_flash">Lista de Inscritos</a>

                    <br>

                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center" style="font-size: 18px;">Detalle del Evento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Fecha del Evento</td>
                                <td>{{ $event->start_event->format('d/m/Y h:i:s A') }}</td>
                            </tr>
                            <tr>
                                <td>Fecha Limite Suscripciones</td>
                                <td>{{ $event->end_subscriptions->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Limite de Personas</td>
                                <td>{{ (int) $event->number_persons }}</td>
                            </tr>
                            <tr>
                                <td>Invitados P/P</td>
                                <td>{{ (int) $event->number_accompanists }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <br>

                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center" style="font-size: 18px;">Estado del Evento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Participantes</td>
                                <td>{{ $event->subscriptions->where('is_subscribe', '1')->count() }}</td>
                            </tr>
                            <tr>
                                <td>Invitados</td>
                                <td>{{ $event->accompanists->where('is_subscribe', '1')->count() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-8">
                    <img src="{{ route('home') . $event->image }}" style="max-height: 280px;margin: 0px 15px 15px 0px;" class="img-thumbnail pull-left">
                    <p  style="color: #616365;" class="text-justify">{!! $event->detail !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
