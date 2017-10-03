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
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('ant_account_number') ? ' has-error':'' }}">
                                <label class="control-label"># Cuenta (Ahorro)</label>
                                <select name="ant_account_number" class="form-control input-sm">
                                    @foreach (session('employee')->accounts_sav() as $account)
                                        <option value="{{ $account->getNumber() }}">{{ $account->getNumber() }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control input-sm" name="ant_account_number" value="{{ old('ant_account_number') }}"> --}}
                                <span class="help-block">{{ $errors->first('ant_account_number') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('ant_amount') ? ' has-error':'' }}">
                                <label class="control-label">Monto</label>
                                <input type="number" class="form-control input-sm text-right" name="ant_amount" value="{{ old('ant_amount') ? old('ant_amount') : '0' }}">
                                <span class="help-block">{{ $errors->first('ant_amount') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('ant_dues') ? ' has-error':'' }}">
                                <label class="control-label">Cuotas (MAX: 12)</label>
                                <input type="number" class="form-control input-sm" name="ant_dues" value="{{ old('ant_dues') ? old('ant_dues') : '1' }}">
                                <span class="help-block">{{ $errors->first('ant_dues') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('ant_due_amount') ? ' has-error':'' }}">
                                <label class="control-label">Monto de Cuotas</label>
                                <input type="text" readonly class="form-control input-sm text-right" name="ant_due_amount" value="{{ old('ant_due_amount') }}">
                                <span class="help-block">{{ $errors->first('ant_due_amount') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12{{ $errors->first('ant_observa') ? ' has-error':'' }}">
                            <label class="control-label">Observaciones</label>
                            <textarea class="form-control input-sm" placeholder="Observaciones" name="ant_observa">{{ old('ant_observa') }}</textarea>
                            <span class="help-block">{{ $errors->first('ant_observa') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-info">
                                En caso de que por cualquier razón terminara la relación laboral que actualmente mantengo con <b>Banco Múltiple de las Américas, S.A.</b>, autorizo a dicha institución a descontar de cualesquiera, prestaciones o derechos adquiridos, en virtud de la relación laboral mantenida con la misma, la cantidad adeudada por concepto de <b>anticipo de salario</b>, para que proceda al pago de la misma, comprometiéndome a pagar cualquier diferencia que no pueda cubrirse con los valores correspondientes a las prestaciones o derechos adquiridos.
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
    var field_amount = $('input[name=ant_amount]');
    var field_dues = $('input[name=ant_dues]');

    field_amount.keyup(function () {
        calculate(field_amount.val(), field_dues.val());
    });

    field_dues.keyup(function () {
        calculate(field_amount.val(), field_dues.val());
    });

    function calculate(amount, dues) {
        $('input[name=ant_due_amount]').val(amount / dues);
    }
</script>
