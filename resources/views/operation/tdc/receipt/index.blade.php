@extends('layouts.master')

@section('title', 'Encartes')

@section('page_title', 'Generación de Encartes')

@if (can_not_do('operation_tdc_receipt'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('operation.tdc.receipt.store') }}" id="form">
                        <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                            <label class="control-label">Identificación</label>
                            <input type="text" class="form-control input-sm" name="identification" placeholder="Cédula/Pasaporte" value="{{ old('identification') }}">
                            <span class="help-block">{{ $errors->first('identification') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('credit_card') ? ' has-error':'' }}">
                            <label class="control-label"># TDC</label>
                            <input type="text" class="form-control input-sm" name="credit_card" placeholder="0000-0000-0000-0000" value="{{ old('credit_card') }}">
                            <span class="help-block">{{ $errors->first('credit_card') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('date') ? ' has-error':'' }}">
                            <label class="control-label">Fecha de Embozado</label>
                            <input type="date" class="form-control input-sm" name="date" value="{{ old('date') }}">
                            <span class="help-block">{{ $errors->first('date') }}</span>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Generando encartes...">Generar PDFs <span class="badge" data-toggle="tooltip" data-placement="bottom" title="Encartes Pendientes">{{ $outstanding_amount }}</span></button>
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
