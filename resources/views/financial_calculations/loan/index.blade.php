@extends('layouts.master')

@section('title', 'Cálculos Financieros - Préstamos')

@section('page_title', 'Cálculos Financieros - Préstamos')

@if (can_not_do('financial_calculations_index'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="{{ route('financial_calculations.loan.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('loan') ? ' has-error':'' }}">
                                    <label class="control-label">Préstamo</label>
                                    <select name="loan" class="form-control input-sm">
                                        <option value="">Seleccione uno</option>
                                        @foreach ($param_loans as $param_loan)
                                            <option value="{{ str_replace('%', '', $param_loan->value) }}">{{ $param_loan->descrip }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('loan') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('amount') ? ' has-error':'' }}">
                                    <label class="control-label">Monto</label>
                                    <input type="text" class="form-control input-sm" name="amount" placeholder="0.00" value="{{ request('amount') }}">
                                    <span class="help-block">{{ $errors->first('amount') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('year') ? ' has-error':'' }}">
                                    <label class="control-label">Año/s</label>
                                    <input type="text" class="form-control input-sm" name="year" placeholder="0" value="{{ request('year') }}">
                                    <span class="help-block">{{ $errors->first('year') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('month') ? ' has-error':'' }}">
                                    <label class="control-label">Mes/es</label>
                                    <input type="text" class="form-control input-sm" name="month" placeholder="0" value="{{ request('month') }}">
                                    <span class="help-block">{{ $errors->first('month') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('interests') ? ' has-error':'' }}">
                                    <label class="control-label">Intereses</label>
                                    <input type="text" class="form-control input-sm" name="interests" placeholder="0.00" value="{{ request('interests') }}">
                                    <span class="help-block">{{ $errors->first('interests') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('extraordinary') ? ' has-error':'' }}">
                                    <label class="control-label">Monto del Pago Extraordinarios</label>
                                    <input type="text" class="form-control input-sm" name="extraordinary" placeholder="0.00" value="{{ request('extraordinary') }}">
                                    <span class="help-block">{{ $errors->first('extraordinary') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('month_extraordinary') ? ' has-error':'' }}">
                                    <label class="control-label">Mes Extraordinarios</label>
                                    <select name="month_extraordinary" class="form-control input-sm">
                                        <option value="">Seleccione un mes para los pagos</option>
                                        @foreach (get_months() as $key => $month)
                                            <option value="{{ $key }}"{{ request('month_extraordinary') == $key ? ' selected':'' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('month_extraordinary') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('start_date') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha de Inicio de Cuota</label>
                                    <input type="date" class="form-control input-sm" name="start_date" value="{{ request('start_date') }}">
                                    <span class="help-block">{{ $errors->first('start_date') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('financial_calculations.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Consultando cliente...">Calcular Cuotas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($loan)
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Plan de Pagos</span>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>Monto:</b></td>
                                    <td>{{ number_format($loan->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Meses:</b></td>
                                    <td>{{ $loan->months }}</td>
                                </tr>
                                <tr>
                                    <td><b>Interes:</b></td>
                                    <td>{{ number_format($loan->interests, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Pagos Extraordinarios:</b></td>
                                    <td>
                                        @if ($loan->extraordinary)
                                            {{ number_format($loan->extraordinary, 2) }}
                                        @else
                                            0.00
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Mes Pagos Extraordinarios:</b></td>
                                    <td>{{ get_months($loan->month_extraordinary) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Fecha de Inicio:</b></td>
                                    <td>{{ datetime($loan->start_date)->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Mes</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Intereses</th>
                                <th class="text-center">Capital</th>
                                <th class="text-center">Extraordinario</th>
                                <th class="text-center">Cuota</th>
                                <th class="text-center">Saldo Final</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($loan->amortizations() as $amort)
                                <tr>
                                    <td>{{ $amort->month }}</td>
                                    <td>{{ $amort->date }}</td>
                                    <td>{{ number_format($amort->interests, 2) }}</td>
                                    <td>{{ number_format($amort->capital, 2) }}</td>
                                    <td>{{ $amort->extraordinary ? number_format($amort->extraordinary, 2) : 0.00 }}</td>
                                    <td>{{ number_format($amort->quota, 2) }}</td>
                                    <td>{{ number_format($amort->capital_pending, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        var year = $('input[name="year"]');
        var month = $('input[name="month"]');

        year.blur(function () {
            month.val(parseInt(year.val()) * 12);
        });

        month.blur(function () {
            year.val(parseInt(month.val()) / 12);
        });

        var loan = $('select[name="loan"]');
        var interests = $('input[name="interests"]');

        loan.change(function () {
            interests.val($(this).val());
        });
    </script>

@endsection
