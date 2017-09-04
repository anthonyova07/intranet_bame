<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel')

        @include('human_resources.request.panels.supervisor_panel')
    </div>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
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
                                <input type="number" class="form-control input-sm" min="1" name="vac_total_days" value="{{ old('vac_total_days') ?? 1 }}">
                                <span class="help-block">{{ $errors->first('vac_total_days') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_additional_days') ? ' has-error':'' }}">
                                <label class="control-label">Días Adicionales</label>
                                <input type="number" class="form-control input-sm" min="0" name="vac_additional_days" value="{{ old('vac_additional_days') ?? 0 }}">
                                <span class="help-block">{{ $errors->first('vac_additional_days') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_from') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Inicio</label>
                                <input type="date" class="form-control input-sm" name="vac_date_from" value="{{ old('vac_date_from') }}">
                                <span class="help-block">{{ $errors->first('vac_date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_to') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Reintegro</label>
                                <input type="date" class="form-control input-sm" readonly name="vac_date_to" value="{{ old('vac_date_to') }}">
                                <span class="help-block">{{ $errors->first('vac_date_to') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="checkbox{{ $errors->first('vac_credited_bonds') ? ' has-error':'' }}">
                                <label>
                                    <input type="checkbox" name="vac_credited_bonds" {{ old('vac_credited_bonds') ? 'checked' : '' }} value="acreditar_bono"> Acreditar Bono Vacacional
                                </label>
                                <span class="help-block">{{ $errors->first('vac_credited_bonds') }}</span>
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

    var total_days = $('input[name=vac_total_days]');
    var add_days = $('input[name=vac_additional_days]');
    var date_from = $('input[name=vac_date_from]');
    var date_to = $('input[name=vac_date_to]');

    total_days.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    add_days.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    date_from.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    function calculate(total_days, date_from) {
        $.getJSON('{{ route('human_resources.request.calculate_vac_date_to') }}', {
            total_days: total_days,
            date_from: date_from
        }, function (response) {
            date_to.val(response.date_to);
        });
    }
</script>
