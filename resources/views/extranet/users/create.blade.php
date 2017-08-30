@extends('layouts.master')

@section('title', 'Extranet - Usuarios')

@section('page_title', 'Nuevo Usuario Extranet')

@if (can_not_do('extranet_users'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('extranet.users.store') }}" id="form">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('business') ? ' has-error':'' }}">
                                    <label class="control-label">Empresa</label>
                                    <select class="form-control input-sm" name="business">
                                        @foreach ($business as $busi)
                                            <option value="{{ $busi->id }}">{{ $busi->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('business') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('full_name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre Completo</label>
                                    <input type="text" class="form-control input-sm" name="full_name" value="{{ old('full_name') }}">
                                    <span class="help-block">{{ $errors->first('full_name') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                    <label class="control-label">Identificación</label>
                                    <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
                                    <span class="help-block">{{ $errors->first('identification') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('position') ? ' has-error':'' }}">
                                    <label class="control-label">Cargo que Ocupa</label>
                                    <input type="text" class="form-control input-sm" name="position" value="{{ old('position') }}">
                                    <span class="help-block">{{ $errors->first('position') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('username') ? ' has-error':'' }}">
                                    <label class="control-label">Usuario</label>
                                    <input type="text" class="form-control input-sm" name="username" value="{{ old('username') }}">
                                    <span class="help-block">{{ $errors->first('username') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('password') ? ' has-error':'' }}">
                                    <label class="control-label">Contraseña</label>
                                    <input type="password" class="form-control input-sm" name="password" value="">
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('password_confirmation') ? ' has-error':'' }}">
                                    <label class="control-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control input-sm" name="password_confirmation" value="">
                                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('extranet.users.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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
