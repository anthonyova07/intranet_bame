@extends('layouts.master')

@section('title', 'Procesos - Gastos de Cierre')

@section('page_title', 'Nuevo Gasto de Cierre')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <form method="post" action="{{ route('process.closing_cost.store') }}" id="form">

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la Solicitud</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('credit_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Credito</label>
                                    <select class="form-control input-sm" name="credit_type">
                                        <option value="">Selecciona un Tipo de Crédito</option>
                                        @foreach ($credits_type as $credit_type)
                                            <option value="{{ $credit_type->id }}" {{ old('credit_type') == $credit_type->id ? 'selected':'' }}>{{ $credit_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('credit_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('warranty_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Garantia</label>
                                    <select class="form-control input-sm" name="warranty_type">
                                        <option value="">Selecciona un Tipo de Garantía</option>
                                        @foreach ($warranties_type as $warranty_type)
                                            <option value="{{ $warranty_type->id }}" {{ old('warranty_type') == $warranty_type->id ? 'selected':'' }}>{{ $warranty_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('warranty_type') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la Solicitud</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('ranks') ? ' has-error':'' }}">
                                    <label class="control-label">Rangos</label>
                                    <input type="text" class="form-control input-sm" name="ranks[]" value="{{ old('ranks') }}">
                                    <span class="help-block">{{ $errors->first('ranks') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">Tarifa</label>
                                <div class="input-group{{ $errors->first('rate') ? ' has-error':'' }}">
                                    <span class="input-group-addon" data-toggle="tooltip" title="Solo Tarifa">
                                        <input type="checkbox" name="only_rate[]">
                                    </span>
                                    <input type="text" class="form-control input-sm" name="rate[]" value="{{ old('rate') }}">
                                    <span class="help-block">{{ $errors->first('rate') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <a class="btn btn-info btn-xs" href="{{ route('process.closing_cost.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
