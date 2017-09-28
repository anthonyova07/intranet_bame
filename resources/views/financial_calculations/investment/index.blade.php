@extends('layouts.master')

@section('title', 'Cálculos Financieros - Inversiones')

@section('page_title', 'Cálculos Financieros - Inversiones')

{{-- @if (can_not_do('financial_calculations_index'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}


{{-- @foreach ($param_investments as $param_investment)
    <optgroup label="{{ $param_investment->name }}">
        @if ($param_investment->content == 'U')
            @foreach ($param_investment->details as $detail)
                <option value="{{ str_replace('%', '', $detail->value) }}">{{ $detail->value }}</option>
            @endforeach
        @elseif ($param_investment->content == 'V')
            @foreach ($param_investment->details as $detail)
                <option value="{{ str_replace('%', '', $detail->value) }}">{{ $detail->descrip }}</option>
            @endforeach
        @elseif ($param_investment->content == 'R')
            @foreach ($param_investment->details as $detail)
                @foreach ($param_investment->ranges() as $index => $range)
                    <optgroup label="{{ $range }}">
                        <option days="{{ get_days_from_text($range) }}" value="{{ str_replace('%', '', $detail->ranges[$index]->value) }}">{{ $detail->ranges[$index]->value }}</option>
                    </optgroup>
                @endforeach
            @endforeach
        @endif
    </optgroup>
@endforeach --}}

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <form method="get" action="{{ route('financial_calculations.investment.index') }}" id="form">

                        <input type="hidden" name="investment_field" value="">
                        <input type="hidden" name="range_field" value="">

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('investment') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Inversión</label>
                                    <select name="investment" class="form-control input-sm">
                                        <option value="">Seleccione uno</option>
                                        @foreach ($param_investments as $param_investment)
                                            <option value="{{ $param_investment->id }}">{{ $param_investment->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('investment') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('ranges') ? ' has-error':'' }}">
                                    <label class="control-label">Rangos</label>
                                    <select name="ranges" class="form-control input-sm">
                                        @foreach ($param_investments as $param_investment)
                                            @foreach ($param_investment->details as $detail)
                                                <option style="display: none;" product="{{ $detail->pro_id }}" value="{{ $detail->id }}">{{ $detail->descrip }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('ranges') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('days') ? ' has-error':'' }}">
                                    <label class="control-label">Días</label>
                                    <select name="days" class="form-control input-sm">
                                        @foreach ($param_investments as $param_investment)
                                            @foreach ($param_investment->details as $detail)
                                                @foreach ($param_investment->ranges() as $index => $range)
                                                    <option days="{{ get_days_from_text($range) }}" style="display: none;" range="{{ $detail->id }}" value="{{ str_replace('%', '', $detail->ranges[$index]->value) }}">{{ $range }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('days') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-1">
                                <div class="form-group{{ $errors->first('days') ? ' has-error':'' }}">
                                    <label class="control-label">Días</label>
                                    <input type="text" class="form-control input-sm" name="days" placeholder="0" value="{{ request('days') }}">
                                    <span class="help-block">{{ $errors->first('days') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-1">
                                <div class="form-group{{ $errors->first('interests') ? ' has-error':'' }}">
                                    <label class="control-label">Intereses</label>
                                    <input type="text" class="form-control input-sm text-right" name="interests" placeholder="0.00" value="{{ request('interests') }}">
                                    <span class="help-block">{{ $errors->first('interests') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('amount') ? ' has-error':'' }}">
                                    <label class="control-label">Monto</label>
                                    <input type="text" class="form-control input-sm text-right" name="amount" placeholder="0.00" value="{{ request('amount') }}">
                                    <span class="help-block">{{ $errors->first('amount') }}</span>
                                </div>
                            </div>
                        </div>

                        {{ csrf_field() }}
                        {{-- <a class="btn btn-info btn-xs" href="{{ route('financial_calculations.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a> --}}
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Calculando inversión...">Calcular Inversión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($investment)
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Inversión Obtenida</span>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>Tipo de Inversión:</b></td>
                                    <td>{{ request('investment_field') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Rangos:</b></td>
                                    <td>{{ request('range_field') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Monto:</b></td>
                                    <td>{{ number_format($investment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Días:</b></td>
                                    <td>{{ $investment->days }}</td>
                                </tr>
                                <tr>
                                    <td><b>Interés:</b></td>
                                    <td>{{ number_format($investment->interests, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Intereses Ganados:</b></td>
                                    <td>{{ number_format($investment->interests_earned, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total:</b></td>
                                    <td>{{ number_format($investment->total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        var investment_field = $('input[name="investment_field"]');
        var range_field = $('input[name="range_field"]');

        var interests = $('input[name="interests"]');
        var days = $('input[name="days"]');

        var investment = $('select[name="investment"]');
        var ranges = $('select[name="ranges"]');
        var select_days = $('select[name="days"]');

        ranges.val(-1);
        select_days.val(-1);

        investment.change(function () {
            ranges.val(-1);
            select_days.val(-1);

            investment_field.val(investment.find("option:selected").text());

            ranges.children().each(function (index, option) {
                var option = $(option);

                if (option.attr('product') == investment.val()) {
                    option.show();
                } else {
                    option.hide();
                }
            });
        });

        ranges.change(function () {
            select_days.val(-1);

            range_field.val(ranges.find("option:selected").text());

            select_days.children().each(function (index, option) {
                var option = $(option);

                if (option.attr('range') == ranges.val()) {
                    option.show();
                } else {
                    option.hide();
                }
            });
        });

        select_days.change(function () {
            var option = select_days.find("option:selected");

            interests.val($(this).val());
            if (option.attr('days') != undefined) {
                days.val(option.attr('days'));
            } else {
                days.val(0);
            }
        });

        // var investment = $('select[name="investment"]');
        // var interests = $('input[name="interests"]');
        // var days = $('input[name="days"]');

        // investment.change(function () {
        //     var select = $(this);
        //     var option = select.find("option:selected");

        //     interests.val($(this).val());
        //     if (option.attr('days') != undefined) {
        //         days.val(option.attr('days'));
        //     } else {
        //         days.val(0);
        //     }
        // });
    </script>

@endsection
