@extends('layouts.master')

@section('title', 'Clientes - Solicitudes')

@section('page_title', 'Nueva Solicitud de Tarjetas')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    @if ($customer)
        <form method="post" action="{{ route('customer.request.tdc.store') }}" id="form">

            <div class="row">
                <div class="col-xs-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tarjeta Aprobada</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('product_type') ? ' has-error':'' }}">
                                        <label class="control-label">Producto</label>
                                        <select class="form-control input-sm" disabled name="">
                                            @foreach (get_tdc_products() as $key => $value)
                                                <option value="{{ $key }}"{{ $value == $customer->product ? ' selected':'' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('product_type') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('limit_rd') ? ' has-error':'' }}">
                                        <label class="control-label">Limite RD$</label>
                                        <input type="text" disabled class="form-control input-sm" name="limit_rd" value="{{ number_format($customer->limit_rd, 2)  }}">
                                        <span class="help-block">{{ $errors->first('limit_rd') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('limit_us') ? ' has-error':'' }}">
                                        <label class="control-label">Limite US$</label>
                                        <input type="text" disabled class="form-control input-sm" name="limit_us" value="{{ number_format($customer->limit_us, 2)  }}">
                                        <span class="help-block">{{ $errors->first('limit_us') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group{{ $errors->first('plastic_name') ? ' has-error':'' }}">
                                        <label class="control-label">Nombre Plástico</label>
                                        <input type="text" style="text-transform: uppercase;" maxlength="30" class="form-control input-sm" name="plastic_name" value="{{ old('plastic_name') }}">
                                        <span class="help-block">{{ $errors->first('plastic_name') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding: 6px 15px;background-color: #f0ad4e;">
                            <h3 class="panel-title">Teléfonos de Contacto</h3>
                        </div>

                        <div class="panel-body" style="padding: 0px 5px 0px 5px;">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 2px;">Celular</th>
                                        <th style="padding: 2px;">Casa</th>
                                        <th style="padding: 2px;">Trabajo</th>
                                        <th style="padding: 2px;">Otros</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer->phones_cel as $index => $value)
                                        <tr>
                                            <td style="padding: 2px;">{{ $customer->phones_cel[$index] }}</td>
                                            <td style="padding: 2px;">{{ $customer->phones_house[$index] }}</td>
                                            <td style="padding: 2px;">{{ $customer->phones_work[$index] }}</td>
                                            <td style="padding: 2px;">{{ $customer->phones_other[$index] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos Personales</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="form-group{{ $errors->first('names') ? ' has-error':'' }}">
                                        <label class="control-label">Nombres y Apellidos</label>
                                        <input type="text" disabled class="form-control input-sm" name="names" value="{{ utf8_encode($customer->names) }}">
                                        <span class="help-block">{{ $errors->first('names') }}</span>
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
                                    <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                        <label class="control-label">Identificación</label>
                                        <input type="text" disabled class="form-control input-sm" name="identification" value="{{ $customer->identification }}">
                                        <span class="help-block">{{ $errors->first('identification') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('birthdate') ? ' has-error':'' }}">
                                        <label class="control-label">Fecha Nacimiento</label>
                                        <input type="date" disabled class="form-control input-sm" name="birthdate" value="{{ $customer->birthdate }}">
                                        <span class="help-block">{{ $errors->first('birthdate') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('nationality') ? ' has-error':'' }}">
                                        <label class="control-label">Nacionalidad</label>
                                        <input type="text" disabled class="form-control input-sm" name="nationality" value="{{ $customer->nationality }}">
                                        <span class="help-block">{{ $errors->first('nationality') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('gender') ? ' has-error':'' }}">
                                        <label class="control-label">Género</label>
                                        <select name="gender" disabled class="form-control input-sm">
                                            <option value="f"{{ $customer->gender == 'f' ? ' selected':'' }}>Femenino</option>
                                            <option value="m"{{ $customer->gender == 'm' ? ' selected':'' }}>Masculino</option>
                                        </select>
                                        <span class="help-block">{{ $errors->first('gender') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('marital_status') ? ' has-error':'' }}">
                                        <label class="control-label">Estado Civil</label>
                                        <select name="marital_status" class="form-control input-sm">
                                            <option value="">Seleccione uno</option>
                                            @foreach (get_marital() as $key => $marital)
                                                <option value="{{ $key }}"{{ old('marital_status') == $key ? ' selected':'' }}>{{ $marital }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('marital_status') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($accept == null)
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="{{ route('customer.request.tdc.create', array_merge(Request::all(), ['accept' => 'yes'])) }}" class="btn btn-sm btn-success btn-block">Aceptó</a>
                            <a href="{{ route('customer.request.tdc.create', array_merge(Request::all(), ['accept' => 'no'])) }}" class="btn btn-sm btn-danger btn-block">Rechazó</a>
                        </div>
                    </div>
                </div>
            @endif

            @if ($accept == 'yes')
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dirección Personal</h3>
                                <span class="pull-right" style="margin-top: -20px;">
                                    Recibir plástico aquí
                                    <input type="radio" name="send_dir_plastic" checked value="personal">
                                </span>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pstreet') ? ' has-error':'' }}">
                                            <label class="control-label">Calle</label>
                                            <input type="text" class="form-control input-sm" name="pstreet" value="{{ old('pstreet') }}">
                                            <span class="help-block">{{ $errors->first('pstreet') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pnum') ? ' has-error':'' }}">
                                            <label class="control-label">No.</label>
                                            <input type="text" class="form-control input-sm" name="pnum" value="{{ old('pnum') }}">
                                            <span class="help-block">{{ $errors->first('pnum') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pbuilding') ? ' has-error':'' }}">
                                            <label class="control-label">Edificio</label>
                                            <input type="text" class="form-control input-sm" name="pbuilding" value="{{ old('pbuilding') }}">
                                            <span class="help-block">{{ $errors->first('pbuilding') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('papartment') ? ' has-error':'' }}">
                                            <label class="control-label">Apartamento</label>
                                            <input type="text" class="form-control input-sm" name="papartment" value="{{ old('papartment') }}">
                                            <span class="help-block">{{ $errors->first('papartment') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('psector') ? ' has-error':'' }}">
                                            <label class="control-label">Sector</label>
                                            <input type="text" class="form-control input-sm" name="psector" value="{{ old('psector') }}">
                                            <span class="help-block">{{ $errors->first('psector') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pcountry') ? ' has-error':'' }}">
                                            <label class="control-label">País</label>
                                            <input type="text" disabled class="form-control input-sm" name="pcountry" value="República Dominicana">
                                            <span class="help-block">{{ $errors->first('pcountry') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group{{ $errors->first('pmail') ? ' has-error':'' }}">
                                            <label class="control-label">Correo</label>
                                            <input type="text" class="form-control input-sm" name="pmail" value="{{ old('pmail') }}">
                                            <span class="help-block">{{ $errors->first('pmail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group{{ $errors->first('pnear') ? ' has-error':'' }}">
                                            <label class="control-label">Cerca de</label>
                                            <input type="text" class="form-control input-sm" name="pnear" value="{{ old('pnear') }}">
                                            <span class="help-block">{{ $errors->first('pnear') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pschedule') ? ' has-error':'' }}">
                                            <label class="control-label">Horario de Entrega</label>
                                            <input type="text" class="form-control input-sm" name="pschedule" value="{{ old('pschedule') }}">
                                            <span class="help-block">{{ $errors->first('pschedule') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pphone_res') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono <abbr title="Residencial">Res</abbr></label>
                                            <select class="" name="parea_code_res">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('parea_code_res') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="pphone_res" value="{{ old('pphone_res') }}">
                                            <span class="help-block">{{ $errors->first('pphone_res') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('pphone_cel') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Celular</label>
                                            <select class="" name="parea_code_cel">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('parea_code_cel') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="pphone_cel" value="{{ old('pphone_cel') }}">
                                            <span class="help-block">{{ $errors->first('pphone_cel') }}</span>
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
                                <h3 class="panel-title">Información Laboral</h3>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="form-group{{ $errors->first('business_name') ? ' has-error':'' }}">
                                            <label class="control-label">Nombre Empresa</label>
                                            <input type="text" class="form-control input-sm" name="business_name" value="{{ old('business_name') }}">
                                            <span class="help-block">{{ $errors->first('business_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group{{ $errors->first('position') ? ' has-error':'' }}">
                                            <label class="control-label">Cargo que Ocupa</label>
                                            <input type="text" class="form-control input-sm" name="position" value="{{ old('position') }}">
                                            <span class="help-block">{{ $errors->first('position') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('working_time') ? ' has-error':'' }}">
                                            <label class="control-label">Tiempo Laboral</label>
                                            <input type="text" class="form-control input-sm" name="working_time" value="{{ old('working_time') }}">
                                            <span class="help-block">{{ $errors->first('working_time') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('monthly_income') ? ' has-error':'' }}">
                                            <label class="control-label">Ingresos Mensuales</label>
                                            <input type="text" class="form-control input-sm text-right" name="monthly_income" value="{{ old('monthly_income') }}">
                                            <span class="help-block">{{ $errors->first('monthly_income') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('others_income') ? ' has-error':'' }}">
                                            <label class="control-label">Otros Ingresos</label>
                                            <input type="text" class="form-control input-sm text-right" name="others_income" value="{{ old('others_income') }}">
                                            <span class="help-block">{{ $errors->first('others_income') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

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
                                <span class="pull-right" style="margin-top: -20px;">
                                    Recibir plástico aquí
                                    <input type="radio" name="send_dir_plastic" value="laboral">
                                </span>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lstreet') ? ' has-error':'' }}">
                                            <label class="control-label">Calle</label>
                                            <input type="text" class="form-control input-sm" name="lstreet" value="{{ old('lstreet') }}">
                                            <span class="help-block">{{ $errors->first('lstreet') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lnum') ? ' has-error':'' }}">
                                            <label class="control-label">No.</label>
                                            <input type="text" class="form-control input-sm" name="lnum" value="{{ old('lnum') }}">
                                            <span class="help-block">{{ $errors->first('lnum') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lbuilding') ? ' has-error':'' }}">
                                            <label class="control-label">Edificio</label>
                                            <input type="text" class="form-control input-sm" name="lbuilding" value="{{ old('lbuilding') }}">
                                            <span class="help-block">{{ $errors->first('lbuilding') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lapartment') ? ' has-error':'' }}">
                                            <label class="control-label">Apartamento</label>
                                            <input type="text" class="form-control input-sm" name="lapartment" value="{{ old('lapartment') }}">
                                            <span class="help-block">{{ $errors->first('lapartment') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lsector') ? ' has-error':'' }}">
                                            <label class="control-label">Sector</label>
                                            <input type="text" class="form-control input-sm" name="lsector" value="{{ old('lsector') }}">
                                            <span class="help-block">{{ $errors->first('lsector') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lcountry') ? ' has-error':'' }}">
                                            <label class="control-label">País</label>
                                            <input type="text" disabled class="form-control input-sm" name="lcountry" value="República Dominicana">
                                            <span class="help-block">{{ $errors->first('lcountry') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lmail') ? ' has-error':'' }}">
                                            <label class="control-label">Correo</label>
                                            <input type="text" class="form-control input-sm" name="lmail" value="{{ old('lmail') }}">
                                            <span class="help-block">{{ $errors->first('lmail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lnear') ? ' has-error':'' }}">
                                            <label class="control-label">Cerca de</label>
                                            <input type="text" class="form-control input-sm" name="lnear" value="{{ old('lnear') }}">
                                            <span class="help-block">{{ $errors->first('lnear') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lschedule') ? ' has-error':'' }}">
                                            <label class="control-label">Horario de Entrega</label>
                                            <input type="text" class="form-control input-sm" name="lschedule" value="{{ old('lschedule') }}">
                                            <span class="help-block">{{ $errors->first('lschedule') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lphone_off') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Oficina</label>
                                            <select class="" name="larea_code_off">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('larea_code_off') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="lphone_off" value="{{ old('lphone_off') }}">
                                            <span class="help-block">{{ $errors->first('lphone_off') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lphone_ext') ? ' has-error':'' }}">
                                            <label class="control-label">Extensión</label>
                                            <input type="text" class="form-control input-sm" name="lphone_ext" value="{{ old('lphone_ext') }}">
                                            <span class="help-block">{{ $errors->first('lphone_ext') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group{{ $errors->first('lphone_fax') ? ' has-error':'' }}">
                                            <label class="control-label">Fax</label>
                                            <input type="text" class="form-control input-sm" name="lphone_fax" value="{{ old('lphone_fax') }}">
                                            <span class="help-block">{{ $errors->first('lphone_fax') }}</span>
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
                                <h3 class="panel-title">Referencias Personales</h3>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_1_name') ? ' has-error':'' }}">
                                            <label class="control-label">Nombre y Apellido</label>
                                            <input type="text" class="form-control input-sm" name="ref_1_name" value="{{ old('ref_1_name') }}">
                                            <span class="help-block">{{ $errors->first('ref_1_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_1_phone_res') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Residencial</label>
                                            <select class="" name="area_code_ref1_res">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('area_code_ref1_res') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="ref_1_phone_res" value="{{ old('ref_1_phone_res') }}">
                                            <span class="help-block">{{ $errors->first('ref_1_phone_res') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_1_phone_cel') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Celular</label>
                                            <select class="" name="area_code_ref1_cel">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('area_code_ref1_cel') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="ref_1_phone_cel" value="{{ old('ref_1_phone_cel') }}">
                                            <span class="help-block">{{ $errors->first('ref_1_phone_cel') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_2_name') ? ' has-error':'' }}">
                                            <label class="control-label">Nombre y Apellido</label>
                                            <input type="text" class="form-control input-sm" name="ref_2_name" value="{{ old('ref_2_name') }}">
                                            <span class="help-block">{{ $errors->first('ref_2_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_2_phone_res') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Residencial</label>
                                            <select class="" name="area_code_ref2_res">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('area_code_ref2_res') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="ref_2_phone_res" value="{{ old('ref_2_phone_res') }}">
                                            <span class="help-block">{{ $errors->first('ref_2_phone_res') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group{{ $errors->first('ref_2_phone_cel') ? ' has-error':'' }}">
                                            <label class="control-label">Teléfono Celular</label>
                                            <select class="" name="area_code_ref2_cel">
                                                @foreach (get_area_codes() as $code)
                                                    <option value="{{ $code }}"{{ old('area_code_ref2_cel') == $code ? ' selected':'' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control input-sm" name="ref_2_phone_cel" value="{{ old('ref_2_phone_cel') }}">
                                            <span class="help-block">{{ $errors->first('ref_2_phone_cel') }}</span>
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
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-6 col-xs-offset-3">
                                        {{ csrf_field() }}
                                        <a class="btn btn-info btn-xs" href="{{ route('customer.request.tdc.create') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </form>

        @if ($accept == 'no')
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <form method="post" action="{{ route('customer.request.tdc.located', request('identification')) }}" id="form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Razón de Negación</h3>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('denail') ? ' has-error':'' }}">
                                            <select class="form-control input-sm" name="denail">
                                                @foreach ($denails as $denail)
                                                    <option value="{{ $denail->id }}">{{ $denail->note }}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">{{ $errors->first('denail') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        {{ csrf_field() }}
                                        <a class="btn btn-info btn-xs" href="{{ route('customer.request.tdc.create') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.request.tdc.create') }}" id="form">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                        <label class="control-label">Cédula/Pasaporte</label>
                                        <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
                                        <span class="help-block">{{ $errors->first('identification') }}</span>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.request.tdc.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando...">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
