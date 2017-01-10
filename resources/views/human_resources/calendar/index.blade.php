@extends('layouts.master')

@section('title', 'Recursos Humanos -> Calendario')

@section('page_title', 'Mantenimiento de Calendario ')

@if (can_not_do('human_resources_calendar'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Fechas</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.calendar.date.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='1|desc'>
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Nombre</th>
                                <th style="width: 85px">Fecha Inicio</th>
                                <th style="width: 85px">Fecha Final</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dates as $date)
                                <tr>
                                    <td>{{ $date->group->name }}</td>
                                    <td>{{ $date->title }}</td>
                                    <td>{{ $date->startdate->format('Y-m-d') }}</td>
                                    <td>{{ $date->enddate->format('Y-m-d') }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.calendar.date.edit', ['id' => $date->id]) }}"
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
                    <h3 class="panel-title">Grupos</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('human_resources.calendar.group.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('human_resources.calendar.group.edit', ['id' => $group->id]) }}"
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
                    <h3 class="panel-title">Carga de Cumpleaños de Empleados</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.calendar.birthdate.store') }}" id="form" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('birthdate_file') ? ' has-error':'' }}">
                                    <label class="control-label">Cargar Archivo de Empleados<small style="font-size: 11px;" class="label label-warning">MAX 10MB</small></label>
                                    <input type="file" name="birthdate_file">
                                    <span class="help-block">{{ $errors->first('birthdate_file') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                    </form>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre y Apellido</th>
                                <th>Fecha M-D</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($birthdates as $birthdate)
                                <tr>
                                    <td>{{ $birthdate->code }}</td>
                                    <td>{{ $birthdate->full_name }}</td>
                                    <td>{{ $birthdate->month_day }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function () {
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
