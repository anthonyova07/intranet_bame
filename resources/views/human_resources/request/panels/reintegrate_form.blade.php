<form method="post" action="{{ route('human_resources.request.reintegrate', $human_resource_request->id) }}" novalidate>
    <div class="row text-center">
        <h4 style="margin-bottom: 5px;">Modificar Fecha de Solicitud</h4>
    </div>

    @if (in_array($human_resource_request->reqtype, ['PER', 'AUS']))
        <div class="row">
            <div class="col-xs-6{{ $human_resource_request->detail->pertype == 'one_day' ? ' col-xs-offset-3' : '' }}"{!! $human_resource_request->detail->pertype == 'one_day' ? '' : ' style="display: none;"' !!}>
                <div class="radio">
                    <label style="font-size: 16px;font-weight: bold;">
                        <input type="radio"{{ $human_resource_request->detail->pertype == 'one_day' ? ' checked' : '' }} disabled name="permission_type_reintegrate" value="one_day"> Por un día o menos
                    </label>
                </div>
            </div>
            @if (!in_array($human_resource_request->reqtype, ['AUS']))
                <div class="col-xs-6{{ $human_resource_request->detail->pertype == 'multiple_days' ? ' col-xs-offset-3' : '' }}"{!! $human_resource_request->detail->pertype == 'multiple_days' ? '' : ' style="display: none;"' !!}>
                    <div class="radio">
                        <label style="font-size: 16px;font-weight: bold;">
                            <input type="radio"{{ $human_resource_request->detail->pertype == 'multiple_days' ? ' checked' : '' }} disabled  name="permission_type_reintegrate" value="multiple_days"> Por varios días
                        </label>
                        <span class="help-block">{{ $errors->first('permission_type') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-6{{ $human_resource_request->detail->pertype == 'one_day' ? ' col-xs-offset-3' : '' }}"{!! $human_resource_request->detail->pertype == 'one_day' ? '' : ' style="display: none;"' !!}>
                <div class="well well-sm" id="one_day"{!! old('permission_type') == 'multiple_days' ? ' style="display: none;"' : '' !!}>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('permission_date_reintegrate') ? ' has-error':'' }}">
                                <label class="control-label">Fecha</label>
                                <input type="date" style="width: 135px;" class="form-control input-sm" name="permission_date_reintegrate" value="{{ old('permission_date_reintegrate') ? old('permission_date_reintegrate') : ($human_resource_request->detail->perdatfror ? $human_resource_request->detail->perdatfror->format('Y-m-d') : '') }}">
                                <span class="help-block">{{ $errors->first('permission_date_reintegrate') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('permission_time_from_reintegrate') ? ' has-error':'' }}">
                                <label class="control-label">Hora Desde</label>
                                <input type="time" class="form-control input-sm" name="permission_time_from_reintegrate" value="{{ old('permission_time_from_reintegrate') ? old('permission_time_from_reintegrate') : $human_resource_request->detail->pertimfror }}">
                                <span class="help-block">{{ $errors->first('permission_time_from_reintegrate') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('permission_time_to_reintegrate') ? ' has-error':'' }}">
                                <label class="control-label">Hora Hasta</label>
                                <input type="time" class="form-control input-sm" name="permission_time_to_reintegrate" value="{{ old('permission_time_to_reintegrate') ? old('permission_time_to_reintegrate') : $human_resource_request->detail->pertimtor }}">
                                <span class="help-block">{{ $errors->first('permission_time_to_reintegrate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!in_array($human_resource_request->reqtype, ['AUS']))
                <div class="col-xs-6{{ $human_resource_request->detail->pertype == 'multiple_days' ? ' col-xs-offset-3' : '' }}"{!! $human_resource_request->detail->pertype == 'multiple_days' ? '' : ' style="display: none;"' !!}>
                    <div class="well well-sm" id="multiple_days"{!! old('permission_type') == 'one_day' ? ' style="display: none;"' : '' !!}>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('permission_date_from_reintegrate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Desde</label>
                                    <input type="date" class="form-control input-sm" name="permission_date_from_reintegrate" value="{{ old('permission_date_from_reintegrate') ? old('permission_date_from_reintegrate') : ($human_resource_request->detail->perdatfror ? $human_resource_request->detail->perdatfror->format('Y-m-d') : '') }}">
                                    <span class="help-block">{{ $errors->first('permission_date_from_reintegrate') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('permission_date_to_reintegrate') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha Hasta</label>
                                    <input type="date" class="form-control input-sm" name="permission_date_to_reintegrate" value="{{ old('permission_date_to_reintegrate') ? old('permission_date_to_reintegrate') : ($human_resource_request->detail->perdattor ? $human_resource_request->detail->perdattor->format('Y-m-d') : '') }}">
                                    <span class="help-block">{{ $errors->first('permission_date_to_reintegrate') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="row">
        @if (in_array($human_resource_request->reqtype, ['VAC']))
            <div class="col-xs-6 col-xs-offset-3">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('vac_date_from_reintegrate') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Inicio</label>
                                <input type="date" class="form-control input-sm" name="vac_date_from_reintegrate" value="{{ old('vac_date_from_reintegrate') ? old('vac_date_from_reintegrate') : ($human_resource_request->detail->vacdatfror ? $human_resource_request->detail->vacdatfror->format('Y-m-d') : '') }}">
                                <span class="help-block">{{ $errors->first('vac_date_from_reintegrate') }}</span>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('vac_date_to_reintegrate') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Reintegro</label>
                                <input type="date" disabled class="form-control input-sm" name="vac_date_to_reintegrate" value="{{ old('vac_date_to_reintegrate') ? old('vac_date_to_reintegrate') : ($human_resource_request->detail->vacdattor ? $human_resource_request->detail->vacdattor->format('Y-m-d') : '') }}">
                                <span class="help-block">{{ $errors->first('vac_date_to_reintegrate') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="form-group{{ $errors->first('per_reason_reintregrate') ? ' has-error':'' }}">
                <textarea style="margin-top: -15px;" class="form-control input-sm" placeholder="Especifique la razón del reintegro..." name="per_reason_reintregrate">{{ old('per_reason_reintregrate') ? old('per_reason_reintregrate') : $human_resource_request->detail->observar }}</textarea>
                <span class="help-block" style="margin-bottom: 25px;">{{ $errors->first('per_reason_reintregrate') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center" style="margin-top: -18px;margin-bottom: 20px;">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando...">Enviar</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    var total_days = $('input[name=vac_total_days]');
    var add_days = $('input[name=vac_additional_days]');
    var date_from_r = $('input[name=vac_date_from_reintegrate]');
    var date_to_r = $('input[name=vac_date_to_reintegrate]');

    date_from_r.change(function (e) {
        calculate_r(parseInt(total_days.val()) + parseInt(add_days.val()), date_from_r.val());
    });

    function calculate_r(total_days, date_from) {
        $.getJSON('{{ route('human_resources.request.calculate_vac_date_to') }}', {
            total_days: total_days,
            date_from: date_from
        }, function (response) {
            date_to_r.val(response.date_to);
        });
    }
</script>

