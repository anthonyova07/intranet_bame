<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel')

        @include('human_resources.request.panels.supervisor_panel')
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle de la Solicitud ( {{ $type_desc }} )</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_date_admission') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Ingreso</label>
                                <input type="date" disabled class="form-control input-sm" name="vac_date_admission" value="{{ $employee_date }}">
                                <span class="help-block">{{ $errors->first('vac_date_admission') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_total_days') ? ' has-error':'' }}">
                                <label class="control-label">Días a Tomar</label>
                                <input type="number" class="form-control input-sm" name="vac_total_days" value="{{ old('vac_total_days') }}">
                                <span class="help-block">{{ $errors->first('vac_total_days') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_total_pending_days') ? ' has-error':'' }}">
                                <label class="control-label">Días Pendientes a Tomar</label>
                                <input type="number" class="form-control input-sm" name="vac_total_pending_days" value="{{ old('vac_total_pending_days') }}">
                                <span class="help-block">{{ $errors->first('vac_total_pending_days') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_date_from') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Inicio</label>
                                <input type="date" class="form-control input-sm" name="vac_date_from" value="{{ old('vac_date_from') }}">
                                <span class="help-block">{{ $errors->first('vac_date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_date_to') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Reintegro</label>
                                <input type="date" class="form-control input-sm" readonly name="vac_date_to" value="{{ old('vac_date_to') }}">
                                <span class="help-block">{{ $errors->first('vac_date_to') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="checkbox{{ $errors->first('vac_credited_bonds') ? ' has-error':'' }}" style="margin-top: 22px;">
                                <label>
                                    <input type="checkbox" name="vac_credited_bonds" {{ old('vac_credited_bonds') ? 'checked' : '' }} value="acreditar_bono"> Acreditar Bono Vacacional
                                </label>
                                <span class="help-block">{{ $errors->first('vac_credited_bonds') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group{{ $errors->first('vac_note') ? ' has-error':'' }}">
                                <textarea class="form-control input-sm" placeholder="Observación" name="vac_note">{{ old('vac_note') }}</textarea>
                                <span class="help-block">{{ $errors->first('vac_note') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
    $('input[name=permission_type]').change(function () {
        var type = $(this).val();
        if (type == 'one_day') {
            $('#one_day').show('fast');
            $('#multiple_days').hide('fast');
        } else if (type == 'multiple_days') {
            $('#multiple_days').show('fast');
            $('#one_day').hide('fast');
        }
    });
</script>
