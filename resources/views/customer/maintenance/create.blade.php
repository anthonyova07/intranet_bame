@extends('layouts.master')

@section('title', 'Clientes - Mantenimiento')

@if (session()->has('customer_maintenance'))
    @section('page_title', 'Mantenimiento a ' . $customer->getName() . ' ( ' . $customer->getCode() . ' )')
@else
    @section('page_title', 'Nuevo Mantenimiento')
@endif

@if (can_not_do('customer_maintenance_address'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @if (session()->has('customer_maintenance'))

        @if ($core == 'itc')

            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="get" id="actives_creditcards_form" action="{{ route('customer.maintenance.create', Request::all()) }}">
                                @foreach (Request::except('_token') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('tdc') ? ' has-error':'' }}" style="margin-bottom: 0px;">
                                            {{-- <label class="control-label">Tarjetas</label> --}}
                                            <select onchange="$('#actives_creditcards_form').submit();" class="form-control input-sm" name="tdc" data-toggle="tooltip" title="Tarjetas del Cliente" style="border-color: #ff0000;outline: 0;box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255,0,0,.6);">
                                                @foreach ($customer->actives_creditcards as $key => $creditcard)
                                                    <option type="tdc" value="{{ $key }}" {{ $tdc == $key ? 'selected':'' }}>Tarjeta ( {{ $creditcard->product->getDescription() }} ) ( {{ $creditcard->getMaskedNumber() }} )</option>
                                                @endforeach
                                            </select>
                                            {{-- <span class="help-block">{{ $errors->first('tdc') }}</span> --}}
                                        </div>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                {{-- <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando...">Buscar Dirección</button> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <form method="post" action="{{ route('customer.maintenance.store') }}" id="form">
            {{ csrf_field() }}
            <input type="hidden" name="tdc" value="{{ request('tdc') }}">
            <input type="hidden" name="core" value="{{ request('core') }}">

            <div class="row">
                @if ($core == 'ibs')

                    @include('customer.maintenance.partials._ibs')

                @endif

                @if ($core == 'itc')

                    @include('customer.maintenance.partials._tdc_1')

                    @include('customer.maintenance.partials._tdc_2')

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
                            <a class="btn btn-info btn-xs" href="{{ route('customer.maintenance.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando...">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <script type="text/javascript">
        function approve(el) {
            $('.link_approv').each(function (index, link) {
                $(link).remove();
            });
        }

        //--------------------------------------------
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
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
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });


        // ----------------------------------------

        var country2 = $('select[name=country_2_itc]');
        var region2 = $('select[name=region_2_itc]');
        var province2 = $('select[name=province_2_itc]');
        var city2 = $('select[name=city_2_itc]');
        var municipality2 = $('select[name=municipality_2_itc]');
        var sector2 = $('select[name=sector_2_itc]');
        var neighborhood2 = $('select[name=neighborhood_2_itc]');
        var street2 = $('select[name=street_2_itc]');

        region2.change(function () {
            province2.html('');
            city2.html('');
            municipality2.html('');
            sector2.html('');
            neighborhood2.html('');
            street2.html('');

            if (region2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'province',
                country: country2.val(),
                region: region2.val(),
            },function (response) {
                province2.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    province2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        province2.change(function () {
            city2.html('');
            municipality2.html('');
            sector2.html('');
            neighborhood2.html('');
            street2.html('');

            if (province2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'city',
                country: country2.val(),
                region: region2.val(),
                province: province2.val(),
            },function (response) {
                city2.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    city2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        city2.change(function () {
            municipality2.html('');
            sector2.html('');
            neighborhood2.html('');
            street2.html('');

            if (city2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'municipality',
                country: country2.val(),
                region: region2.val(),
                province: province2.val(),
                city: city2.val(),
            },function (response) {
                municipality2.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    municipality2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        municipality2.change(function () {
            sector2.html('');
            neighborhood2.html('');
            street2.html('');

            if (municipality2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'sector',
                country: country2.val(),
                region: region2.val(),
                province: province2.val(),
                city: city2.val(),
                municipality: municipality2.val(),
            },function (response) {
                sector2.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    sector2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        sector2.change(function () {
            neighborhood2.html('');
            street2.html('');

            if (sector2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'neighborhood',
                country: country2.val(),
                region: region2.val(),
                province: province2.val(),
                city: city2.val(),
                municipality: municipality2.val(),
                sector: sector2.val(),
            },function (response) {
                neighborhood2.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    neighborhood2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        neighborhood2.change(function () {
            street2.html('');

            if (neighborhood2.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'street',
                country: country2.val(),
                region: region2.val(),
                province: province2.val(),
                city: city2.val(),
                municipality: municipality2.val(),
                sector: sector2.val(),
                neighborhood: neighborhood2.val(),
            },function (response) {
                $.each(response, function (index, item) {
                    street2.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        //-------------------------------------------

        var province_ibs = $('select[name=province_ibs]');
        var city_ibs = $('select[name=city_ibs]');
        var sector_ibs = $('select[name=sector_ibs]');
        var country_ibs = $('select[name=country_ibs]');

        country_ibs.change(function () {
            province_ibs.html('');
            city_ibs.html('');
            sector_ibs.html('');

            if (country_ibs.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'province_ibs',
                country: country_ibs.val(),
            },function (response) {
                province_ibs.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    province_ibs.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        province_ibs.change(function () {
            city_ibs.html('');
            sector_ibs.html('');

            if (province_ibs.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'city_ibs',
                country: country_ibs.val(),
                province: province_ibs.val(),
            },function (response) {
                city_ibs.append($('<option>', {value: '', text: ''}));

                $.each(response, function (index, item) {
                    city_ibs.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description)
                    }));
                });
            });
        });

        city_ibs.change(function () {
            sector_ibs.html('');

            if (city_ibs.val() == '') {
                return;
            }

            $.getJSON(url, {
                search: 'sector_ibs',
                country: country_ibs.val(),
                province: province_ibs.val(),
                city: city_ibs.val(),
            },function (response) {
                $.each(response, function (index, item) {
                    sector_ibs.append($('<option>', {
                        value: item.code + '|' + $.trim(item.description),
                        text: $.trim(item.description),
                    }));
                });
            });
        });

        $('.copy_info').click(function () {
            $('select[name=country_2_itc]').html($('select[name=country_itc]').html());
            $('select[name=country_2_itc]').val($('select[name=country_itc]').val());
            $('select[name=region_2_itc]').html($('select[name=region_itc]').html());
            $('select[name=region_2_itc]').val($('select[name=region_itc]').val());
            $('select[name=province_2_itc]').html($('select[name=province_itc]').html());
            $('select[name=province_2_itc]').val($('select[name=province_itc]').val());
            $('select[name=city_2_itc]').html($('select[name=city_itc]').html());
            $('select[name=city_2_itc]').val($('select[name=city_itc]').val());
            $('select[name=municipality_2_itc]').html($('select[name=municipality_itc]').html());
            $('select[name=municipality_2_itc]').val($('select[name=municipality_itc]').val());
            $('select[name=sector_2_itc]').html($('select[name=sector_itc]').html());
            $('select[name=sector_2_itc]').val($('select[name=sector_itc]').val());
            $('select[name=neighborhood_2_itc]').html($('select[name=neighborhood_itc]').html());
            $('select[name=neighborhood_2_itc]').val($('select[name=neighborhood_itc]').val());
            $('select[name=street_2_itc]').html($('select[name=street_itc]').html());
            $('select[name=street_2_itc]').val($('select[name=street_itc]').val());
            $('input[name=building_name_2_itc]').val($('input[name=building_name_itc]').val());
            $('input[name=block_2_itc]').val($('input[name=block_itc]').val());
            $('input[name=house_number_2_itc]').val($('input[name=house_number_itc]').val());
            $('input[name=km_2_itc]').val($('input[name=km_itc]').val());
            $('input[name=postal_zone_2_itc]').val($('input[name=postal_zone_itc]').val());
            $('input[name=postal_mail_2_itc]').val($('input[name=postal_mail_itc]').val());
            $('input[name=in_street_1_2_itc]').val($('input[name=in_street_1_itc]').val());
            $('input[name=in_street_2_2_itc]').val($('input[name=in_street_2_itc]').val());
            $('input[name=special_instruction_2_itc]').val($('input[name=special_instruction_itc]').val());
            $('input[name=main_phone_area_2_itc]').val($('input[name=main_phone_area_itc]').val());
            $('input[name=main_phone_number_2_itc]').val($('input[name=main_phone_number_itc]').val());
            $('input[name=main_phone_ext_2_itc]').val($('input[name=main_phone_ext_itc]').val());
            $('input[name=secundary_phone_area_2_itc]').val($('input[name=secundary_phone_area_itc]').val());
            $('input[name=secundary_phone_number_2_itc]').val($('input[name=secundary_phone_number_itc]').val());
            $('input[name=secundary_phone_ext_2_itc]').val($('input[name=secundary_phone_ext_itc]').val());
            $('input[name=main_cell_area_2_itc]').val($('input[name=main_cell_area_itc]').val());
            $('input[name=main_cell_number_2_itc]').val($('input[name=main_cell_number_itc]').val());
            $('input[name=secundary_cell_area_2_itc]').val($('input[name=secundary_cell_area_itc]').val());
            $('input[name=secundary_cell_number_2_itc]').val($('input[name=secundary_cell_number_itc]').val());
            $('input[name=fax_area_2_itc]').val($('input[name=fax_area_itc]').val());
            $('input[name=fax_number_2_itc]').val($('input[name=fax_number_itc]').val());
            $('input[name=mail_2_itc]').val($('input[name=mail_itc]').val());

            $('input[name=ways_sending_statement_2_itc]').each(function (index, radio) {
                var radio = $(radio);
                if ($('input[name=ways_sending_statement_itc]:checked').val() == radio.val()) {
                    radio.attr('checked', true);
                }
            });
        });
    </script>

@endsection
