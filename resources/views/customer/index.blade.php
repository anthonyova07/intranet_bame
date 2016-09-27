@extends('layouts.master')

@section('title', 'Clientes')

@section('page_title', 'Consulta de Clientes')

@if (can_not_do('customer_consult'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="hidden-print">
                        <form method="get" action="{{ route('customer.index') }}" id="form">
                            <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                <label class="control-label">Identificación</label>
                                <input type="text" class="form-control input-sm" name="identification" placeholder="Cédula/Pasaporte" value="{{ old('identification') }}">
                                <span class="help-block">{{ $errors->first('identification') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Consultando cliente...">Consultar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @if ($customer)
                <div class="col-xs-12 well well-sm">
                    <div class="col-xs-12 text-center">
                        <h2>Información del Cliente <small>({{ $ibs ? 'Es':'No es' }} cliente)</small></h2>
                    </div>
                    <form method="post" action="" id="form_cliente">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Cédula/Pasaporte</label>
                                <input type="text" class="form-control input-sm" value="{{ ($customer->getDocument() == '') ? $customer->getPassport() : $customer->getDocument() }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <input type="text" class="form-control input-sm" value="{{ $customer->getNames() }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Apellidos</label>
                                <input type="text" class="form-control input-sm" value="{{ $customer->getLastNames() }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Sexo</label>
                                <input type="text" class="form-control input-sm" value="{{ get_gender($customer->getGender()) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nacionalidad</label>
                                <input type="text" class="form-control input-sm" value="{{ get_nationality($customer->getNation()) }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Calle</label>
                                <input type="text" class="form-control input-sm" value="{{ $customer->getStreet() }}" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>
                                <input type="text" class="form-control input-sm" value="{{ $customer->getCellPhone() }}" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <img class="img-thumbnail center-block" src="{{ $customer->photo }}" style="width: 355px; height: 335px;">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Estado Civil</label>
                                    <input type="text" class="form-control input-sm" value="{{ get_marital_status($customer->getMaritalStatus()) }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha de Nacimiento</label>
                                    <input type="text" class="form-control input-sm" value="{{ $customer->getBirthdate() }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Casa</label>
                                    <input type="text" class="form-control input-sm" value="{{ $customer->getHouse() }}" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Edificio</label>
                                    <input type="text" class="form-control input-sm" value="{{ $customer->getBuilding() }}" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
