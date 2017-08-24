@extends('layouts.master')

@section('title', 'Clientes - Solicitudes')

@section('page_title', 'Nueva Solicitud de Tarjetas')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <form method="post" action="{{ route('customer.request.tdc.store') }}" id="form">

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tarjeta Aprobada</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('product_type') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <select class="form-control input-sm" name="">
                                        <option value="">Gold</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('product_type') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos Personales</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('product_type') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <select class="form-control input-sm" name="">
                                        <option value="">Gold</option>
                                    </select>
                                    <span class="help-block">{{ $errors->first('product_type') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tarjeta Aprobada</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="" value="">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <a class="btn btn-info btn-xs" href="{{ route('process.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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
