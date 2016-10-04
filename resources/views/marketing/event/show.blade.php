@extends('layouts.master')

@section('title', 'Mercadeo -> Eventos')

@section('page_title', 'Subscriptores del Evento')

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <a class="btn btn-warning btn-xs pull-right" target="__blank" href="">Imprimir</a>

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#subscribers" data-toggle="tab">Suscritores <span class="badge">{{ $subscriptions->count() }}</span></a>
                        </li>
                        <li>
                            <a href="#accompanists" data-toggle="tab">Acompañantes <span class="badge">{{ $accompanist_subscriptions->count() }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="subscribers">

                            <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                                <thead>
                                    <tr>
                                        <th>Correo</th>
                                        <th style="width: 52px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->username . '@bancamerica.com.do' }}</td>
                                            <td align="center">
                                                <a
                                                    href="{{ route('marketing.event.unsubscribe', ['event' => $event->id, 'user' => $subscription->username]) }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Dar de Baja"
                                                    class="rojo link_delete">
                                                    <i class="fa fa-close fa-fw"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane" id="accompanists">

                            <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                                <thead>
                                    <tr>
                                        <th>Invitador</th>
                                        <th>Nombre</th>
                                        <th>Identificación</th>
                                        <th>Relación</th>
                                        <th style="width: 52px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accompanist_subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $subscription->owner }}</td>
                                            <td>{{ $subscription->accompanist->names . ' ' . $subscription->accompanist->last_names }}</td>
                                            <td>{{ '(' . get_identification_types($subscription->accompanist->identification_type) . ') ' . $subscription->accompanist->identification }}</td>
                                            <td>{{ get_relationship_types($subscription->accompanist->relationship) }}</td>
                                            <td align="center">
                                                <a
                                                    href="{{ route('marketing.event.subscribe.accompanist', ['event' => $event->id, 'accompanist' => $subscription->accompanist_id]) }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Dar de Baja"
                                                    class="rojo link_delete">
                                                    <i class="fa fa-close fa-fw"></i>
                                                </a>
                                            </td>
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

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('.link_delete').click(function () {
            $(this).remove();
        });
    </script>

@endsection