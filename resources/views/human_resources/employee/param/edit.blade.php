@extends('layouts.master')

@section('title', 'Recursos Humanos - Empleados - Parametros')

@section('page_title', 'Editar ' . get_employee_params($type))

{{-- @if (can_not_do('marketing_news'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('human_resources.employee.{type}.param.update', ['type' => $type, 'param' => $param->id]) }}" id="form" enctype="multipart/form-data">
                        <div class="row">
                            @if ($type == 'POS')
                                <div class="col-xs-6">
                                    <label class="control-label">Departamento</label>
                                    <select name="department" class="form-control input-sm">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"{{ $param->dep_id == $department->id ? ' selected':'' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('department') }}</span>
                                </div>
                            @endif
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ $param->name }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
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

@endsection
