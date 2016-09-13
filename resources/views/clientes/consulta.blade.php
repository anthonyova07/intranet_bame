@extends('layouts.master')

@section('title', 'Clientes')

@section('page_title', 'Consulta de Clientes')

@if (can_not_do('clientes_consulta'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="hidden-print">
                        <form method="post" action="{{ route('clientes::consulta') }}" id="form_consulta">
                            <div class="form-group{{ $errors->first('identificacion') ? ' has-error':'' }}">
                                <label class="control-label">Identificación</label>
                                <input type="text" class="form-control" name="identificacion" placeholder="Cédula/Pasaporte" value="{{ old('identificacion') }}">
                                <span class="help-block">{{ $errors->first('identificacion') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Consultando cliente...">Consultar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @if ($cliente)
                <div class="col-xs-12 well well-sm">
                    <div class="col-xs-12 text-center">
                        <h2>Información del Cliente <small>({{ $cliente->IBS ? 'Es':'No es' }} cliente)</small></h2>
                    </div>
                    <form method="post" action="" id="form_cliente">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Cédula/Pasaporte</label>
                                <input type="text" class="form-control" value="{{ $cliente->CEDULA == '' ? $cliente->PASAPORTE : $cliente->CEDULA }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <input type="text" class="form-control" value="{{ cap_str($cliente->NOMBRES) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Apellidos</label>
                                <input type="text" class="form-control" value="{{ cap_str($cliente->APELLIDOS) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Sexo</label>
                                <input type="text" class="form-control" value="{{ get_gender($cliente->SEXO) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nacionalidad</label>
                                <input type="text" class="form-control" value="{{ get_nationality($cliente->CODNACION) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Calle</label>
                                <input type="text" class="form-control" value="{{ cap_str($cliente->CALLE) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>
                                <input type="text" class="form-control" value="{{ $cliente->TELEFONO }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <img class="img-thumbnail center-block" src="{{ $cliente->FOTO }}" style="width: 355px; height: 355px;">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Estado Civil</label>
                                    <input type="text" class="form-control" value="{{ get_marital_status($cliente->ESTCIVIL) }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha de Nacimiento</label>
                                    <input type="text" class="form-control" value="{{ $cliente->FECHANAC }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Casa</label>
                                    <input type="text" class="form-control" value="{{ cap_str($cliente->CASA) }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Edificio</label>
                                    <input type="text" class="form-control" value="{{ cap_str($cliente->EDIFICIO) }}" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
