@extends('layouts.master')

@section('title', 'Mercadeo - Eventos')

@section('page_title', 'Motivo de la Cancelación de Suscripción del Evento')

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="{{ $user ? route('event.unsubscribe', ['id' => $event_id, 'user' => $user]) : route('event.subscribe', ['id' => $event_id]) }}" id="form" novalidate>
                        <input type="hidden" name="department" value="{{ Request::get('department') }}">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('unsubscription_reason') ? ' has-error':'' }}">
                                    <label class="control-label">Motivo</label>
                                    <input type="text" class="form-control input-sm" name="unsubscription_reason" maxlength="150" value="{{ old('unsubscription_reason') }}">
                                    <span class="help-block">{{ $errors->first('unsubscription_reason') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
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
