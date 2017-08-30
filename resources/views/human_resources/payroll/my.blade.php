@extends('layouts.master')

@section('title', 'Recursos Humanos -> Nóminas')

@section('page_title', 'Mis Nóminas')

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="{{ route('human_resources.payroll.my') }}" id="form">
                        @if (request()->has('authenticated'))
                            <input type="hidden" name="authenticated" value="1">
                        @endif
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Año</label>
                                    <select name="year" id="year" class="form-control">
                                        @for ($year=datetime()->format('Y'); $year >= 2005; $year--)
                                            <option value="{{ $year }}"{{ $year == Request::get('year') ? ' selected':'' }} }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Mes</label>
                                    <select name="month" id="month" class="form-control">
                                        @foreach (get_months() as $key => $month)
                                            <option value="{{ $key }}"{{ $key == request()->get('month') || (!request()->has('month') && $key == datetime()->format('m')) ? ' selected':'' }} }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Quincena</label>
                                    <select name="day" id="day" class="form-control">
                                        <option value="15"{{ 15 == request()->get('day') || datetime()->format('d') <= 15 ? ' selected':'' }}>1ra Quincena</option>
                                        @if (request('month'))
                                            <option value="{{ 2 == request()->get('month') ? '28' : (in_array(request('month'), [1,3,5,7,8,10,12]) ? '31' : '30') }}"{{ in_array(request()->get('day'), [28, 30]) || request('day') > 15 ? ' selected':'' }}>2da Quincena</option>
                                        @else
                                            <option value="{{ 2 == datetime()->format('m') ? '28' : (in_array(datetime()->format('m'), [1,3,5,7,8,10,12]) ? '31' : '30') }}"{{ in_array(request()->get('day'), [28, 30]) || datetime()->format('d') > 15 ? ' selected':'' }}>2da Quincena</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Seleccione una nómina</label>
                                    <select name="payroll_date" id="payroll_date" class="form-control">
                                        @foreach ($dates as $date)
                                            <option value="{{ $date->payroldate->format('Y-m-d') }}"{{ $date->payroldate->format('Y-m-d') == Request::get('payroll_date') ? ' selected':'' }}>{{ ($date->payroldate->format('d') > 15 ? '2da Quincena' : '1ra Quincena') . ' de ' . get_months($date->payroldate->format('m')) . ' del ' . $date->payroldate->format('Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando nómina...">Cargar Nómina</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($payroll)

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Comprobante de Pago de Nómina</h3>
                        <a style="font-size: 13px;font-size: 13px;margin-top: -18px;margin-right: -8px;" class="label btn-warning pull-right" target="__blank" href="{{ route('human_resources.payroll.my', array_merge(request()->only(['authenticated', 'year', 'month', 'day']), ['print' => 1])) }}">Imprimir</a>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <b style="font-size: 16px;">Banco Múltiple de las Américas, S.A.</b>
                                        <br>RNC: 1-01-11784-2
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Código:</b> </td>
                                    <td>{{ $payroll->recordcard }}</td>
                                </tr>
                                <tr>
                                    <td><b>Nombre:</b> </td>
                                    <td>{{ $payroll->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Departamento:</b> </td>
                                    <td>{{ $payroll->department }}</td>
                                </tr>
                                <tr>
                                    <td><b>Cargo:</b> </td>
                                    <td>{{ $payroll->position }}</td>
                                </tr>
                                <tr>
                                    <td><b>Identificación:</b> </td>
                                    <td>{{ $payroll->identifica }}</td>
                                </tr>
                                <tr>
                                    <td><b>Fecha Nómina:</b> </td>
                                    <td>{{ $payroll->payroldate->format('d/m/Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Deducciones</th>
                                <th>Pagos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payroll->details as $detail)
                                <tr class="{{ $detail->amount < 0 ? 'danger':'success' }}">
                                    <td>{{ $detail->code }}</td>
                                    <td>{{ $detail->comment }}</td>
                                    <td class="text-right">{{ $detail->amount < 0 ? number_format($detail->amount, 2) : '' }}</td>
                                    <td class="text-right">{{ $detail->amount > 0 ? number_format($detail->amount, 2) : '' }}</td>
                                </tr>
                            @endforeach
                            <tr class="info" style="font-weight: bold;">
                                <td></td>
                                <td>Totales</td>
                                <td class="text-right">{{ number_format($total_discharge, 2) }}</td>
                                <td class="text-right">{{ number_format($total_ingress, 2) }}</td>
                            </tr>
                            <tr class="active" style="font-weight: bold;">
                                <td>{{ $last_detail->code }}</td>
                                <td>Monto Neto</td>
                                <td class="text-center" colspan="2">{{ $last_detail->amount > 0 ? number_format($last_detail->amount, 2) : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif

    <script type="text/javascript">
        $('#form').submit(function () {
            $('#btn_submit').button('loading');
        });

        var month = $('select[name=month]');
        var day = $('select[name=day]');

        month.change(function () {
            if (month.val() == 2) {
                $(day.children()[1]).attr('value', 28);
            } else {
                if (month.val() == 1 || month.val() == 3 || month.val() == 5 || month.val() == 7 || month.val() == 8 || month.val() == 10 || month.val() == 12) {
                    $(day.children()[1]).attr('value', 31);
                } else {
                    $(day.children()[1]).attr('value', 30);
                }
            }
        });

        // $('select[name=payroll_date]').change(function () {
        //     $('#form').submit();
        // });
    </script>

@endsection
