@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Editar Detalle (No IBS)')

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('customer.ncf.no_ibs.new.detail.update', ['id' => $index]) }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="description" value="{{ $transaction->description }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('amount') ? ' has-error':'' }}">
                                    <label class="control-label">Monto</label>
                                    <input type="text" class="form-control input-sm input_money" name="amount" value="{{ $transaction->amount }}">
                                    <span class="help-block">{{ $errors->first('amount') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('calculate_tax') ? ' has-error':'' }}">
                                    <label>
                                        <input type="checkbox" name="calculate_tax" data-toggle="tooltip" title="Cacular ITBIS" style="margin-top: 30px;" {{ $transaction->tax_amount > 0 ? 'checked' : '' }}> Cal. ITBIS
                                    </label>
                                    <span class="help-block">{{ $errors->first('calculate_tax') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('day') ? ' has-error':'' }}">
                                    <label class="control-label">Día</label>
                                    <input type="number" class="form-control input-sm" name="day" value="{{ $transaction->day }}" max="31" min="1">
                                    <span class="help-block">{{ $errors->first('day') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('month') ? ' has-error':'' }}">
                                    <label class="control-label">Mes</label>
                                    <select class="form-control input-sm" name="month">
                                        @foreach (get_months() as $key => $month)
                                            <option value="{{ $key }}" {{ $transaction->month == $key ? 'selected':'' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('month') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('year') ? ' has-error':'' }}">
                                    <label class="control-label">Año</label>
                                    <input type="number" class="form-control input-sm" name="year" value="{{ $transaction->year }}" max="{{ (new DateTime)->format('Y') }}" min="2015">
                                    <span class="help-block">{{ $errors->first('year') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.ncf.no_ibs.new.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
