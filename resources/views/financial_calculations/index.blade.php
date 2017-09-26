@extends('layouts.master')

@section('title', 'Cálculos Financieros -> Préstamos')

@section('page_title', 'Cálculos Financieros')

@if (can_not_do('financial_calculations_index'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row" id="reports">
        <div class="col-xs-2">
            <a href="{{ route('financial_calculations.loan.index') }}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row text-center">
                            <div class="col-xs-12">
                                <i class="fa fa-calculator fa-4x"></i>
                            </div>
                            <div class="col-xs-12" style="font-size: 20px;">
                                Préstamos
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>


    @if (!can_not_do('financial_calculations_admin_not'))
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Préstamos</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('financial_calculations.{type}.param.create', ['type' => 'PRE']) }}">Nueva</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tasa</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->name }}</td>
                                        <td>{{ $loan->rate }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('financial_calculations.{type}.param.edit', ['type' => 'TIPSOL', 'param' => $loan->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inversiones</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('financial_calculations.{type}.param.create', ['type' => 'INV']) }}">Nueva</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tasa</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($investments as $investment)
                                    <tr>
                                        <td>{{ $investment->name }}</td>
                                        <td>{{ $investment->rate }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('financial_calculations.{type}.param.edit', ['type' => 'INV', 'param' => $investment->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    @endif

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
