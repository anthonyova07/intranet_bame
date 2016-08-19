@extends('layouts.master')

@section('title', 'Seguridad -> Accesos')

@section('page_title', 'Accesos de Usuarios')

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    <form method="post" action="{{ route('seguridad::accesos') }}" id="form_accesos">
                        <div class="form-group{{ $errors->first('usuario') ? ' has-error':'' }}">
                            <label class="control-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="usuario" value="{{ old('usuario') }}">
                            <span class="help-block">{{ $errors->first('usuario') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('menu') ? ' has-error':'' }}">
                            <label class="control-label">Menú</label>
                            <select class="form-control" name="menu" id="menu">
                                <option value="">Selecciona un menú</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->CODIGO }}" {{ old('menu') == $menu->CODIGO ? 'selected="selected"':'' }}>{{ $menu->DESCRIPCION }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('menu') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('submenu') ? ' has-error':'' }}">
                            <label class="control-label">SubMenú</label>
                            <select class="form-control" name="submenu">
                                <option value="0">Selecciona un submenú</option>
                                @if (session()->has('submenus'))
                                    @foreach (session()->get('submenus') as $submenu)
                                        <option value="{{ $submenu->CODIGO }}">{{ $submenu->DESCRIPCION }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block">{{ $errors->first('submenu') }}</span>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="accion" value="i"> Deshabilitar
                            </label>
                            ||
                            <label>
                                <input type="radio" name="accion" value="a" checked="checked"> Agregar
                            </label>
                            ||
                            <label>
                                <input type="radio" name="accion" value="e"> Eliminar
                            </label>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Procesando solicitud...">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_accesos').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('#menu').change(function () {
            $('#form_accesos').submit();
        });
    </script>

@endsection
