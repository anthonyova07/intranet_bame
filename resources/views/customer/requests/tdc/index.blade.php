@extends('layouts.master')

@section('title', 'Procesos -> Solicitudes')

@section('page_title', 'Solicitudes de Tarjetas')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Solicitud</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('customer.request.tdc.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
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

    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('customer.request.tdc.create') }}">Nueva Solicitud</a>

                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th># Solicitud</th>
                                <th>Nombre</th>
                                <th>Producto</th>
                                <th>Estatus</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 75px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests_tdc as $request_tdc)
                                <tr>
                                    <td>{{ $request_tdc->reqnumber }}</td>
                                    <td>{{ $request_tdc->names }}</td>
                                    <td>{{ $request_tdc->producttyp }}</td>
                                    <td>{{ $request_tdc->reqstatus }}</td>
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
                                        <a
                                            style="font-size: 13px;margin: 3px;"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            class="label btn-warning"
                                            title="Ver Solicitud"
                                            target="__blank"
                                            href="{{ route('customer.request.tdc.print', $request_tdc->id) }}"><i class="fa fa-print fa-fw"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $requests_tdc->links() }}
                </div>
            </div>
        </div>

    </div>

    {{-- @if (!can_not_do('customer_claim_param')) --}}
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

        </div>

    {{-- @endif --}}

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
