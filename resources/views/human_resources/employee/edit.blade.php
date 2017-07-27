@extends('layouts.master')

@section('title', 'Mercadeo - Empleados')

@section('page_title', 'Editar Empleado')

@if (can_not_do('human_resources_employee'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.employee.update', ['id' => $employee->id]) }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('recordcard') ? ' has-error':'' }}">
                                    <label class="control-label">Código</label>
                                    <input type="text" class="form-control input-sm" name="recordcard" value="{{ $employee->recordcard }}">
                                    <span class="help-block">{{ $errors->first('recordcard') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                    <label class="control-label">Identificación</label>
                                    <input type="text" class="form-control input-sm" name="identification" value="{{ $employee->identifica }}">
                                    <span class="help-block">{{ $errors->first('identification') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('gender') ? ' has-error':'' }}">
                                    <label class="control-label">Género</label>
                                    <select name="gender" class="form-control input-sm">
                                        <option value="f"{{ $employee->gender == 'f' ? ' selected':'' }}>Femenino</option>
                                        <option value="m"{{ $employee->gender == 'm' ? ' selected':'' }}>Masculino</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('gender') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('mail') ? ' has-error':'' }}">
                                    <label class="control-label">Correo</label>
                                    <input type="text" class="form-control input-sm" name="mail" value="{{ $employee->mail }}">
                                    <span class="help-block">{{ $errors->first('mail') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre Completo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="name" value="{{ $employee->name }}">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="is_active" data-toggle="tooltip" title="Activo"{{ $employee->is_active ? ' checked':'' }}>
                                        </span>
                                    </div>
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('department') ? ' has-error':'' }}">
                                    <label class="control-label">Departamento</label>
                                    <select name="department" class="form-control input-sm">
                                        @foreach ($params->where('type', 'DEP') as $param)
                                            <option value="{{ $param->id }}"{{ $employee->id_dep == $param->id ? ' selected':'' }}>{{ $param->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('department') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('position') ? ' has-error':'' }}">
                                    <label class="control-label">Posición</label>
                                    <select name="position" class="form-control input-sm">
                                        @foreach ($params->where('type', 'POS') as $param)
                                            <option department="{{ $param->dep_id }}" value="{{ $param->id }}"{{ $employee->id_pos == $param->id ? ' selected':'' }}>{{ $param->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('position') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('supervisor') ? ' has-error':'' }}">
                                    <label class="control-label">Supervisor</label>
                                    <select name="supervisor" class="form-control input-sm">
                                        <option value="">Ninguno</option>
                                        @foreach ($employees as $emp)
                                            <option department="{{ $emp->position->dep_id }}" value="{{ $emp->position->id }}"{{ $employee->id_sup == $emp->position->id ? ' selected':'' }}>{{ $emp->position->name . ' - ' . $emp->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('supervisor') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('birthdate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Nacimiento</label>
                                    <input type="date" name="birthdate" class="form-control input-sm" value="{{ $employee->birthdate }}">
                                    <span class="help-block">{{ $errors->first('birthdate') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('servicedat') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha de Ingreso</label>
                                    <input type="date" name="servicedat" class="form-control input-sm" value="{{ $employee->servicedat }}">
                                    <span class="help-block">{{ $errors->first('servicedat') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('human_resources.employee.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

    @include('human_resources.employee._filtro_pos_sup_js')

@endsection
