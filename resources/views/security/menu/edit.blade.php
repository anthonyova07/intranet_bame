@extends('layouts.master')

@section('title', 'Seguridad -> Menús')

@section('page_title', 'Crear Menú')

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
                    <form method="post" action="{{ route('security.menu.update', ['codigo' => $menu->men_codigo]) }}" id="form">
                        <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                            <label class="control-label">Descripción</label>
                            <input type="text" class="form-control input-sm" name="description" placeholder="descripción" value="{{ $menu->men_descri }}">
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="status" {{ $menu->men_estatu == 'A' ? 'checked="checked"':'' }}> Activo
                            </label>
                            ||
                            <label>
                                <input type="checkbox" name="web" {{ $menu->men_web == 'S' ? 'checked="checked"':'' }}> WEB
                            </label>
                        </div>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <a class="btn btn-info btn-xs" href="{{ route('security.menu.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Editando menú...">Editar</button>
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
