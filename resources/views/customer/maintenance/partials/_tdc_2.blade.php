<div class="col-xs-6">
    <div class="panel panel-default">

        <div class="panel-body text-center">
            <h1 class="text-center label label-warning" style="font-size: 30px;">ITC Dirección Estado Cuenta</h1>
        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Dirección de la TDC {{ $customer->actives_creditcards->get($tdc)->getMaskedNumber() }}</div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('country_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">País</label>
                        <select class="form-control input-sm" name="country_2_itc">
                            <option value="DOM|REPÚBLICA DOMINICANA" selected>REPÚBLICA DOMINICANA</option>
                        </select>
                        <span class="help-block">{{ $errors->first('country_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('region_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Región</label>
                        <select class="form-control input-sm" name="region_2_itc">
                            <option value="">Seleccione una región</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->getCode() }}|{{ trim($region->getDesc()) }}"{{ $region->getCode() == ($address_two ? $address_two->getRegion() : '') ? ' selected':'' }}>{{ $region->getDesc() }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('region_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('province_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Provincia</label>
                        <select class="form-control input-sm" name="province_2_itc">
                            @foreach ($provinces_2_itc as $province)
                                <option value="{{ $province->code }}|{{ trim($province->description) }}"{{ $province->code == $address_two->getProvince() ? ' selected':'' }}>{{ $province->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('province_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('city_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Ciudad</label>
                        <select class="form-control input-sm" name="city_2_itc">
                            @foreach ($cities_2_itc as $city)
                                <option value="{{ $city->code }}|{{ trim($city->description) }}"{{ $city->code == $address_two->getCity() ? ' selected':'' }}>{{ $city->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('city_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('municipality_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Municipio</label>
                        <select class="form-control input-sm" name="municipality_2_itc">
                            @foreach ($municipalities_2_itc as $municipality)
                                <option value="{{ $municipality->code }}|{{ trim($municipality->description) }}"{{ $municipality->code == $address_two->getMunicipality() ? ' selected':'' }}>{{ $municipality->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('municipality_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('sector_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Sector</label>
                        <select class="form-control input-sm" name="sector_2_itc">
                            @foreach ($sectors_2_itc as $sector)
                                <option value="{{ $sector->code }}|{{ trim($sector->description) }}"{{ $sector->code == $address_two->getSector() ? ' selected':'' }}>{{ $sector->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('sector_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('neighborhood_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Barrio</label>
                        <select class="form-control input-sm" name="neighborhood_2_itc">
                            @foreach ($neighborhoods_2_itc as $neighborhood)
                                <option value="{{ $neighborhood->code }}|{{ trim($neighborhood->description) }}"{{ $neighborhood->code == $address_two->getNeighborhood() ? ' selected':'' }}>{{ $neighborhood->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('neighborhood_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('street_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Calle</label>
                        <select class="form-control input-sm" name="street_2_itc">
                            @foreach ($streets_2_itc as $street)
                                <option value="{{ $street->code }}|{{ trim($street->description) }}"{{ $street->code == $address_two->getNeighborhood() ? ' selected':'' }}>{{ $street->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('street_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('building_name_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Nombre Edificio</label>
                        <input type="text" class="form-control input-sm" maxlength="30" name="building_name_2_itc" value="{{ old('building_name_2_itc') ? old('building_name_2_itc') : ($address_two ? $address_two->getBuildingName() : '') }}">
                        <span class="help-block">{{ $errors->first('building_name_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('block_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Manzana</label>
                        <input type="text" class="form-control input-sm" maxlength="10" name="block_2_itc" value="{{ old('block_2_itc') ? old('block_2_itc') : ($address_two ? $address_two->getBlock() : '') }}">
                        <span class="help-block">{{ $errors->first('block_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('house_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">No. Casa/Apartamento</label>
                        <input type="text" class="form-control input-sm" maxlength="10" name="house_number_2_itc" value="{{ old('house_number_2_itc') ? old('house_number_2_itc') : ($address_two ? $address_two->getHouseNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('house_number_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('km_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">KM</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="km_2_itc" value="{{ old('km_2_itc') ? old('km_2_itc') : ($address_two ? $address_two->getKm() : '') }}">
                        <span class="help-block">{{ $errors->first('km_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('postal_zone_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Zona Postal</label>
                        <input type="text" class="form-control input-sm" maxlength="10" name="postal_zone_2_itc" value="{{ old('postal_zone_2_itc') ? old('postal_zone_2_itc') : ($address_two ? $address_two->getPostalZone() : '') }}">
                        <span class="help-block">{{ $errors->first('postal_zone_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('postal_mail_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Apartado Postal</label>
                        <input type="text" class="form-control input-sm" maxlength="10" name="postal_mail_2_itc" value="{{ old('postal_mail_2_itc') ? old('postal_mail_2_itc') : ($address_two ? $address_two->getPostalMail() : '') }}">
                        <span class="help-block">{{ $errors->first('postal_mail_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('in_street_1_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Entre Cuales Calles 1</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="in_street_1_2_itc" value="{{ old('in_street_1_2_itc') ? old('in_street_1_2_itc') : ($address_two ? $address_two->getInStreet1() : '') }}">
                        <span class="help-block">{{ $errors->first('in_street_1_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('in_street_2_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Entre Cuales Calles 2</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="in_street_2_2_itc" value="{{ old('in_street_2_2_itc') ? old('in_street_2_2_itc') : ($address_two ? $address_two->getInStreet2() : '') }}">
                        <span class="help-block">{{ $errors->first('in_street_2_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('special_instruction_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Intrucción Especial</label>
                        <input type="text" class="form-control input-sm" maxlength="60" name="special_instruction_2_itc" value="{{ old('special_instruction_2_itc') ? old('special_instruction_2_itc') : ($address_two ? $address_two->getSpecialInstruction() : '') }}">
                        <span class="help-block">{{ $errors->first('special_instruction_2_itc') }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Contacto de la TDC {{ $customer->actives_creditcards->get($tdc)->getMaskedNumber() }}</div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('main_phone_area_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Principal Área</label>
                        <input type="text" class="form-control input-sm" maxlength="3" name="main_phone_area_2_itc" value="{{ old('main_phone_area_2_itc') ? old('main_phone_area_2_itc') : ($address_two ? $address_two->getMainPhoneArea() : '') }}">
                        <span class="help-block">{{ $errors->first('main_phone_area_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('main_phone_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Principal Núm.</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="main_phone_number_2_itc" value="{{ old('main_phone_number_2_itc') ? old('main_phone_number_2_itc') : ($address_two ? $address_two->getMainPhoneNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('main_phone_number_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('main_phone_ext_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Principal Ext.</label>
                        <input type="text" class="form-control input-sm" maxlength="4" name="main_phone_ext_2_itc" value="{{ old('main_phone_ext_2_itc') ? old('main_phone_ext_2_itc') : ($address_two ? $address_two->getMainPhoneExt() : '') }}">
                        <span class="help-block">{{ $errors->first('main_phone_ext_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('secundary_phone_area_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Secun. Área</label>
                        <input type="text" class="form-control input-sm" maxlength="3" name="secundary_phone_area_2_itc" value="{{ old('secundary_phone_area_2_itc') ? old('secundary_phone_area_2_itc') : ($address_two ? $address_two->getSecundaryPhoneArea() : '') }}">
                        <span class="help-block">{{ $errors->first('secundary_phone_area_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('secundary_phone_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Secun. Núm.</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="secundary_phone_number_2_itc" value="{{ old('secundary_phone_number_2_itc') ? old('secundary_phone_number_2_itc') : ($address_two ? $address_two->getSecundaryPhoneNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('secundary_phone_number_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group{{ $errors->first('secundary_phone_ext_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Secun. Ext.</label>
                        <input type="text" class="form-control input-sm" maxlength="4" name="secundary_phone_ext_2_itc" value="{{ old('secundary_phone_ext_2_itc') ? old('secundary_phone_ext_2_itc') : ($address_two ? $address_two->getSecundaryPhoneExt() : '') }}">
                        <span class="help-block">{{ $errors->first('secundary_phone_ext_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('main_cell_area_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Principal Área</label>
                        <input type="text" class="form-control input-sm" maxlength="3" name="main_cell_area_2_itc" value="{{ old('main_cell_area_2_itc') ? old('main_cell_area_2_itc') : ($address_two ? $address_two->getMainCellArea() : '') }}">
                        <span class="help-block">{{ $errors->first('main_cell_area_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('main_cell_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Principal Núm.</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="main_cell_number_2_itc" value="{{ old('main_cell_number_2_itc') ? old('main_cell_number_2_itc') : ($address_two ? $address_two->getMainCellNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('main_cell_number_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('secundary_cell_area_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Celular Secun. Área</label>
                        <input type="text" class="form-control input-sm" maxlength="3" name="secundary_cell_area_2_itc" value="{{ old('secundary_cell_area_2_itc') ? old('secundary_cell_area_2_itc') : ($address_two ? $address_two->getSecundaryCellArea() : '') }}">
                        <span class="help-block">{{ $errors->first('secundary_cell_area_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('secundary_cell_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Celular Secun. Núm.</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="secundary_cell_number_2_itc" value="{{ old('secundary_cell_number_2_itc') ? old('secundary_cell_number_2_itc') : ($address_two ? $address_two->getSecundaryCellNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('secundary_cell_number_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('fax_area_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Fax Área</label>
                        <input type="text" class="form-control input-sm" maxlength="3" name="fax_area_2_itc" value="{{ old('fax_area_2_itc') ? old('fax_area_2_itc') : ($address_two ? $address_two->getFaxArea() : '') }}">
                        <span class="help-block">{{ $errors->first('fax_area_2_itc') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('fax_number_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Fax Número</label>
                        <input type="text" class="form-control input-sm" maxlength="7" name="fax_number_2_itc" value="{{ old('fax_number_2_itc') ? old('fax_number_2_itc') : ($address_two ? $address_two->getFaxNumber() : '') }}">
                        <span class="help-block">{{ $errors->first('fax_number_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('mail_2_itc') ? ' has-error':'' }}">
                        <label class="control-label">Correo Electronico</label>
                        <input type="text" class="form-control input-sm" maxlength="50" name="mail_2_itc" value="{{ old('mail_2_itc') ? old('mail_2_itc') : ($address_two ? $address_two->getMail() : '') }}">
                        <span class="help-block">{{ $errors->first('mail_2_itc') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('ways_sending_statement_2_itc') ? ' has-error':'' }}">
                        <label class="control-label col-xs-12" style="padding-left: 0px;">Formas de Envio de Estados</label>
                        @foreach ($ways_sending_statements as $ways)
                            <div class="col-xs-4">
                                <label class="radio-inline">
                                    <input type="radio" name="ways_sending_statement_2_itc"{{ $address_two ? ($address_two->getWaySendingStatement() == $ways->getCode() ? ' checked':'') : '' }} value="{{ $ways->getCode() }}"> {{ trim($ways->getDescription()) }}
                                </label>
                            </div>
                        @endforeach
                        <span class="help-block">{{ $errors->first('ways_sending_statement_2_itc') }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
