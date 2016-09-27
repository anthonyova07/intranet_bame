@extends('layouts.master')

@section('title', 'Seguridad -> Accesos')

@section('page_title', 'Accesos de Usuarios')

@if (can_not_do('security_access'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('security.access.store') }}" id="form">
                        <div class="form-group{{ $errors->first('user') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <input type="text" class="form-control input-sm" name="user" placeholder="usuario" value="{{ old('user') }}">
                            <span class="help-block">{{ $errors->first('user') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('menu') ? ' has-error':'' }}">
                            <label class="control-label">Menú</label>
                            <select class="form-control input-sm" name="menu" id="menu">
                                <option value="">Selecciona un menú</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->men_codigo }}" {{ old('menu') == $menu->men_codigo ? 'selected="selected"':'' }}>{{ $menu->men_descri }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('menu') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('submenu') ? ' has-error':'' }}">
                            <label class="control-label">SubMenú</label>
                            <select class="form-control input-sm" name="submenu" id="submenu">
                                <option value="0">Selecciona un submenú</option>
                                @if (session()->has('submenus'))
                                    @foreach (session()->get('submenus') as $submenu)
                                        <option value="{{ $submenu->sub_codigo }}">{{ $submenu->sub_descri }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('submenu') }}</span>
                        </div>
                        <div class="radio" style="text-align: center;font-size: 16px;">
                            <label>
                                <input type="radio" name="action" value="i"> <span class="label label-warning">Deshabilitar</span>
                            </label>
                            ||
                            <label>
                                <input type="radio" name="action" value="a" checked="checked"> <span class="label label-success">Agregar</span>
                            </label>
                            ||
                            <label>
                                <input type="radio" name="action" value="e"> <span class="label label-danger">Eliminar</span>
                            </label>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Procesando solicitud...">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('#menu').change(function () {
            $('#submenu').val(0);
            $('#form').submit();
        });
    </script>

@endsection
