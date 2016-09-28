@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Editar Descripción')

@if (can_not_do('customer_ncf'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('customer.ncf.{invoice}.detail.update', ['invoice' => $detail->getInvoice(), 'id' => $detail->getSequence()]) }}" id="form">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="description" value="{{ $detail->getDescription() }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('monto') ? ' has-error':'' }}">
                                    <label class="control-label">Monto</label>
                                    <input type="text" disabled class="form-control input-sm input_money" value="{{ $detail->getCurrency() . ' ' . number_format($detail->getAmount(), 2) }}">
                                    <span class="help-block">{{ $errors->first('monto') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.ncf.{invoice}.detail.index', ['invoice' => $detail->getInvoice()]) }}"><i class="fa fa-arrow-left"></i> Atras</a>
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
