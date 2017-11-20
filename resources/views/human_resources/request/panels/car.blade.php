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
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('car_package_type') ? ' has-error':'' }}">
                                <label class="control-label">Tipo de Paquetes</label>
                                <select name="car_package_type" class="form-control input-sm">
                                    <option value="">Seleccione uno</option>
                                    @foreach ($params->where('type', 'PAQ') as $packages)
                                        <option value="{{ $packages->id }}"{{ old('car_package_type') ? ' selected' : '' }}>{{ $packages->name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('car_package_type') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('car_account_state_period') ? ' has-error':'' }}">
                                <label class="control-label">Periodo</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <input data-toggle="tooltip" title="Tiene Periodo" type="checkbox" name="car_has_account_state"{{ old('car_has_account_state') ? ' checked' : '' }}>
                                    </div>
                                    <select name="car_account_state_period" class="form-control input-sm">
                                        <option value="">Seleccione uno</option>
                                        @foreach ($params->where('type', 'EDO') as $period)
                                            <option value="{{ $period->id }}"{{ old('car_account_state_period') ? ' selected' : '' }}>{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="help-block">{{ $errors->first('car_account_state_period') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('car_mode_retirement') ? ' has-error':'' }}">
                                <label class="control-label">Modo de Retiro</label>
                                <select name="car_mode_retirement" class="form-control input-sm">
                                    <option value="">Seleccione uno</option>
                                    @foreach ($params->where('type', 'RET') as $retirement)
                                        <option value="{{ $retirement->id }}"{{ old('car_mode_retirement') ? ' selected' : '' }}>{{ $retirement->name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('car_mode_retirement') }}</span>
                            </div>
                        </div>
                    </div>
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
                            <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.create') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando...">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
    var checkbox = $('input[name=car_has_account_state]');
    var select = $('select[name=car_account_state_period]');

    select.prop('disabled', !checkbox.is(':checked'));

    checkbox.change(function (e) {
        select.prop('disabled', !checkbox.is(':checked'));
    });
</script>
