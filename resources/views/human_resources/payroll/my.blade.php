@extends('layouts.master')

@section('title', 'Recursos Humanos -> Nómina')

@section('page_title', 'Mis Nómina')

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="{{ route('human_resources.payroll.my') }}" id="form">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    {{-- <label class="control-label">Seleccione una nómina</label> --}}
                                    <select name="payroll_date" id="payroll_date" class="form-control">
                                        @foreach ($dates as $date)
                                            <option value="{{ $date->payroldate->format('Y-m-d') }}"{{ $date->payroldate->format('Y-m-d') == Request::get('payroll_date') ? ' selected':'' }}>{{ ($date->payroldate->format('d') > 15 ? '2da Quincena' : '1ra Quincena') . ' de ' . get_months($date->payroldate->format('m')) . ' del ' . $date->payroldate->format('Y') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Cargando nómina...">Cargar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($payroll)

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payroll->details as $detail)
                                <tr class="{{ $detail->amount < 0 ? 'danger':'success' }}">
                                    <td>{{ $detail->code }}</td>
                                    <td>{{ $detail->comment }}</td>
                                    <td>{{ number_format($detail->amount, 2) }}</td>
                                </tr>
                            @endforeach
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

        // $('select[name=payroll_date]').change(function () {
        //     $('#form').submit();
        // });
    </script>

@endsection
