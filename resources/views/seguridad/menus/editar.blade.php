@extends('layouts.master')

@section('title', 'Seguridad -> Menús')

@section('page_title', 'Crear Menú')

@if (can_not_do('seguridad_menus'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('seguridad::menus::editar', ['codigo' => $menu->CODIGO]) }}" id="form_menus">
                        <div class="form-group{{ $errors->first('descripcion') ? ' has-error':'' }}">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" placeholder="descripción" value="{{ $menu->DESCRIPCION }}">
                            <span class="help-block">{{ $errors->first('descripcion') }}</span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="estatus" {{ $menu->ESTATU == 'A' ? 'checked="checked"':'' }}> Activo
                            </label>
                            ||
                            <label>
                                <input type="checkbox" name="web" {{ $menu->WEB == 'S' ? 'checked="checked"':'' }}> WEB
                            </label>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-default" href="{{ route('seguridad::menus::lista') }}">Cancelar</a>
                        <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Editando menú...">Editar</button>
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
