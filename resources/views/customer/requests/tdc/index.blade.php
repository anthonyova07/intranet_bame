@extends('layouts.master')

@section('title', 'Procesos -> Solicitudes')

@section('page_title', 'Gestión de Campañas')

@if (can_not_do('customer_requests_tdc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        @if (!can_not_do('customer_requests_tdc_admin'))

            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Búscar Solicitud</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.request.tdc.index') }}" id="form">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                        <label class="control-label">Término</label>
                                        <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                        <span class="help-block">{{ $errors->first('term') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('channel') ? ' has-error':'' }}">
                                        <label class="control-label">Canal</label>
                                        <select name="channel" class="form-control input-sm">
                                            <option value="">Seleccione un canal</option>
                                            @foreach (get_channels() as $key => $channel)
                                                <option value="{{ $key }}">{{ $channel }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('channel') }}</span>
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
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando vacantos...">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endif

    </div>

    <div class="row">

        @if (can_not_do('customer_requests_tdc_admin'))
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs btn-block" style="padding: 24px;font-size: 40px;" href="{{ route('customer.request.tdc.create') }}">Nueva Solicitud</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-xs-12">

            @if (!can_not_do('customer_requests_tdc_admin'))

                <div class="panel panel-default">
                    <div class="panel-body">

                        <a class="btn btn-danger btn-xs" href="{{ route('customer.request.tdc.create') }}">Nueva Solicitud</a>

                        <a style="font-size: 13px;margin-left: 10px;" class="label btn-primary pull-right" id="print_requests" target="__blank" href="" url="{{ route('customer.request.tdc.print') }}">Imprimir</a>

                        <a style="font-size: 13px;" download class="label btn-success pull-right" target="__blank" href="{{ route('customer.request.tdc.excel', Request::except(['term', 'page'])) }}">Exportar Excel</a>

                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                            <thead>
                                <tr>
                                    <th># Solicitud</th>
                                    <th>Nombre</th>
                                    <th>Producto</th>
                                    <th>Canal</th>
                                    <th style="width: 112px;">Fecha Creación</th>
                                    <th style="width: 112px;">Creado por</th>
                                    <th class="text-center" style="width: 75px">
                                        <input type="checkbox" data-toggle="tooltip" title="Seleccionar Todo" name="check_all" value="" id="check_all">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests_tdc as $request_tdc)
                                    <tr>
                                        <td>{{ $request_tdc->reqnumber }}</td>
                                        <td>{{ $request_tdc->names }}</td>
                                        <td>{{ $request_tdc->producttyp }}</td>
                                        <td>{{ get_channels($request_tdc->channel) }}</td>
                                        <td>{{ $request_tdc->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $request_tdc->createname }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.request.tdc.show', array_merge(['tdc' => $request_tdc->id], Request::all())) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ver Solicitud">
                                                <i class="fa fa-share fa-fw"></i>
                                            </a>
                                            <input type="checkbox" class="check_print" data-toggle="tooltip" title="Marcar para Imprimir" name="requests[]" value="{{ $request_tdc->id }}">
                                            {{-- <a
                                                style="font-size: 13px;margin: 3px;"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                class="label btn-warning"
                                                title="Ver Solicitud"
                                                target="__blank"
                                                href="{{ route('customer.request.tdc.print', $request_tdc->id) }}"><i class="fa fa-print fa-fw"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $requests_tdc->links() }}

                    </div>
                </div>
            @endif
        </div>

    </div>

    @if (!can_not_do('customer_requests_tdc_admin'))
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Razones de Negación</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.request.tdc.{type}.param.create', ['type' => 'DEN']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th style="width: 60px;">Lista Negra</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($params->where('type', 'DEN') as $denail)
                                    <tr>
                                        <td>{{ $denail->note }}</td>
                                        <td>{{ $denail->isblack ? 'Si' : 'No' }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.request.tdc.{type}.param.edit', ['type' => 'DEN', 'param' => $denail->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Carga de Archivos</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{ route('customer.request.tdc.load') }}" id="form" enctype="multipart/form-data" novalidate>
                            <div class="col-xs-12" style="padding-left: 0px;padding-right: 0px;">
                                <div class="form-group">
                                    <label class="control-label">
                                        Cargar Archivo de Canal
                                        <small style="font-size: 11px;" class="label label-warning">MAX 10MB</small>
                                    </label>
                                    <input type="file" name="file">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Cargar al Canal</label>
                                    <select class="form-control input-sm" name="channel">
                                        <option value="">Seleccionar un canal</option>
                                        @foreach (get_channels() as $key => $channel)
                                            <option value="{{ $key }}">{{ $channel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group" id="business_selector">
                                    <label class="control-label">Call Centers Externos</label>
                                    <select class="form-control input-sm" disabled name="business">
                                        <option value="">Seleccionar un Call Center</option>
                                        @foreach ($businesses as $business)
                                            <option value="{{ $business->id }}">{{ $business->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    @endif

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });

        $('#print_requests').click(function (e) {
            var ids = '?id=';
            var count = 0;

            $('.check_print').each(function (index, check) {
                if ($(check).is(':checked')) {
                    ids += $(check).val() + ',';
                    count++;
                }
            });

            if (!count) {
                alert('No ha seleccionado ninguna solicitud para imprimir.');
                return false;
            }

            $(this).attr('href', $(this).attr('url') + ids);
        });

        var check_all = $('#check_all');

        check_all.change(function () {
            $('.check_print').each(function (index, check) {
                $(check).prop('checked', check_all.is(':checked'));
            });
        });

        var channel = $('select[name=channel]');
        var business = $('select[name=business]');

        channel.change(function () {
            if ($(this).val() == 'CCE') {
                business.prop('disabled', false);
            } else {
                business.prop('disabled', true);
            }
        });
    </script>

@endsection
