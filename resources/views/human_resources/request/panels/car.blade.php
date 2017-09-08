<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel')

        @include('human_resources.request.panels.supervisor_panel')
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle de la Solicitud ({{ $type_desc }})</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('car_addressed_to') ? ' has-error':'' }}">
                                <label class="control-label">Dirigido a</label>
                                <input type="text" class="form-control input-sm" name="car_addressed_to" value="{{ old('car_addressed_to') }}">
                                <span class="help-block">{{ $errors->first('car_addressed_to') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('car_comments') ? ' has-error':'' }}">
                                <label class="control-label">Comentarios</label>
                                <input type="text" class="form-control input-sm" name="car_comments" value="{{ old('car_comments') }}">
                                <span class="help-block">{{ $errors->first('car_comments') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando...">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
    //
</script>
