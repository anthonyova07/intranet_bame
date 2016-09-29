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
                    <button class="btn btn-warning btn-block">Subscribirse</button>

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
                                <td>{{ (int) $event->limit_persons }}</td>
                            </tr>
                            <tr>
                                <td>Acompañantes P/P</td>
                                <td>{{ (int) $event->limit_companions }}</td>
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
                                <td>40</td>
                            </tr>
                            <tr>
                                <td>Acompañantes</td>
                                <td>7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-8">
                    <img src="http://3.bp.blogspot.com/_QZXzZ365U0Y/TM7j37ITJXI/AAAAAAAAAnM/0jSSvPWctHA/s1600/BM1.JPG" style="max-height: 280px;margin: 0px 15px 15px 0px;" class="img-thumbnail pull-left">
                    <p>{!! $event->detail !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
