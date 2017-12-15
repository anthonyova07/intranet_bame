@extends('layouts.master')

@section('title', 'Inicio de Sesión')

@section('contents')

    @if (!session()->has('user') || !request()->cookie('temp_auth') && !str_contains(url()->current(), 'auth/login'))
        @section('page_title', 'Autenticación con el Usuario del Equipo')

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de Autenticación</h3>
                    </div>
                    <div class="panel-body text-center">

                        {{-- <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info">
                                    Sus credenciales son las del computador.
                                </div>
                            </div>
                        </div> --}}

                        <form method="post" action="{{ route('auth.login') }}" id="form" style="margin-top: 7px;">
                            <div class="form-group{{ $errors->first('user') ? ' has-error':'' }}">
                                {{-- <label class="control-label" style="font-size: 16px;">Usuario</label> --}}
                                <div class="input-group" data-toggle="tooltip" title="Usuario del Equipo">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-sm" name="user" placeholder="usuario" value="{{ old('user') }}" autofocus>
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                                <span class="help-block"><b>{{ $errors->first('user') }}</b></span>
                            </div>
                            <div class="form-group{{ $errors->first('password') ? ' has-error':'' }}">
                                {{-- <label class="control-label" style="font-size: 16px;">Contraseña</label> --}}
                                <div class="input-group" data-toggle="tooltip" title="Contraseña del Equipo">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control input-sm" name="password" placeholder="*********" value="">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                </div>
                                <span class="help-block"><b>{{ $errors->first('password') }}</b></span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" style="font-size: 16px;padding: 2px 10px;" class="btn btn-danger btn-xs btn-block" id="btn_submit" data-loading-text="Iniciando sesión...">Iniciar Sesión</button>
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
