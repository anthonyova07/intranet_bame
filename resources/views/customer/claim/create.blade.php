@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Nueva Reclamación')

{{-- @if (can_not_do('marketing_news'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    @if (session()->has('customer_claim'))

        <form method="post" action="" name="form">

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Datos del Reclamante ({{ session()->get('customer_claim')->is_legal ? 'Jurídico' : 'Físico' }})
                                <a
                                    class="btn btn-danger pull-right btn-xs"
                                    href="javascript:void(0)"
                                    onclick="action('eliminar_all', this)"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Cancelar Todo"
                                    style="margin-top: -3px;color: #FFFFFF;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <form
                                    style="display: none;"
                                    action="{{ route('customer.ncf.divisa.new.destroy', ['id' => 'all']) }}"
                                    method="post" id="form_eliminar_all">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody>
                                    @if (!session()->get('customer_claim')->is_legal)
                                        <tr>
                                            <td colspan="2"><b>Nombres:</b> {{ session()->get('customer_claim')->getNames() }}</td>
                                            <td colspan="2"><b>Apellidos:</b> {{ session()->get('customer_claim')->getLastNames() }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>No. Cédula:</b> {{ session()->get('customer_claim')->getDocument() }}</td>
                                            <td colspan="2"><b>No. Pasaporte:</b> {{ session()->get('customer_claim')->getPassport() }}</td>
                                        </tr>
                                    @endif

                                    @if (session()->get('customer_claim')->is_legal)
                                        <tr>
                                            <td colspan="2"><b>Razón Social:</b> {{ session()->get('customer_claim')->getLegalName() }}</td>
                                            <td colspan="2"><b>RNC:</b> {{ session()->get('customer_claim')->getDocument() }}</td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td><b>Teléfonos:</b></td>
                                        <td>
                                            @if (!session()->get('customer_claim')->is_legal)
                                                <b>Residencia: </b> {{ session()->get('customer_claim')->getResidentialPhone() }}
                                            @endif
                                        </td>
                                        <td><b>Oficina: </b> {{ session()->get('customer_claim')->getOfficePhone() }}</td>
                                        <td>
                                            @if (!session()->get('customer_claim')->is_legal)
                                                <b>Celular: </b> {{ session()->get('customer_claim')->getCellPhone() }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Correo: </b> {{ session()->get('customer_claim')->getMail() }}</td>
                                        <td colspan="2"><b>Fax: </b> {{ session()->get('customer_claim')->getFaxPhone() }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Calle: </b> {{ session()->get('customer_claim')->getStreet() }}</td>
                                        <td><b>Edificio: </b> {{ session()->get('customer_claim')->getHouse() }}</td>
                                        <td><b>Apartamento: </b> {{ session()->get('customer_claim')->getBuilding() }}</td>
                                        <td><b>Sector: </b> Pendiente</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Ciudad: </b> Pendiente</td>
                                        <td colspan="2"><b>Provincia: </b> Pendiente</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->get('customer_claim')->is_legal)
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Datos del Representante</h3>
                            </div>

                            <div class="panel-body">
                                <table class="table table-bordered table-condensed table-striped">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><b>Nombre Legal:</b> {{ session()->get('customer_claim')->agent->getLegalName() }}</td>
                                            <td colspan="2"><b>Cédula/Pasaporte:</b> {{ session()->get('customer_claim')->agent->getIdentification() }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Teléfonos:</b></td>
                                            <td><b>Residencia: </b> <input type="text" name="residencial_phone" class="form-control input-sm"></td>
                                            <td><b>Oficina: </b> <input type="text" name="office_phone" class="form-control input-sm"></td>
                                            <td><b>Celular: </b> <p class="form-control-static">{{ session()->get('customer_claim')->agent->getPhoneNumber() }}</p></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Correo: </b> <input type="text" name="mail" class="form-control input-sm"></td>
                                            <td colspan="2"><b>Fax: </b> <input type="text" name="fax" class="form-control input-sm"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-xs-1"></div>
                <div class="col-xs-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Canal de Distribución</h3>
                        </div>

                        <div class="panel-body">
                            <select class="form-control input-sm">
                                <option value="">Seleccione un Canal de Distribución</option>
                                @foreach ($distribution_channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel') == $channel->id ? 'selected':'' }}>{{ $channel->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tipo de Producto</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <select class="form-control input-sm" name="product_type">
                                        <option value="">Seleccione un tipo de producto</option>
                                        @foreach (get_product_types() as $key => $product_type)
                                            <option value="{{ $key }}" {{ old('product_type') == $key ? 'selected':'' }}>{{ $product_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select class="form-control input-sm" name="form_type" data-toggle="tooltip" title="Tipo de Formulario">
                                        @foreach (get_form_types() as $key => $form_type)
                                            <option value="{{ $key }}" {{ old('form_type') == $key ? 'selected':'' }}>{{ $form_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-xs-12">
                                    <select class="form-control input-sm" name="product" data-toggle="tooltip" title="Producto">
                                        <option value="">Seleccione un producto del cliente</option>
                                        @foreach (session()->get('customer_claim')->loans as $loan)
                                            <option value="{{ $loan->getNumber() }}" {{ old('product') == $key ? 'selected':'' }}>Préstamo ({{ $loan->getNumber() }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1"></div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos de la Reclamación</h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('currency') ? ' has-error':'' }}">
                                        <label class="control-label">Moneda</label>
                                        <select class="form-control input-sm" name="currency">
                                            @foreach (get_currencies() as $key => $currency)
                                                <option value="{{ $key }}" {{ old('currency') == $key ? 'selected':'' }}>{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('currency') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('amount') ? ' has-error':'' }}">
                                        <label class="control-label">Monto Reclamado</label>
                                        <input type="text" class="form-control input-sm input_money" placeholder="0.00" name="amount" value="{{ old('amount') }}">
                                        <span class="help-block">{{ $errors->first('amount') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('claim_type') ? ' has-error':'' }}">
                                        <label class="control-label">Tipo de Reclamación</label>
                                        <select class="form-control input-sm" name="claim_type">
                                            <option value="">Seleccione un Tipo de Reclamación</option>
                                            @foreach ($claim_types as $claim_type)
                                                <option value="{{ $claim_type->id }}" {{ old('claim_type') == $claim_type->id ? 'selected':'' }}>{{ $claim_type->description }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('claim_type') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Oficial de la Reclamación</label>
                                        <p class="form-control-static">
                                            {{ session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('days') ? ' has-error':'' }}">
                                        <label class="control-label">Plazo de Respuesta</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control input-sm" name="days" value="30" min="1">
                                            <span class="input-group-addon">días</span>
                                        </div>
                                        <span class="help-block">{{ $errors->first('days') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Respuesa</label>
                                        <input type="date" class="form-control input-sm" name="response_date">
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group{{ $errors->first('office') ? ' has-error':'' }}">
                                        <label class="control-label">Lugar de Respuesta</label>
                                        <select class="form-control input-sm" name="office">
                                            @foreach (get_offices() as $key => $office)
                                                <option value="{{ $key }}" {{ old('office') == $key ? 'selected':'' }}>{{ $office }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('office') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Observaciones</label>
                                        <textarea class="form-control" name="observations"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-2">
                                    {{ csrf_field() }}
                                    <a class="btn btn-info btn-xs" href="{{ route('marketing.news.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                </div>
                                <div class="col-xs-7"></div>
                                <div class="col-xs-3 text-right">
                                    <span class="label label-danger">Creada el 15/05/2016 14:41</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    @else

        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="get" action="{{ route('customer.claim.create') }}" id="form">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="form-group{{ $errors->first('identification') ? ' has-error':'' }}">
                                        <label class="control-label">Cédula/Pasaporte/RNC</label>
                                        <input type="text" class="form-control input-sm" name="identification" value="{{ old('identification') }}">
                                        <span class="help-block">{{ $errors->first('identification') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="checkbox">
                                        <label style="margin-top: 18px;">
                                            <input type="checkbox" name="is_legal" {{ old('is_legal') ? 'checked' : '' }}> Jurídico
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.claim.index') }}"><i class="fa fa-arrow-left"></i> Atras</a>
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
