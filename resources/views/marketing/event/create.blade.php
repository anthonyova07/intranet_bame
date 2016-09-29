@extends('layouts.master')

@section('title', 'Mercadeo - Eventos')

@section('page_title', 'Nuevo Evento')

@if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('marketing.event.store') }}" id="form" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control input-sm" name="title" value="{{ old('title') }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('detail') ? ' has-error':'' }}">
                                    <label class="control-label">Detalle</label>
                                    <textarea class="form-control input-sm" name="detail" rows="10">{{ old('detail') }}</textarea>
                                    <span class="help-block">{{ $errors->first('detail') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('image') ? ' has-error':'' }}">
                                    <label class="control-label">Imagen <small class="label label-warning">MAX 2 MB</small></label>
                                    <input type="file" name="image">
                                    <span class="help-block">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('start_event') ? ' has-error':'' }}">
                                    <label class="control-label">Inicio del Evento</label>
                                    <input type="datetime-local" class="form-control input-sm" name="start_event" value="">
                                    <span class="help-block">{{ $errors->first('start_event') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('end_subscriptions') ? ' has-error':'' }}">
                                    <label class="control-label">Fin de Suscripciones</label>
                                    <input type="date" class="form-control input-sm" name="end_subscriptions" value="">
                                    <span class="help-block">{{ $errors->first('end_subscriptions') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('number_persons') ? ' has-error':'' }}">
                                    <label class="control-label">Total Personas</label>
                                    <input type="number" class="form-control input-sm" name="number_persons" value="{{ old('number_persons') ? old('number_persons') : 1 }}">
                                    <span class="help-block">{{ $errors->first('number_persons') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('number_companions') ? ' has-error':'' }}">
                                    <label class="control-label" title="Total Acompañantes P/P" data-toggle="tooltip">Tot. Acom. P/P</label>
                                    <input type="number" class="form-control input-sm" name="number_companions" value="{{ old('number_companions') ? old('number_companions') : 0 }}">
                                    <span class="help-block">{{ $errors->first('number_companions') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="limit_persons" {{ old('limit_persons') ? 'checked' : '' }}> Limita Personas
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('marketing.event.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xs-4">
            @include('layouts.partials.edition_help')
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
