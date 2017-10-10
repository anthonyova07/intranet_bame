<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel')

        @include('human_resources.request.panels.supervisor_panel')
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle de la Solicitud ({{ $type_desc }})</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        {{-- <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_admission') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Ingreso</label>
                                <input type="date" style="width: 125px;" disabled class="form-control input-sm" name="vac_date_admission" value="{{ $employee_date }}">
                                <span class="help-block">{{ $errors->first('vac_date_admission') }}</span>
                            </div>
                        </div> --}}
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vacation_year') ? ' has-error':'' }}">
                                <label class="control-label">Año de las Vacaciones</label>
                                <select name="vacation_year" class="form-control input-sm">
                                    <option value=""></option>
                                    @foreach ($vacations as $vacation)
                                        <option value="{{ $vacation->year }}" remaining="{{ $vacation->remaining }}"{{ old('vacation_year') == $vacation->year ? 'selected' : '' }}>{{ $vacation->year }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">{{ $errors->first('vacation_year') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_from') ? ' has-error':'' }}">
                                <label class="control-label">Fecha de Inicio</label>
                                <input type="date" class="form-control input-sm" name="vac_date_from" value="{{ old('vac_date_from') }}">
                                <span class="help-block">{{ $errors->first('vac_date_from') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_total_days') ? ' has-error':'' }}">
                                <label class="control-label">Días a Tomar</label>
                                {{-- <input type="number" class="form-control input-sm" min="1" name="vac_total_days" value="{{ old('vac_total_days') ?? 1 }}"> --}}
                                <select name="vac_total_days" class="form-control input-sm">
                                    <option value="0">0</option>
                                    @if (old('vac_total_days'))
                                        <option value="{{ old('vac_total_days') }}" selected>{{ old('vac_total_days') }}</option>
                                    @endif
                                </select>
                                <span class="help-block">{{ $errors->first('vac_total_days') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group{{ $errors->first('vac_additional_days') ? ' has-error':'' }}">
                                <label class="control-label">Días Adicionales</label>
                                {{-- <input type="number" class="form-control input-sm" min="0" name="vac_additional_days" value="{{ old('vac_additional_days') ?? 0 }}"> --}}
                                <select name="vac_additional_days" class="form-control input-sm">
                                    <option value="0">0</option>
                                    @if (old('vac_additional_days'))
                                        <option value="{{ old('vac_additional_days') }}" selected>{{ old('vac_additional_days') }}</option>
                                    @endif
                                </select>
                                <span class="help-block">{{ $errors->first('vac_additional_days') }}</span>
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

    var total_days = $('select[name=vac_total_days]');
    var add_days = $('select[name=vac_additional_days]');
    var date_from = $('input[name=vac_date_from]');
    var date_to = $('input[name=vac_date_to]');

    var date_from_r = $('input[name=vac_date_from_reintegrate]');
    var date_to_r = $('input[name=vac_date_to_reintegrate]');

    var vacation_year = $('select[name=vacation_year]');

    vacation_year.change(function () {
        var remaining = $(vacation_year.find('option:selected')[0]);

        total_days.html('<option value="0">0</option>');

        for (var i = 1; i <= remaining.attr('remaining'); i++) {
            total_days.append('<option value="'+i+'">'+i+'</option>');
        }

        if ((new Date).getFullYear() == vacation_year.val()) {
            add_days.html('<option value="0">0</option>');

            for (var i = 1; i <= 2; i++) {
                add_days.append('<option value="'+i+'">'+i+'</option>');
            }
        } else {
            add_days.html('<option value="0">0</option>');
        }
    });

    total_days.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    add_days.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    date_from.change(function (e) {
        calculate(parseInt(total_days.val()) + parseInt(add_days.val()), date_from.val());
    });

    date_from_r.change(function (e) {
        calculate_r(parseInt(total_days.val()) + parseInt(add_days.val()), date_from_r.val());
    });

    function calculate(total_days, date_from) {
        $.getJSON('{{ route('human_resources.request.calculate_vac_date_to') }}', {
            total_days: total_days,
            date_from: date_from
        }, function (response) {
            date_to.val(response.date_to);
        });
    }

    function calculate_r(total_days, date_from) {
        $.getJSON('{{ route('human_resources.request.calculate_vac_date_to') }}', {
            total_days: total_days,
            date_from: date_from
        }, function (response) {
            date_to_r.val(response.date_to);
        });
    }
</script>
