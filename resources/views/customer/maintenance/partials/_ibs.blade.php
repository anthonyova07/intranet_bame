<div class="col-xs-6 col-xs-offset-3">
    <div class="panel panel-default">

        <div class="panel-body text-center">
            <h1 class="text-center label label-primary" style="font-size: 40px;">IBS</h1>
        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Dirección</div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('street_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Calle</label>
                        <input type="text" class="form-control input-sm" maxlength="35" name="street_ibs" value="{{ old('street_ibs') ? old('street_ibs') : $customer->getStreet() }}">
                        <span class="help-block">{{ $errors->first('street_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('building_house_number_ibs') ? ' has-error':'' }}">
                        <label class="control-label">No. de Casa / Apartamento</label>
                        <input type="text" class="form-control input-sm" maxlength="35" name="building_house_number_ibs" value="{{ old('building_house_number_ibs') ? old('building_house_number_ibs') : $customer->getBuildingOrHouseNumber() }}">
                        <span class="help-block">{{ $errors->first('building_house_number_ibs') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('country_ibs') ? ' has-error':'' }}">
                        <label class="control-label">País</label>
                        <select class="form-control input-sm" name="country_ibs">
                            <option value="">Selecciona un país</option>
                            @foreach ($countries_ibs as $country)
                                <option value="{{ trim($country->code) }}"{{ $customer->getCountry() == cap_str($country->description) ? ' selected' : '' }}>{{ trim($country->description) }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('country_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('province_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Provincia</label>
                        <select class="form-control input-sm" name="province_ibs">
                            @foreach ($provinces_ibs as $province)
                                <option value="{{ $province->code }}"{{ $province->code == $customer->getProvinceCode() ? ' selected':'' }}>{{ $province->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('province_ibs') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('city_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Ciudad</label>
                        <select class="form-control input-sm" name="city_ibs">
                            @foreach ($cities_ibs as $city)
                                <option value="{{ $city->code }}"{{ $city->code == $customer->getCityCode() ? 'selected':'' }}>{{ $city->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('city_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('sector_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Sector</label>
                        <select class="form-control input-sm" name="sector_ibs">
                            @foreach ($sectors_ibs as $sector)
                                <option value="{{ $sector->code }}"{{ $sector->code == $customer->getSectorCode() ? 'selected':'' }}>{{ $sector->description }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{{ $errors->first('sector_ibs') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('postal_mail_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Apartado Postal</label>
                        <input type="text" class="form-control input-sm" maxlength="10" name="postal_mail_ibs" value="{{ old('postal_mail_ibs') ? old('postal_mail_ibs') : $customer->getPostalMail() }}">
                        <span class="help-block">{{ $errors->first('postal_mail_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('zip_code_ibs') ? ' has-error':'' }}">
                      <label class="control-label">Código Postal</label>
                      <input type="text" class="form-control input-sm" maxlength="15" name="zip_code_ibs" value="{{ old('zip_code_ibs') ? old('zip_code_ibs') : $customer->getZipCode() }}">
                      <span class="help-block">{{ $errors->first('zip_code_ibs') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('mail_type_ibs') ? ' has-error':'' }}">
                      <label class="control-label">Tipo de Correo</label>
                      <input type="text" class="form-control input-sm" maxlength="4" name="mail_type_ibs" value="{{ old('mail_type_ibs') ? old('mail_type_ibs') : $customer->getMailType() }}">
                      <span class="help-block">{{ $errors->first('mail_type_ibs') }}</span>
                    </div>
                </div> --}}

                <div class="col-xs-12">
                    <div class="form-group{{ $errors->first('mail_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Correo</label>
                        <input type="text" class="form-control input-sm" maxlength="40" name="mail_ibs" value="{{ old('mail_ibs') ? old('mail_ibs') : $customer->getMail() }}">
                        <span class="help-block">{{ $errors->first('mail_ibs') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row text-center" style="margin-bottom: 5px;">
                <div class="label label-default" style="font-size: 16px;">Contacto</div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('house_phone_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Casa</label>
                        <input type="text" maxlength="11" class="form-control input-sm" name="house_phone_ibs" value="{{ old('house_phone_ibs') ? old('house_phone_ibs') : $customer->getClearResidentialPhone() }}">
                        <span class="help-block">{{ $errors->first('house_phone_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('office_phone_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Oficina</label>
                        <input type="text" maxlength="11" class="form-control input-sm" name="office_phone_ibs" value="{{ old('office_phone_ibs') ? old('office_phone_ibs') : $customer->getClearOfficePhone() }}">
                        <span class="help-block">{{ $errors->first('office_phone_ibs') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('fax_phone_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Fax</label>
                        <input type="text" maxlength="11" class="form-control input-sm" name="fax_phone_ibs" value="{{ old('fax_phone_ibs') ? old('fax_phone_ibs') : $customer->getClearFaxPhone() }}">
                        <span class="help-block">{{ $errors->first('fax_phone_ibs') }}</span>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group{{ $errors->first('movil_phone_ibs') ? ' has-error':'' }}">
                        <label class="control-label">Teléfono Celular</label>
                        <input type="text" maxlength="11" class="form-control input-sm" name="movil_phone_ibs" value="{{ old('movil_phone_ibs') ? old('movil_phone_ibs') : $customer->getClearCellPhone() }}">
                        <span class="help-block">{{ $errors->first('movil_phone_ibs') }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
