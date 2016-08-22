@extends('layouts.master')

@section('title', 'Seguridad -> SubMenús')

@section('page_title', 'Crear SubMenú')

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    <form method="post" action="{{ route('seguridad::menus::submenus::nuevo', ['menu' => request()->menu]) }}" id="form_menus">
                        <div class="form-group{{ $errors->first('menu') ? ' has-error':'' }}">
                            <label class="control-label">Menús</label>
                            <select class="form-control" name="menu" id="menu">
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->CODIGO }}" {{ request()->menu == $menu->CODIGO ? 'selected="selected"':'' }}>{{ $menu->DESCRIPCION }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('menu') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('coduni') ? ' has-error':'' }}">
                            <label class="control-label">Código Único</label>
                            <input type="text" class="form-control" name="coduni" placeholder="código_unico" value="{{ old('coduni') }}">
                            <span class="help-block">{{ $errors->first('coduni') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('descripcion') ? ' has-error':'' }}">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" placeholder="descripción" value="{{ old('descripcion') }}">
                            <span class="help-block">{{ $errors->first('descripcion') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('caption') ? ' has-error':'' }}">
                            <label class="control-label">Título</label>
                            <input type="text" class="form-control" name="caption" placeholder="título" value="{{ old('caption') }}">
                            <span class="help-block">{{ $errors->first('caption') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('link') ? ' has-error':'' }}">
                            <label class="control-label">Link</label>
                            <input type="text" class="form-control" name="link" placeholder="ruta::otro" value="{{ old('link') }}">
                            <span class="help-block">{{ $errors->first('link') }}</span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="estatus"> Activo
                            </label>
                            ||
                            <label>
                                <input type="checkbox" name="web"> WEB
                            </label>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-default" href="{{ route('seguridad::menus::submenus::lista', ['menu' => request()->menu]) }}">Cancelar</a>
                        <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Creando menú...">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_menus').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
