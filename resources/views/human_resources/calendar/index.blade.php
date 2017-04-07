@extends('layouts.master')

@section('title', 'Recursos Humanos -> Calendario')

@section('page_title', 'Mantenimiento de Calendario ')

@if (can_not_do('human_resources_calendar'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @if (!can_not_do('human_resources_calendar_admin'))
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Carga de Fechas</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-7" style="padding: 0px;">
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
                                                <a
                                                    href="{{ route('human_resources.calendar.date.delete', ['id' => $date->id]) }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Eliminar"
                                                    class="rojo">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-5">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-xs-12 text-center" style="margin-top: -14px;">
                                        <h5>Mantenimiento Individual de Fechas</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="btn btn-danger btn-xs" href="{{ route('human_resources.calendar.date.create') }}">Nuevo</a>
                                    </div>
                                </div>
                            </div>
                            <form method="post" action="{{ route('human_resources.calendar.date.loadfile') }}" id="form" enctype="multipart/form-data" novalidate>
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-xs-12 text-center" style="margin-top: -14px;">
                                            <h5>Carga Masiva de Fechas</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group{{ $errors->first('group_id') ? ' has-error':'' }}">
                                                <label class="control-label">Cargar al Grupo</label>
                                                <select class="form-control input-sm" name="group_id">
                                                    @foreach ($groups as $group)
                                                        @if ($group->name != 'Cumpleaños' && $group->name != 'Días de Pago')
                                                            <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected':'' }}>{{ $group->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="help-block">{{ $errors->first('group_id') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group{{ $errors->first('date_file') ? ' has-error':'' }}">
                                                <label class="control-label">Cargar Archivo de Fechas<small style="font-size: 11px;" class="label label-warning">MAX 10MB</small></label>
                                                <input type="file" name="date_file">
                                                <span class="help-block">{{ $errors->first('date_file') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Carga de Cumpleaños de Empleados</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-7" style="padding: 0px;">
                            <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Código</th>
                                        <th>Nombre y Apellido</th>
                                        <th>Cumple. M-D</th>
                                        <th>Ingreso</th>
                                        <th>Años Servi.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($birthdates as $birthdate)
                                        <tr>
                                            <td>
                                                @if (file_exists(public_path('\files\employee_images\\') . get_employee_name_photo($birthdate->code, $birthdate->gender, true)))
                                                    <i class="fa fa-image fa-fw"></i>
                                                @endif
                                            </td>
                                            <td>{{ $birthdate->code }}</td>
                                            <td>{{ $birthdate->full_name }}</td>
                                            <td>{{ $birthdate->month_day }}</td>
                                            <td>{{ isset($birthdate->services_date) ? $birthdate->services_date : '' }}</td>
                                            <td>{{ calculate_year_of_service(isset($birthdate->services_date) ? $birthdate->services_date : null) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-5">
                            <form method="post" action="{{ route('human_resources.calendar.birthdate.store') }}" id="form_masive" enctype="multipart/form-data" novalidate>
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group{{ $errors->first('birthdate_file') ? ' has-error':'' }}">
                                                <label class="control-label">Cargar Masiva Empleados CSV<small style="font-size: 11px;" class="label label-warning">MAX 10MB</small></label>
                                                <input type="file" name="birthdate_file">
                                                <span class="help-block">{{ $errors->first('birthdate_file') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form method="post" action="{{ route('human_resources.calendar.birthdate.store') }}" id="form_single" enctype="multipart/form-data" novalidate>
                                <div class="well well-sm">
                                    <div class="row">
                                        <div class="col-xs-12 text-center" style="margin-top: -14px;">
                                            <h5>Mantenimiento Individual de Empleado</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('code') ? ' has-error':'' }}">
                                                <label class="control-label">Código</label>
                                                <input type="text" class="form-control input-sm" name="code" value="{{ old('code') }}">
                                                {{-- <span class="help-block">{{ $errors->first('code') }}</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('gender') ? ' has-error':'' }}">
                                                <label class="control-label">Género</label>
                                                <br>
                                                <label>
                                                    <input type="radio" checked name="gender" value="Masculino"> M
                                                </label>
                                                <label>
                                                    <input type="radio" name="gender" value="Femenino"> F
                                                </label>

                                                {{-- <span class="help-block">{{ $errors->first('gender') }}</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group{{ $errors->first('full_name') ? ' has-error':'' }}">
                                                <label class="control-label">Nombre Completo</label>
                                                <input type="text" class="form-control input-sm" name="full_name" value="{{ old('full_name') }}">
                                                {{-- <span class="help-block">{{ $errors->first('full_name') }}</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group{{ $errors->first('birthdate') ? ' has-error':'' }}">
                                                <label class="control-label">Cumpleaño</label>
                                                <input type="date" class="form-control input-sm" name="birthdate" value="{{ old('birthdate') }}">
                                                {{-- <span class="help-block">{{ $errors->first('birthdate') }}</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group{{ $errors->first('initial_date') ? ' has-error':'' }}">
                                                <label class="control-label">Ingreso</label>
                                                <input type="date" class="form-control input-sm" name="initial_date" value="{{ old('initial_date') }}">
                                                {{-- <span class="help-block">{{ $errors->first('initial_date') }}</span> --}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Eliminando...">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @if (!can_not_do('human_resources_calendar_admin'))
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
        @endif

        @if (!can_not_do('human_resources_calendar_images'))
            <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Carga Imagenes de Empleados</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.calendar.birthdate.store') }}" id="form_masive_images" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('employee_images_file') ? ' has-error':'' }}">
                                    <input type="file" name="employee_images_file[]" multiple>
                                    <span class="help-block">{{ $errors->first('employee_images_file') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando...">Cargar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
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
