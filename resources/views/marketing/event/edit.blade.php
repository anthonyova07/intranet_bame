@extends('layouts.master')

@section('title', 'Mercadeo - Eventos')

@section('page_title', 'Editar Evento')

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
                    <form method="post" action="{{ route('marketing.event.update', ['id' => $event->id]) }}" id="form" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control input-sm" name="title" value="{{ $event->title }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('detail') ? ' has-error':'' }}">
                                    <label class="control-label">Detalle</label>
                                    <textarea class="form-control input-sm" name="detail" rows="10">{{ $event->detail }}</textarea>
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
                                    <input type="datetime-local" class="form-control input-sm" name="start_event" value="{{ $event->start_event->format('Y-m-d\TH:i') }}">
                                    <span class="help-block">{{ $errors->first('start_event') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('end_subscriptions') ? ' has-error':'' }}">
                                    <label class="control-label">Fin de Suscripciones</label>
                                    <input type="date" class="form-control input-sm" name="end_subscriptions" value="{{ $event->end_subscriptions->format('Y-m-d') }}">
                                    <span class="help-block">{{ $errors->first('end_subscriptions') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $event->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="limit_persons" {{ $event->limit_persons ? 'checked' : '' }}> Limita Personas
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('number_persons') ? ' has-error':'' }}">
                                    <label class="control-label">Total Personas</label>
                                    <input type="number" min="1" class="form-control input-sm" name="number_persons" value="{{ $event->number_persons }}">
                                    <span class="help-block">{{ $errors->first('number_persons') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="limit_accompanists" {{ $event->limit_accompanists ? 'checked' : '' }}> Limita Acompañantes
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('number_accompanists') ? ' has-error':'' }}">
                                    <label class="control-label" title="Total Acompañantes P/P" data-toggle="tooltip">Tot. Acom. P/P</label>
                                    <input type="number" min="0" class="form-control input-sm" name="number_accompanists" value="{{ $event->number_accompanists }}">
                                    <span class="help-block">{{ $errors->first('number_accompanists') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
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
