@extends('layouts.master')

@section('title', 'Procesos -> Solicitudes')

@section('page_title', 'Solicitudes de Procesos')

@if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Solicitud</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('process.request.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('request_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Solicitud</label>
                                    <select class="form-control input-sm" name="request_type">
                                        <option value="">Todos</option>
                                        @foreach ($request_types as $request_type)
                                            <option value="{{ $request_type->note }}" {{ old('request_type') == $request_type->note ? 'selected':'' }}>{{ $request_type->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('request_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('process') ? ' has-error':'' }}">
                                    <label class="control-label">Proceso Impactado</label>
                                    <select class="form-control input-sm" name="process">
                                        <option value="">Todos</option>
                                        @foreach ($request_processes->where('id_parent', '') as $request_process)
                                            <option value="{{ $request_process->name . ' v( ' . $request_process->version . ' )' }}" {{ old('process') == $request_process->name ? 'selected':'' }}>{{ $request_process->name . ' v( ' . $request_process->version . ' )' }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('process') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('status') ? ' has-error':'' }}">
                                    <label class="control-label">Estatus</label>
                                    <select class="form-control input-sm" name="status">
                                        <option value="todos">Todos</option>
                                        @foreach ($request_statuses as $status)
                                            <option value="{{ $status->note }}" {{ old('status') == $status->note ? 'selected':'' }}>{{ $status->note }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
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
                    <a class="btn btn-danger btn-xs" href="{{ route('process.request.create') }}">Nueva Solicitud</a>

                    @if (!can_not_do('process_request_admin'))
                        <a style="font-size: 13px;" class="label btn-danger pull-right" target="__blank" href="{{ route('process.request.export.status_count_pdf', Request::except(['term', 'page'])) }}">Exportar PDF</a>
                    @endif
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th># Solicitud</th>
                                <th>Tipo Solicitud</th>
                                <th>Proceso</th>
                                <th>Estatus</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($process_requests as $process_request)
                                <tr>
                                    <td>{{ $process_request->reqnumber }}</td>
                                    <td>{{ $process_request->reqtype }}</td>
                                    <td>{{ $process_request->process }}</td>
                                    <td>{{ $process_request->reqstatus }}</td>
                                    <td>{{ $process_request->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $process_request->createname }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('process.request.show', array_merge(['request' => $process_request->id], Request::all())) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Solicitud">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $process_requests->links() }}
                </div>
            </div>
        </div>

    </div>


    @if (!can_not_do('process_request_admin'))
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Solicitudes</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('process.request.{type}.param.create', ['type' => 'TIPSOL']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_types as $request_type)
                                    <tr>
                                        <td>{{ $request_type->code }}</td>
                                        <td>{{ $request_type->note }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('process.request.{type}.param.edit', ['type' => 'TIPSOL', 'param' => $request_type->id]) }}"
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
                        <h3 class="panel-title">Estatus</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('process.request.{type}.param.create', ['type' => 'EST']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_statuses as $request_status)
                                    <tr>
                                        <td>{{ $request_status->code }}</td>
                                        <td>{{ $request_status->note }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('process.request.{type}.param.edit', ['type' => 'EST', 'param' => $request_status->id]) }}"
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

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Procesos</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('process.request.{type}.param.create', ['type' => 'PRO']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th style="width: 36px;">Versión</th>
                                    <th>Nombre</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_processes as $request_process)
                                    <tr>
                                        <td>{{ $request_process->code }}</td>
                                        <td>{{ $request_process->version }}</td>
                                        <td>{{ $request_process->name }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('process.request.{type}.param.edit', ['type' => 'PRO', 'param' => $request_process->id]) }}"
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

    @endif

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este vacanto?');

            if (!res) {
                vacant.prvacantDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
