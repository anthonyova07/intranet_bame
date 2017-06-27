<div class="col-xs-6">
    <div class="panel panel-default">

        <div class="panel-body">
            <h1 class="text-center label label-warning" style="font-size: 30px;padding: 2px 72px;">ITC Dirección Residencia</h1>
        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Dirección de la TDC {{ $customer->actives_creditcards->get($tdc)->getMaskedNumber() }}</div>
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
                    <input type="text" class="form-control input-sm" maxlength="30" name="building_name_itc" value="{{ old('building_name_itc') ? old('building_name_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getBuildingName() : '') }}">
                    <span class="help-block">{{ $errors->first('building_name_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('block_itc') ? ' has-error':'' }}">
                    <label class="control-label">Manzana</label>
                    <input type="text" class="form-control input-sm" maxlength="10" name="block_itc" value="{{ old('block_itc') ? old('block_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getBlock() : '') }}">
                    <span class="help-block">{{ $errors->first('block_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('house_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">No. Casa/Apartamento</label>
                    <input type="text" class="form-control input-sm" maxlength="10" name="house_number_itc" value="{{ old('house_number_itc') ? old('house_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getHouseNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('house_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('km_itc') ? ' has-error':'' }}">
                    <label class="control-label">KM</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="km_itc" value="{{ old('km_itc') ? old('km_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getKm() : '') }}">
                    <span class="help-block">{{ $errors->first('km_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('postal_zone_itc') ? ' has-error':'' }}">
                    <label class="control-label">Zona Postal</label>
                    <input type="text" class="form-control input-sm" maxlength="10" name="postal_zone_itc" value="{{ old('postal_zone_itc') ? old('postal_zone_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getPostalZone() : '') }}">
                    <span class="help-block">{{ $errors->first('postal_zone_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('postal_mail_itc') ? ' has-error':'' }}">
                    <label class="control-label">Apartado Postal</label>
                    <input type="text" class="form-control input-sm" maxlength="10" name="postal_mail_itc" value="{{ old('postal_mail_itc') ? old('postal_mail_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getPostalMail() : '') }}">
                    <span class="help-block">{{ $errors->first('postal_mail_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('in_street_1_itc') ? ' has-error':'' }}">
                    <label class="control-label">Entre Cuales Calles 1</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="in_street_1_itc" value="{{ old('in_street_1_itc') ? old('in_street_1_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getInStreet1() : '') }}">
                    <span class="help-block">{{ $errors->first('in_street_1_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('in_street_2_itc') ? ' has-error':'' }}">
                    <label class="control-label">Entre Cuales Calles 2</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="in_street_2_itc" value="{{ old('in_street_2_itc') ? old('in_street_2_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getInStreet2() : '') }}">
                    <span class="help-block">{{ $errors->first('in_street_2_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group{{ $errors->first('special_instruction_itc') ? ' has-error':'' }}">
                    <label class="control-label">Intrucción Especial</label>
                    <input type="text" class="form-control input-sm" maxlength="60" name="special_instruction_itc" value="{{ old('special_instruction_itc') ? old('special_instruction_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSpecialInstruction() : '') }}">
                    <span class="help-block">{{ $errors->first('special_instruction_itc') }}</span>
                </div>
            </div>

        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Contacto de la TDC {{ $customer->actives_creditcards->get($tdc)->getMaskedNumber() }}</div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('main_phone_area_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Principal Área</label>
                    <input type="text" class="form-control input-sm" maxlength="3" name="main_phone_area_itc" value="{{ old('main_phone_area_itc') ? old('main_phone_area_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMainPhoneArea() : '') }}">
                    <span class="help-block">{{ $errors->first('main_phone_area_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('main_phone_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Principal Núm.</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="main_phone_number_itc" value="{{ old('main_phone_number_itc') ? old('main_phone_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMainPhoneNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('main_phone_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('main_phone_ext_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Principal Ext.</label>
                    <input type="text" class="form-control input-sm" maxlength="4" name="main_phone_ext_itc" value="{{ old('main_phone_ext_itc') ? old('main_phone_ext_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMainPhoneExt() : '') }}">
                    <span class="help-block">{{ $errors->first('main_phone_ext_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('secundary_phone_area_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Secun. Área</label>
                    <input type="text" class="form-control input-sm" maxlength="3" name="secundary_phone_area_itc" value="{{ old('secundary_phone_area_itc') ? old('secundary_phone_area_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSecundaryPhoneArea() : '') }}">
                    <span class="help-block">{{ $errors->first('secundary_phone_area_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('secundary_phone_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Secun. Núm.</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="secundary_phone_number_itc" value="{{ old('secundary_phone_number_itc') ? old('secundary_phone_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSecundaryPhoneNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('secundary_phone_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group{{ $errors->first('secundary_phone_ext_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Secun. Ext.</label>
                    <input type="text" class="form-control input-sm" maxlength="4" name="secundary_phone_ext_itc" value="{{ old('secundary_phone_ext_itc') ? old('secundary_phone_ext_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSecundaryPhoneExt() : '') }}">
                    <span class="help-block">{{ $errors->first('secundary_phone_ext_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('main_cell_area_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Principal Área</label>
                    <input type="text" class="form-control input-sm" maxlength="3" name="main_cell_area_itc" value="{{ old('main_cell_area_itc') ? old('main_cell_area_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMainCellArea() : '') }}">
                    <span class="help-block">{{ $errors->first('main_cell_area_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('main_cell_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">Teléfono Principal Núm.</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="main_cell_number_itc" value="{{ old('main_cell_number_itc') ? old('main_cell_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMainCellNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('main_cell_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('secundary_cell_area_itc') ? ' has-error':'' }}">
                    <label class="control-label">Celular Secun. Área</label>
                    <input type="text" class="form-control input-sm" maxlength="3" name="secundary_cell_area_itc" value="{{ old('secundary_cell_area_itc') ? old('secundary_cell_area_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSecundaryCellArea() : '') }}">
                    <span class="help-block">{{ $errors->first('secundary_cell_area_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('secundary_cell_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">Celular Secun. Núm.</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="secundary_cell_number_itc" value="{{ old('secundary_cell_number_itc') ? old('secundary_cell_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getSecundaryCellNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('secundary_cell_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('fax_area_itc') ? ' has-error':'' }}">
                    <label class="control-label">Fax Área</label>
                    <input type="text" class="form-control input-sm" maxlength="3" name="fax_area_itc" value="{{ old('fax_area_itc') ? old('fax_area_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getFaxArea() : '') }}">
                    <span class="help-block">{{ $errors->first('fax_area_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->first('fax_number_itc') ? ' has-error':'' }}">
                    <label class="control-label">Fax Número</label>
                    <input type="text" class="form-control input-sm" maxlength="7" name="fax_number_itc" value="{{ old('fax_number_itc') ? old('fax_number_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getFaxNumber() : '') }}">
                    <span class="help-block">{{ $errors->first('fax_number_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group{{ $errors->first('mail_itc') ? ' has-error':'' }}">
                    <label class="control-label">Correo Electronico</label>
                    <input type="text" class="form-control input-sm" maxlength="50" name="mail_itc" value="{{ old('mail_itc') ? old('mail_itc') : ($customer->actives_creditcards->get($tdc)->address_one ? $customer->actives_creditcards->get($tdc)->address_one->getMail() : '') }}">
                    <span class="help-block">{{ $errors->first('mail_itc') }}</span>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group{{ $errors->first('ways_sending_statement_itc') ? ' has-error':'' }}">
                    <label class="control-label col-xs-12" style="padding-left: 0px;">Formas de Envio de Estados</label>
                    @foreach ($ways_sending_statements as $ways)
                        <div class="col-xs-4">
                            <label class="radio-inline">
                                <input type="radio" name="ways_sending_statement_itc"{{ $customer->actives_creditcards->get($tdc)->address_one ? ($customer->actives_creditcards->get($tdc)->address_one->getWaySendingStatement() == $ways->getCode() ? ' checked':'') : '' }} value="{{ $ways->getCode() }}"> {{ $ways->getDescription() }}
                            </label>
                        </div>
                    @endforeach
                    <span class="help-block">{{ $errors->first('ways_sending_statement_itc') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
