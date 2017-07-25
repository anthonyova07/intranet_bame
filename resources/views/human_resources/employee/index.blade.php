@extends('layouts.master')

@section('title', 'Recursos Humanos -> Empleados')

@section('page_title', 'Mantenimiento de Empleados')

{{-- @if (can_not_do('human_resources_employee'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('human_resources.employee.index') }}" id="form">
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
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando noticias...">Buscar</button>
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
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.employee.create') }}">Nueva</a>
                    <div class="pull-right">
                        <form method="post" class="form-inline" action="{{ route('human_resources.employee.load') }}" id="form" enctype="multipart/form-data" novalidate>
                            <div class="form-group{{ $errors->first('date_file') ? ' has-error':'' }}">
                                <label class="control-label">Cargar Masiva</label>
                                <input type="file" name="params">
                                <span class="help-block">{{ $errors->first('date_file') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                        </form>
                    </div>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Correo</th>
                                <th>Posición</th>
                                <th>Supervisor</th>
                                <th>Fecha Nacimiento</th>
                                <th>Fecha Ingreso</th>
                                <th>Género</th>
                                <th>Activo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->recordcard }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->identifica }}</td>
                                    <td>{{ $employee->mail }}</td>
                                    <td>{{ $employee->position->name }}</td>
                                    <td>{{ $employee->supervisor ? $employee->supervisor->name : '' }}</td>
                                    <td>{{ date_create($employee->birthdate)->format('d/m/Y') }}</td>
                                    <td>{{ date_create($employee->servicedat)->format('d/m/Y') }}</td>
                                    <td>{{ get_gender($employee->gender) }}</td>
                                    <td class="text-center">
                                        <span style="font-size: 12px;" class="label label-{{ $employee->is_active ? 'success':'danger' }}">{{ $employee->is_active ? 'Si':'No' }}</span>
                                    </td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.employee.edit', ['id' => $employee->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        {{-- <a
                                            onclick="cancel('{{ $new->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar {{ $new->men_descri }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('human_resources.employee.destroy', ['id' => $new->id]) }}"
                                            method="post" id="form_eliminar_{{ $new->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
        <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
    </div>

    <div class="row">

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Departamentos</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2">
                        <a class="btn btn-danger btn-xs" href="{{ route('human_resources.employee.{type}.param.create', ['type' => 'DEP']) }}">Nuevo</a>
                    </div>
                    <div class="col-xs-10 pull-right text-right">
                        @include('human_resources.employee._loadparams', ['type' => 'DEP'])
                    </div>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th style="width: 2px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($params->where('type', 'DEP') as $param)
                                <tr>
                                    <td>{{ $param->name }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.employee.{type}.param.edit', ['type' => 'DEP', 'param' => $param->id]) }}"
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

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Posiciones</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-2">
                        <a class="btn btn-danger btn-xs" href="{{ route('human_resources.employee.{type}.param.create', ['type' => 'POS']) }}">Nuevo</a>
                    </div>
                    <div class="col-xs-10 pull-right text-right">
                        @include('human_resources.employee._loadparams', ['type' => 'POS'])
                    </div>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th style="width: 2px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($params->where('type', 'POS') as $param)
                                <tr>
                                    <td>{{ $param->name }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.employee.{type}.param.edit', ['type' => 'POS', 'param' => $param->id]) }}"
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

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        // function cancel(id, el)
        // {
        //     res = confirm('Realmente desea eliminar esta noticia?');
        //
        //     if (!res) {
        //         event.preventDefault();
        //         return;
        //     }
        //
        //     $(el).remove();
        //
        //     $('#form_eliminar_' + id).submit();
        // }
    </script>

@endsection
