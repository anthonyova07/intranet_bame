@extends('layouts.master')

@section('title', 'Clientes - Solicitudes')

@section('page_title', 'Solicitud de Tarjeta #' . $request_tdc->reqnumber)

@if (can_not_do('customer_requests_tdc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('customer.request.tdc.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>
                    <div class="col-xs-2 pull-right">
                        <a style="font-size: 13px;padding: 8px 8px;" class="label btn-warning pull-right" target="__blank" href="{{ route('customer.request.tdc.print', ['id' => $request_tdc->id]) }}">Imprimir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tarjeta Aprobada</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Producto</label>
                                <p class="form-control-static">{{ $request_tdc->producttyp }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Limite RD$</label>
                                <p class="form-control-static">{{ number_format($request_tdc->limitrd, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Limite US$</label>
                                <p class="form-control-static">{{ number_format($request_tdc->limitus, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Plástico</label>
                                <p class="form-control-static">{{ $request_tdc->plastiname }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos Personales</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <label class="control-label">Nombres y Apellidos</label>
                                <p class="form-control-static">{{ $request_tdc->names }}</p>
                            </div>
                        </div>
                        {{-- <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('last_names') ? ' has-error':'' }}">
                                <label class="control-label">Apellidos</label>
                                <input type="text" class="form-control input-sm" name="last_names" value="{{ old('last_names') }}">
                                <span class="help-block">{{ $errors->first('last_names') }}</span>
                            </div>
                        </div> --}}
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Identificación</label>
                                <p class="form-control-static">{{ $request_tdc->identifica }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Fecha Nacimiento</label>
                                <p class="form-control-static">{{ $request_tdc->birthdate }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Nacionalidad</label>
                                <p class="form-control-static">{{ $request_tdc->nationalit }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Género</label>
                                <p class="form-control-static">{{ get_gender($request_tdc->gender) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Estado Civil</label>
                                <p class="form-control-static">{{ get_marital($request_tdc->maristatus) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dirección Personal</h3>
                    @if ($request_tdc->senddirpla == 'personal')
                        <span class="pull-right" style="margin-top: -19px;">
                            <span class="label label-success">Dirección de Entrega</span>
                        </span>
                    @endif
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Calle</label>
                                <p class="form-control-static">{{ $request_tdc->pstreet }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">No.</label>
                                <p class="form-control-static">{{ $request_tdc->pnum }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Edificio</label>
                                <p class="form-control-static">{{ $request_tdc->pbuilding }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Apartamento</label>
                                <p class="form-control-static">{{ $request_tdc->papartment }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Sector</label>
                                <p class="form-control-static">{{ $request_tdc->psector }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">País</label>
                                <p class="form-control-static">{{ $request_tdc->pcountry }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Correo</label>
                                <p class="form-control-static">{{ $request_tdc->pmail }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Cerca de</label>
                                <p class="form-control-static">{{ $request_tdc->pnear }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Horario de Entrega</label>
                                <p class="form-control-static">{{ $request_tdc->pschedule }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Teléfono Residencial</label>
                                <p class="form-control-static">{{ $request_tdc->pphone_res }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Teléfono Celular</label>
                                <p class="form-control-static">{{ $request_tdc->pphone_cel }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Información Laboral</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Nombre Empresa</label>
                                <p class="form-control-static">{{ $request_tdc->businename }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Cargo que Ocupa</label>
                                <p class="form-control-static">{{ $request_tdc->position }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Tiempo Laboral</label>
                                <p class="form-control-static">{{ $request_tdc->workintime }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Ingresos Mensuales</label>
                                <p class="form-control-static">{{ number_format($request_tdc->montincome, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Otros Ingresos</label>
                                <p class="form-control-static">{{ number_format($request_tdc->otheincome, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dirección Laboral</h3>
                    @if ($request_tdc->senddirpla == 'laboral')
                        <span class="pull-right" style="margin-top: -19px;">
                            <span class="label label-success">Dirección de Entrega</span>
                        </span>
                    @endif
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Calle</label>
                                <p class="form-control-static">{{ $request_tdc->lstreet }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">No.</label>
                                <p class="form-control-static">{{ $request_tdc->lnum }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Edificio</label>
                                <p class="form-control-static">{{ $request_tdc->lbuilding }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Apartamento</label>
                                <p class="form-control-static">{{ $request_tdc->lapartment }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Sector</label>
                                <p class="form-control-static">{{ $request_tdc->lsector }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">País</label>
                                <p class="form-control-static">{{ $request_tdc->lcountry }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Correo</label>
                                <p class="form-control-static">{{ $request_tdc->lmail }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Cerca de</label>
                                <p class="form-control-static">{{ $request_tdc->lnear }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Horario de Entrega</label>
                                <p class="form-control-static">{{ $request_tdc->lschedule }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Teléfono Oficina</label>
                                <p class="form-control-static">{{ $request_tdc->lphone_off }}</p>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <div class="form-group">
                                <label class="control-label">Extensión</label>
                                <p class="form-control-static">{{ $request_tdc->lphone_ext }}</p>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <p class="form-control-static">{{ $request_tdc->lphone_fax }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Referencias Personales</h3>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Nombre y Apellido</label>
                                <p class="form-control-static">{{ $request_tdc->ref1names }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Teléfono Residencial</label>
                                <p class="form-control-static">{{ $request_tdc->ref1phores }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Teléfono Celular</label>
                                <p class="form-control-static">{{ $request_tdc->ref1phocel }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Nombre y Apellido</label>
                                <p class="form-control-static">{{ $request_tdc->ref2names }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Teléfono Residencial</label>
                                <p class="form-control-static">{{ $request_tdc->ref2phores }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Teléfono Celular</label>
                                <p class="form-control-static">{{ $request_tdc->ref2phocel }}</p>
                            </div>
                        </div>
                    </div>
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
