@extends('layouts.master')

@section('title', 'Inicio de Sesión')

@section('contents')

    @if (!session()->has('usuario'))
        @section('page_title', 'Inicio de Sesión')

        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{ route('auth.login') }}" id="form_login">
                            <div class="form-group{{ $errors->first('usuario') ? ' has-error':'' }}">
                                <label class="control-label" for="usuario">Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="usuario" value="{{ old('usuario') }}">
                                <span class="help-block">{{ $errors->first('usuario') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('clave') ? ' has-error':'' }}">
                                <label class="control-label" for="clave">Contraseña</label>
                                <input type="password" class="form-control" name="clave" placeholder="*********" value="">
                                <span class="help-block">{{ $errors->first('clave') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Iniciando sesión...">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else

        @section('page_title', 'Usted ya se encuentra logueado como: <b>' . session()->get('usuario') . '</b>')

    @endif

<script type="text/javascript">
    $('#form_login').submit(function (event) {
        $('#btn_submit').button('loading');
    });
</script>

@endsection
