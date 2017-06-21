@extends('layouts.master')

@section('title', 'Clientes - Mantenimiento')

@if (session()->has('customer_maintenance'))
    @section('page_title', 'Mantenimiento a ' . $customer->getName() . ' ( ' . $customer->getCode() . ' )')
@else
    @section('page_title', 'Nuevo Mantenimiento')
@endif

{{-- @if (can_not_do('customer_maintenance'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    @if (session()->has('customer_maintenance'))

        @if ($core == 'itc')

            <div class="row">
                <div class="col-xs-4 col-xs-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="get" action="{{ route('customer.maintenance.create', Request::all()) }}">
                                @foreach (Request::except('_token') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('tdc') ? ' has-error':'' }}">
                                            <label class="control-label">Tarjetas</label>
                                            <select class="form-control input-sm" name="tdc" data-toggle="tooltip" title="Tarjetas de Credito">
                                                @foreach ($customer->creditcards as $key => $creditcard)
                                                    <option type="tdc" value="{{ $key }}" {{ $tdc == $key ? 'selected':'' }}>Tarjeta ( {{ $creditcard->getMaskedNumber() }} )</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">{{ $errors->first('tdc') }}</span>
                                        </div>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando...">Buscar Dirección</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <form method="post" action="{{ route('customer.maintenance.store') }}" id="form">

            <div class="row">
                @if ($core == 'ibs')

                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <h1 class="text-center label label-primary" style="font-size: 40px;padding: 2px 206px;">IBS</h1>
                            </div>

                            <div class="panel-body">
                                <div class="row text-center" style="margin-bottom: 5px;">
                                    <div class="label label-default" style="font-size: 16px;">Dirección</div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('street_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Calle</label>
                                        <input type="text" class="form-control input-sm" name="street_ibs" value="{{ old('street_ibs') ? old('street_ibs') : $customer->getStreet() }}">
                                        <span class="help-block">{{ $errors->first('street_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('building_house_number_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">No. de Casa / Apartamento</label>
                                        <input type="text" class="form-control input-sm" name="building_house_number_ibs" value="{{ old('building_house_number_ibs') ? old('building_house_number_ibs') : $customer->getBuildingOrHouseNumber() }}">
                                        <span class="help-block">{{ $errors->first('building_house_number_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('province_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Provincia</label>
                                        <input type="text" class="form-control input-sm" name="province_ibs" value="{{ old('province_ibs') ? old('province_ibs') : $customer->getProvince() }}">
                                        <span class="help-block">{{ $errors->first('province_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('city_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Ciudad</label>
                                        <input type="text" class="form-control input-sm" name="city_ibs" value="{{ old('city_ibs') ? old('city_ibs') : $customer->getCity() }}">
                                        <span class="help-block">{{ $errors->first('city_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('sector_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Sector</label>
                                        <input type="text" class="form-control input-sm" name="sector_ibs" value="{{ old('sector_ibs') ? old('sector_ibs') : $customer->getSector() }}">
                                        <span class="help-block">{{ $errors->first('sector_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('country_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">País</label>
                                        <input type="text" class="form-control input-sm" name="country_ibs" value="{{ old('country_ibs') ? old('country_ibs') : $customer->getCountry() }}">
                                        <span class="help-block">{{ $errors->first('country_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('postal_mail_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Apartado Postal</label>
                                        <input type="text" class="form-control input-sm" name="postal_mail_ibs" value="{{ old('postal_mail_ibs') ? old('postal_mail_ibs') : $customer->getPostalMail() }}">
                                        <span class="help-block">{{ $errors->first('postal_mail_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('zip_code_ibs') ? ' has-error':'' }}">
                                      <label class="control-label">Código Postal</label>
                                      <input type="text" class="form-control input-sm" name="zip_code_ibs" value="{{ old('zip_code_ibs') ? old('zip_code_ibs') : $customer->getZipCode() }}">
                                      <span class="help-block">{{ $errors->first('zip_code_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('mail_type_ibs') ? ' has-error':'' }}">
                                      <label class="control-label">Tipo de Correo</label>
                                      <input type="text" class="form-control input-sm" name="mail_type_ibs" value="{{ old('mail_type_ibs') ? old('mail_type_ibs') : $customer->getMailType() }}">
                                      <span class="help-block">{{ $errors->first('mail_type_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('mail_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Correo</label>
                                        <input type="text" class="form-control input-sm" name="mail_ibs" value="{{ old('mail_ibs') ? old('mail_ibs') : $customer->getMail() }}">
                                        <span class="help-block">{{ $errors->first('mail_ibs') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row text-center" style="margin-bottom: 5px;">
                                    <div class="label label-default" style="font-size: 16px;">Contacto</div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('house_phone_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Casa</label>
                                        <input type="text" class="form-control input-sm" name="house_phone_ibs" value="{{ old('house_phone_ibs') ? old('house_phone_ibs') : $customer->getResidentialPhone() }}">
                                        <span class="help-block">{{ $errors->first('house_phone_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('office_phone_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Oficina</label>
                                        <input type="text" class="form-control input-sm" name="office_phone_ibs" value="{{ old('office_phone_ibs') ? old('office_phone_ibs') : $customer->getOfficePhone() }}">
                                        <span class="help-block">{{ $errors->first('office_phone_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('fax_phone_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Fax</label>
                                        <input type="text" class="form-control input-sm" name="fax_phone_ibs" value="{{ old('fax_phone_ibs') ? old('fax_phone_ibs') : $customer->getFaxPhone() }}">
                                        <span class="help-block">{{ $errors->first('fax_phone_ibs') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('movil_phone_ibs') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Celular</label>
                                        <input type="text" class="form-control input-sm" name="movil_phone_ibs" value="{{ old('movil_phone_ibs') ? old('movil_phone_ibs') : $customer->getCellPhone() }}">
                                        <span class="help-block">{{ $errors->first('movil_phone_ibs') }}</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                @endif

                @if ($core == 'itc')

                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <h1 class="text-center label label-warning" style="font-size: 40px;padding: 2px 206px;">ITC</h1>
                            </div>

                            <div class="panel-body">
                                <div class="row text-center" style="margin-bottom: 5px;">
                                    <div class="label label-default" style="font-size: 16px;">Dirección de la TDC {{ $customer->creditcards->get($tdc)->getMaskedNumber() }}</div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('country_itc') ? ' has-error':'' }}">
                                        <label class="control-label">País</label>
                                        <select class="form-control input-sm" name="country_itc">
                                            <option value="DOM" selected>REPÚBLICA DOMINICANA</option>
                                        </select>
                                        <span class="help-block">{{ $errors->first('country_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('region_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Región</label>
                                        <select class="form-control input-sm" name="region_itc">
                                            <option value="">Seleccione una región</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->getCode() }}">{{ $region->getDesc() }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('region_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('province_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Provincia</label>
                                        <select class="form-control input-sm" name="province_itc"></select>
                                        <span class="help-block">{{ $errors->first('province_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('city_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Ciudad</label>
                                        <select class="form-control input-sm" name="city_itc"></select>
                                        <span class="help-block">{{ $errors->first('city_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('municipality_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Municipio</label>
                                        <select class="form-control input-sm" name="municipality_itc"></select>
                                        <span class="help-block">{{ $errors->first('municipality_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('sector_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Sector</label>
                                        <select class="form-control input-sm" name="sector_itc"></select>
                                        <span class="help-block">{{ $errors->first('sector_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('neighborhood_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Barrio</label>
                                        <select class="form-control input-sm" name="neighborhood_itc"></select>
                                        <span class="help-block">{{ $errors->first('neighborhood_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('street_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Calle</label>
                                        <select class="form-control input-sm" name="street_itc"></select>
                                        <span class="help-block">{{ $errors->first('street_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('building_name_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Nombre Edificio</label>
                                        <input type="text" class="form-control input-sm" name="building_name_itc" value="{{ old('building_name_itc') ? old('building_name_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getBuildingName() : '') }}">
                                        <span class="help-block">{{ $errors->first('building_name_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('block_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Manzana</label>
                                        <input type="text" class="form-control input-sm" name="block_itc" value="{{ old('block_itc') ? old('block_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getBlock() : '') }}">
                                        <span class="help-block">{{ $errors->first('block_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('house_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">No. Casa/Apartamento</label>
                                        <input type="text" class="form-control input-sm" name="house_number_itc" value="{{ old('house_number_itc') ? old('house_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getHouseNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('house_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('km_itc') ? ' has-error':'' }}">
                                        <label class="control-label">KM</label>
                                        <input type="text" class="form-control input-sm" name="km_itc" value="{{ old('km_itc') ? old('km_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getHouseNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('km_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('postal_zone_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Zona Postal</label>
                                        <input type="text" class="form-control input-sm" name="postal_zone_itc" value="{{ old('postal_zone_itc') ? old('postal_zone_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getPostalZone() : '') }}">
                                        <span class="help-block">{{ $errors->first('postal_zone_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('postal_mail_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Apartado Postal</label>
                                        <input type="text" class="form-control input-sm" name="postal_mail_itc" value="{{ old('postal_mail_itc') ? old('postal_mail_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getPostalMail() : '') }}">
                                        <span class="help-block">{{ $errors->first('postal_mail_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('in_street_1_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Entre Cuales Calles 1</label>
                                        <input type="text" class="form-control input-sm" name="in_street_1_itc" value="{{ old('in_street_1_itc') ? old('in_street_1_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getInStreet1() : '') }}">
                                        <span class="help-block">{{ $errors->first('in_street_1_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('in_street_2_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Entre Cuales Calles 2</label>
                                        <input type="text" class="form-control input-sm" name="in_street_2_itc" value="{{ old('in_street_2_itc') ? old('in_street_2_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getInStreet2() : '') }}">
                                        <span class="help-block">{{ $errors->first('in_street_2_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('special_instruction_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Intrucción Especial</label>
                                        <input type="text" class="form-control input-sm" name="special_instruction_itc" value="{{ old('special_instruction_itc') ? old('special_instruction_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSpecialInstruction() : '') }}">
                                        <span class="help-block">{{ $errors->first('special_instruction_itc') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="panel-body">
                                <div class="row text-center" style="margin-bottom: 5px;">
                                    <div class="label label-default" style="font-size: 16px;">Contacto de la TDC {{ $customer->creditcards->get($tdc)->getMaskedNumber() }}</div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('main_phone_area_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Principal Área</label>
                                        <input type="text" class="form-control input-sm" name="main_phone_area_itc" value="{{ old('main_phone_area_itc') ? old('main_phone_area_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneArea() : '') }}">
                                        <span class="help-block">{{ $errors->first('main_phone_area_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('main_phone_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Principal Núm.</label>
                                        <input type="text" class="form-control input-sm" name="main_phone_number_itc" value="{{ old('main_phone_number_itc') ? old('main_phone_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('main_phone_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('main_phone_ext_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Principal Ext.</label>
                                        <input type="text" class="form-control input-sm" name="main_phone_ext_itc" value="{{ old('main_phone_ext_itc') ? old('main_phone_ext_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneExt() : '') }}">
                                        <span class="help-block">{{ $errors->first('main_phone_ext_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('secundary_phone_area_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Secun. Área</label>
                                        <input type="text" class="form-control input-sm" name="secundary_phone_area_itc" value="{{ old('secundary_phone_area_itc') ? old('secundary_phone_area_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneArea() : '') }}">
                                        <span class="help-block">{{ $errors->first('secundary_phone_area_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('secundary_phone_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Secun. Núm.</label>
                                        <input type="text" class="form-control input-sm" name="secundary_phone_number_itc" value="{{ old('secundary_phone_number_itc') ? old('secundary_phone_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('secundary_phone_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('secundary_phone_ext_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Secun. Ext.</label>
                                        <input type="text" class="form-control input-sm" name="secundary_phone_ext_itc" value="{{ old('secundary_phone_ext_itc') ? old('secundary_phone_ext_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainPhoneExt() : '') }}">
                                        <span class="help-block">{{ $errors->first('secundary_phone_ext_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('main_cell_area_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Principal Área</label>
                                        <input type="text" class="form-control input-sm" name="main_cell_area_itc" value="{{ old('main_cell_area_itc') ? old('main_cell_area_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainCellArea() : '') }}">
                                        <span class="help-block">{{ $errors->first('main_cell_area_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('main_cell_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Teléfono Principal Núm.</label>
                                        <input type="text" class="form-control input-sm" name="main_cell_number_itc" value="{{ old('main_cell_number_itc') ? old('main_cell_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getMainCellNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('main_cell_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('secundary_cell_area_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Celular Secun. Área</label>
                                        <input type="text" class="form-control input-sm" name="secundary_cell_area_itc" value="{{ old('secundary_cell_area_itc') ? old('secundary_cell_area_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSecundaryCellArea() : '') }}">
                                        <span class="help-block">{{ $errors->first('secundary_cell_area_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('secundary_cell_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Celular Secun. Núm.</label>
                                        <input type="text" class="form-control input-sm" name="secundary_cell_number_itc" value="{{ old('secundary_cell_number_itc') ? old('secundary_cell_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSecundaryCellNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('secundary_cell_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('fax_area_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Fax Área</label>
                                        <input type="text" class="form-control input-sm" name="fax_area_itc" value="{{ old('fax_area_itc') ? old('fax_area_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSecundaryCellArea() : '') }}">
                                        <span class="help-block">{{ $errors->first('fax_area_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('fax_number_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Fax Número</label>
                                        <input type="text" class="form-control input-sm" name="fax_number_itc" value="{{ old('fax_number_itc') ? old('fax_number_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSecundaryCellNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('fax_number_itc') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('mail_itc') ? ' has-error':'' }}">
                                        <label class="control-label">Correo Electronico</label>
                                        <input type="text" class="form-control input-sm" name="mail_itc" value="{{ old('mail_itc') ? old('mail_itc') : ($customer->creditcards->get($tdc)->address ? $customer->creditcards->get($tdc)->address->getSecundaryCellNumber() : '') }}">
                                        <span class="help-block">{{ $errors->first('mail_itc') }}</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                @endif

                <div class="col-xs-4 col-xs-offset-4">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <a class="btn btn-info btn-xs" href="{{ route('customer.maintenance.create', ['cancel' => 'true']) }}">Cancelar</a>
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    @else

        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.maintenance.create') }}" id="form">
                            <input type="hidden" name="tdc" value="0">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                        <label class="control-label">Cédula/Pasaporte/RNC</label>
                                        <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
                                        <span class="help-block">{{ $errors->first('identification') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="radio{{ $errors->first('core') ? ' has-error':'' }}">
                                        <label style="margin-top: 18px;">
                                            <input type="radio" name="core" value="ibs" {{ old('core') == 'ibs' ? 'checked' : '' }}> IBS
                                        </label>
                                        <label style="margin-top: 18px;margin-left: 20px;">
                                            <input type="radio" name="core" value="itc" {{ old('core') == 'itc' ? 'checked' : '' }}> ITC
                                        </label>
                                        <span class="help-block">{{ $errors->first('core') }}</span>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            {{-- <a class="btn btn-info btn-xs" href="{{ route('customer.maintenance.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a> --}}
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

        var url = '{{ route('customer.maintenance.load') }}';

        var country = $('select[name=country_itc]');
        var region = $('select[name=region_itc]');
        var province = $('select[name=province_itc]');
        var city = $('select[name=city_itc]');
        var municipality = $('select[name=municipality_itc]');
        var sector = $('select[name=sector_itc]');
        var neighborhood = $('select[name=neighborhood_itc]');
        var street = $('select[name=street_itc]');

        region.change(function () {
            province.html('');
            city.html('');
            municipality.html('');
            sector.html('');
            neighborhood.html('');
            street.html('');

            if (region.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'province',
                country: country.val(),
                region: region.val(),
            },function (response) {
                province.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    province.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });

        province.change(function () {
            city.html('');
            municipality.html('');
            sector.html('');
            neighborhood.html('');
            street.html('');

            if (province.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'city',
                country: country.val(),
                region: region.val(),
                province: province.val(),
            },function (response) {
                city.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    city.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });

        city.change(function () {
            municipality.html('');
            sector.html('');
            neighborhood.html('');
            street.html('');

            if (city.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'municipality',
                country: country.val(),
                region: region.val(),
                province: province.val(),
                city: city.val(),
            },function (response) {
                municipality.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    municipality.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });

        municipality.change(function () {
            sector.html('');
            neighborhood.html('');
            street.html('');

            if (municipality.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'sector',
                country: country.val(),
                region: region.val(),
                province: province.val(),
                city: city.val(),
                municipality: municipality.val(),
            },function (response) {
                sector.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    sector.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });

        sector.change(function () {
            neighborhood.html('');
            street.html('');

            if (sector.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'neighborhood',
                country: country.val(),
                region: region.val(),
                province: province.val(),
                city: city.val(),
                municipality: municipality.val(),
                sector: sector.val(),
            },function (response) {
                neighborhood.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    neighborhood.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });

        neighborhood.change(function () {
            street.html('');

            if (neighborhood.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'street',
                country: country.val(),
                region: region.val(),
                province: province.val(),
                city: city.val(),
                municipality: municipality.val(),
                sector: sector.val(),
                neighborhood: neighborhood.val(),
            },function (response) {
                $.each(response, function (index, item) {
                    street.append($('<option>', {
                        value: item.code,
                        text: item.description
                    }));
                });
            });
        });
    </script>

@endsection
