@extends('layouts.master')

@section('title', 'Cálculos Financieros - ' . get_financial_calculation_params($type))

@section('page_title', 'Nueva Tasa de ' . get_financial_calculation_params($type))

{{-- @if (can_not_do('process_request_admin'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('financial_calculations.{type}.param.store', ['type' => $type]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ old('name') }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('rate') ? ' has-error':'' }}">
                                    <label class="control-label">Tasa</label>
                                    <input type="text" class="form-control input-sm text-right" name="rate" value="{{ old('rate') }}">
                                    <span class="help-block">{{ $errors->first('rate') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('financial_calculations.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
