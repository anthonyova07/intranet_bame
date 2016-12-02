@extends('layouts.master')

@section('title', 'Eventos')

@section('page_title', 'Suscriptores del Evento: ' . $event->title)

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Suscriptores</h3>
                </div>
                <div class="panel-body">

                    <a class="btn btn-info btn-xs" href="{{ route('home.event', ['id' => $event->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>

                    <br>
                    <br>

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#subscribers" data-toggle="tab">Suscritos <span class="badge">{{ $subscriptions->count() }}</span></a>
                        </li>
                        <li>
                            <a href="#accompanists" data-toggle="tab">Invitados <span class="badge">{{ $accompanist_subscriptions->count() }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="subscribers">

                            <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->names }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane" id="accompanists">

                            <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                                <thead>
                                    <tr>
                                        <th>Empleado</th>
                                        <th>Invitado</th>
                                        <th>Identificación</th>
                                        <th>Relación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accompanist_subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->owner }}</td>
                                            <td>{{ $subscription->accompanist->names . ' ' . $subscription->accompanist->last_names }}</td>
                                            <td>{{ '(' . get_identification_types($subscription->accompanist->identification_type) . ') ' . $subscription->accompanist->identification }}</td>
                                            <td>{{ get_relationship_types($subscription->accompanist->relationship) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
