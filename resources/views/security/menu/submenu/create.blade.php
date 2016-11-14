@extends('layouts.master')

@section('title', 'Seguridad -> SubMenús')

@section('page_title', 'Crear SubMenú')

@if (can_not_do('security_menu'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('security.menu.{menu}.submenu.store', ['menu' => request()->menu]) }}" id="form">
                        <div class="form-group{{ $errors->first('menu') ? ' has-error':'' }}">
                            <label class="control-label">Menús</label>
                            <select class="form-control input-sm" name="menu" id="menu">
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->men_codigo }}" {{ request()->menu == $menu->men_codigo ? 'selected="selected"':'' }}>{{ $menu->men_descri }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">{{ $errors->first('menu') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('coduni') ? ' has-error':'' }}">
                            <label class="control-label">Código Único</label>
                            <input type="text" class="form-control input-sm" name="coduni" placeholder="código_unico" value="{{ old('coduni') }}">
                            <span class="help-block">{{ $errors->first('coduni') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control input-sm" name="description" placeholder="descripción" value="{{ old('description') }}">
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('caption') ? ' has-error':'' }}">
                            <label class="control-label">Título</label>
                            <input type="text" class="form-control input-sm" name="caption" placeholder="título" value="{{ old('caption') }}">
                            <span class="help-block">{{ $errors->first('caption') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('link') ? ' has-error':'' }}">
                            <label class="control-label">Link</label>
                            <input type="text" class="form-control input-sm" name="link" placeholder="ruta.otro" value="{{ old('link') }}">
                            <span class="help-block">{{ $errors->first('link') }}</span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="status"> Activo
                            </label>
                            ||
                            <label>
                                <input type="checkbox" name="web"> WEB
                            </label>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('security.menu.{menu}.submenu.index', ['menu' => request()->menu]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Creando menú...">Crear</button>
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
