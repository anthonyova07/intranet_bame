@extends('layouts.master')

@section('title', 'Recursos Humanos -> Solicitudes')

@section('page_title', 'Solicitudes de Recursos Humanos')

{{-- @if (can_not_do('human_resource_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Solicitud</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('human_resources.request.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ request('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('reqtype') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Solicitud</label>
                                    <select class="form-control input-sm" name="reqtype">
                                        <option value="todos">Todos</option>
                                        @foreach (rh_req_types() as $key => $value)
                                            <option value="{{ $key }}" {{ request('reqtype') == $key ? 'selected':'' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('reqtype') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('status') ? ' has-error':'' }}">
                                    <label class="control-label">Estatus</label>
                                    <select class="form-control input-sm" name="status">
                                        <option value="todos">Todos</option>
                                        @foreach ($params->where('type', 'EST') as $est)
                                            <option value="{{ $est->name }}" {{ request('status') == $est->name ? 'selected':'' }}>{{ $est->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ request('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ request('date_to') }}">
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
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.request.create') }}">Nueva Solicitud</a>

                    @if (!can_not_do('human_resource_request_admin'))
                        {{-- <a style="font-size: 13px;" class="label btn-danger pull-right" target="__blank" href="{{ route('human_resources.request.export.status_count_pdf', Request::except(['term', 'page'])) }}">Exportar PDF</a> --}}
                    @endif
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th># Solicitud</th>
                                <th>Tipo Solicitud</th>
                                <th>Colaborador</th>
                                <th>Estatus</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($human_resource_requests as $human_resource_request)
                                <tr>
                                    <td>{{ $human_resource_request->reqnumber }}</td>
                                    <td>{{ rh_req_types($human_resource_request->reqtype) }}</td>
                                    <td>{{ '(' . $human_resource_request->colcode . ') ' . $human_resource_request->colname }}</td>
                                    <td>{{ $human_resource_request->reqstatus }}</td>
                                    <td>{{ $human_resource_request->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $human_resource_request->createname }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.request.show', array_merge(['request' => $human_resource_request->id], Request::all())) }}"
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

                    {{ $human_resource_requests->links() }}
                </div>
            </div>
        </div>

    </div>


    @if (!can_not_do('human_resource_request_admin'))
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Permisos y Ausencias Predefinidos</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('human_resources.request.{type}.param.create', ['type' => 'PERAUS']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Nombre</th>
                                    <th style="width: 36px;">Activo</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($params->where('type', 'PERAUS') as $peraus)
                                    <tr>
                                        <td>{{ $peraus->code }}</td>
                                        <td>{{ $peraus->name }}</td>
                                        <td>{{ $peraus->is_active ? 'Si':'No' }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('human_resources.request.{type}.param.edit', ['type' => 'PERAUS', 'param' => $peraus->id]) }}"
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
                        <a class="btn btn-danger btn-xs" href="{{ route('human_resources.request.{type}.param.create', ['type' => 'EST']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Nombre</th>
                                    <th style="width: 36px;">Activo</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($params->where('type', 'EST') as $est)
                                    <tr>
                                        <td>{{ $est->code }}</td>
                                        <td>{{ $est->name }}</td>
                                        <td>{{ $est->is_active ? 'Si':'No' }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('human_resources.request.{type}.param.edit', ['type' => 'EST', 'param' => $est->id]) }}"
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
