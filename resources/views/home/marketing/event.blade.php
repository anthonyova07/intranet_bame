@extends('layouts.master')

@section('title', 'Home')

@section('page_title', $event->title)

@section('page_title_adicional')
    <button class="btn btn-warning btn-xs pull-right">Subscribirse</button>
    <small style="font-size: 20px;">Creado por Ninoska</small>
@endsection

@section('contents')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    @if (session()->has('user'))
                        @if ($event->isSubscribe())
                            <a href="{{ route('marketing.event.subscribe', ['id' => $event->id]) }}" class="btn btn-danger btn-block bame_wobble">Cancelar Suscripción</a>
                        @else
                            @if ($event->canSubscribe())
                                <a href="{{ route('marketing.event.subscribe', ['id' => $event->id]) }}" class="btn btn-success btn-block bame_tada">Suscribirse</a>
                            @else
                                <button class="btn btn-default btn-block bame_hinge" style="font-weight: bold;" disabled>No hay cupo disponible</button>
                            @endif
                        @endif
                    @else
                        @if ($event->canSubscribe())
                            <a href="{{ route('marketing.event.subscribe', ['id' => $event->id]) }}" class="btn btn-success btn-block bame_tada">Suscribirse</a>
                        @else
                            <button class="btn btn-default btn-block bame_hinge" style="font-weight: bold;" disabled>No hay cupo disponible</button>
                        @endif
                    @endif

                    <br>

                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center" style="font-size: 18px;">Detalle del Evento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Fecha de Inicio</td>
                                <td>{{ $event->start_event->format('d/m/Y h:i:s A') }}</td>
                            </tr>
                            <tr>
                                <td>Fin de Suscripciones</td>
                                <td>{{ $event->end_subscriptions->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Limite de Personas</td>
                                <td>{{ (int) $event->number_persons }}</td>
                            </tr>
                            <tr>
                                <td>Acompañantes P/P</td>
                                <td>{{ (int) $event->number_companions }}</td>
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
                                <td>Acompañantes</td>
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
