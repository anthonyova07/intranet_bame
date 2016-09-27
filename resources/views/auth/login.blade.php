@extends('layouts.master')

@section('title', 'Inicio de Sesión')

@section('contents')

    @if (!session()->has('user'))
        @section('page_title', 'Inicio de Sesión')

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{ route('auth.login') }}" id="form">
                            <div class="form-group{{ $errors->first('user') ? ' has-error':'' }}">
                                <label class="control-label">Usuario</label>
                                <input type="text" class="form-control input-sm" name="user" placeholder="usuario" value="{{ old('user') }}" autofocus>
                                <span class="help-block">{{ $errors->first('user') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('password') ? ' has-error':'' }}">
                                <label class="control-label">Contraseña</label>
                                <input type="password" class="form-control input-sm" name="password" placeholder="*********" value="">
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Iniciando sesión...">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else

        @section('page_title', 'Usted ya se encuentra logueado como: <b>' . session()->get('user') . '</b>')

    @endif

<script type="text/javascript">
    $('#form').submit(function (event) {
        $('#btn_submit').button('loading');
    });
</script>

@endsection
