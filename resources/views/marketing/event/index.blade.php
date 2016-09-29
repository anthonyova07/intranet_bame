@extends('layouts.master')

@section('title', 'Mercadeo -> Eventos')

@section('page_title', 'Mantenimiento de Eventos')

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('marketing.event.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando eventos...">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.event.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th style="width: 100px;">Inicio del Evento</th>
                                <th style="width: 90px;">Fin de Suscripciones</th>
                                <th style="width: 70px;">Maximo de Personas</th>
                                <th style="width: 50px;">Maximo de Acompañantes</th>
                                <th style="width: 112px;">Fecha</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->start_event->format('Y-m-d H:i') }}</td>
                                    <td>{{ $event->end_subscriptions->format('Y-m-d') }}</td>
                                    <td>{{ $event->number_persons }}</td>
                                    <td>{{ $event->number_companions }}</td>
                                    <td>{{ $event->created_at }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.event.edit', ['id' => $event->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            onclick="cancel('{{ $event->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('marketing.event.destroy', ['id' => $event->id]) }}"
                                            method="post" id="form_eliminar_{{ $event->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este evento?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
