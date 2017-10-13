<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Suscriptores</h3>
            </div>
            <div class="panel-body">

                <a class="pull-right label label-warning" style="font-size: 13px;" target="__blank" href="{{ route('event.subscribers.print', ['event' => $event->id, 'format' => 'pdf']) }}">Imprimir</a>

                <div class="pull-right">&nbsp;</div>

                {{-- <a class="btn btn-success btn-xs pull-right" target="__blank" href="{{ route('marketing.event.subscribers.print', ['event' => $event->id, 'format' => 'excel']) }}">EXCEL</a> --}}

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#subscribers" data-toggle="tab">Suscritos <span class="badge">{{ $subscriptions->count() }}</span></a>
                    </li>
                    <li>
                        <a href="#accompanists" data-toggle="tab">Invitados <span class="badge">{{ $accompanist_subscriptions->count() }}</a>
                    </li>
                    <li>
                        <a href="#unsubscribers" data-toggle="tab">Cancelados <span class="badge">{{ $unsubscriptions->count() }}</span></a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="subscribers">

                        <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th style="width: 52px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->names }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('event.unsubscribe_reason', ['id' => $event->id, 'user' => $subscription->username, 'department' => Request::get('department')]) }}"
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
                                    <th>Empleado</th>
                                    <th>Invitado</th>
                                    <th>Identificación</th>
                                    <th>Relación</th>
                                    <th>Edad</th>
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
                                        <td>{{ $subscription->accompanist->age }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('event.unsubscribe.accompanist', ['event' => $event->id, 'user' => $subscription->owner, 'accompanist' => $subscription->accompanist_id]) }}"
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

                    <div class="tab-pane" id="unsubscribers">

                        <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unsubscriptions as $unsubscription)
                                    <tr>
                                        <td>{{ $unsubscription->names }}</td>
                                        <td>{{ $unsubscription->unsubscription_reason }}</td>
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
