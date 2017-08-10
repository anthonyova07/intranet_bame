<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" action="{{ route($department . '.event.update', ['id' => $event->id]) }}" id="form" enctype="multipart/form-data" novalidate>
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
                                <textarea class="form-control input-sm textarea" name="detail" rows="10">{{ str_replace('<br />', '', $event->detail) }}</textarea>
                                <span class="help-block">{{ $errors->first('detail') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-10">
                            <div class="form-group{{ $errors->first('image') ? ' has-error':'' }}">
                                <label class="control-label">Imagen <small class="label label-warning">MAX 2 MB</small></label>
                                <input type="file" name="image">
                                <span class="help-block">{{ $errors->first('image') }}</span>
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
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('start_event') ? ' has-error':'' }}">
                                <label class="control-label">Fecha Inicio(Evento)</label>
                                <input type="datetime-local" class="form-control input-sm" name="start_event" value="{{ $event->start_event->format('Y-m-d\TH:i') }}">
                                <span class="help-block">{{ $errors->first('start_event') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('end_event') ? ' has-error':'' }}">
                                <label class="control-label">Fecha Final(Evento)</label>
                                <input type="datetime-local" class="form-control input-sm" name="end_event" value="{{ $event->end_event->format('Y-m-d\TH:i') }}">
                                <span class="help-block">{{ $errors->first('end_event') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('end_subscriptions') ? ' has-error':'' }}">
                                <label class="control-label">Fecha Limite Suscripciones</label>
                                <input type="datetime-local" class="form-control input-sm" name="end_subscriptions" value="{{ $event->end_subscriptions->format('Y-m-d\TH:i') }}">
                                <span class="help-block">{{ $errors->first('end_subscriptions') }}</span>
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
                                    <input type="checkbox" name="limit_accompanists" {{ $event->limit_accompanists ? 'checked' : '' }}> Limita Invitados
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('number_accompanists') ? ' has-error':'' }}">
                                <label class="control-label" title="Total Invitados P/P" data-toggle="tooltip">MAX Acom. P/P</label>
                                <input type="number" min="0" class="form-control input-sm" name="number_accompanists" value="{{ $event->number_accompanists }}">
                                <span class="help-block">{{ $errors->first('number_accompanists') }}</span>
                            </div>
                        </div>
                    </div>
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <a class="btn btn-info btn-xs" href="{{ route($department . '.event.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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
