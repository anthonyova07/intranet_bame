@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Reclamación (Formulario de ' . get_form_types($form_type) . ')')

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @if (session()->has('messages_claim_form'))
        @if (session()->get('messages_claim_form')->count())
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="alert alert-danger">
                        <b>Campos Requeridos</b>
                        <ul>
                            @foreach (session()->get('messages_claim_form') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <form method="post" action="{{ route('customer.claim.{claim_id}.{form_type}.form.store', ['claim_id' => $claim->id, 'form_type' => $form_type]) }}" id="form">

        @if ($form_type == 'CAI')
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Formulario de Descuentos Aplicados
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-2 text-center">
                                    <div class="form-group">
                                        <label class="control-label"># Reclamación</label>
                                        <p class="form-control-static">{{ $claim->claim_number }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3 text-center">
                                    <div class="form-group">
                                        <label class="control-label">Nombre del Cliente</label>
                                        <p class="form-control-static">{{ $claim->names . ' ' . $claim->last_names }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-2 text-center">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Producto</label>
                                        <p class="form-control-static">
                                            {{ in_array($claim->product_intranet, ['PRECOM', 'PRECON', 'PREHIP']) ? 'Préstamo' : 'Tarjeta de Crédito' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-xs-2 text-center">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Moneda</label>
                                        <p class="form-control-static">{{ $claim->currency }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3 text-center">
                                    <div class="form-group">
                                        <label class="control-label"># Producto</label>
                                        <p class="form-control-static">{{ $claim->product_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Datalle del Cargo
                            </h3>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('capital') ? ' has-error':'' }}">
                                        <label class="control-label">Capital</label>
                                        <input type="text" class="form-control input-sm input_money" name="capital" placeholder="0.00" value="{{ old('capital') }}">
                                        <span class="help-block">{{ $errors->first('capital') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('capital_discount_percent') ? ' has-error':'' }}">
                                        <label class="control-label">% Descuento</label>
                                        <input type="text" class="form-control input-sm input_money" name="capital_discount_percent" placeholder="0" value="{{ old('capital_discount_percent') }}">
                                        <span class="help-block">{{ $errors->first('capital_discount_percent') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                        <label class="control-label">Total</label>
                                        <input type="text" class="form-control input-sm input_money" name="capital_total" placeholder="0.00" value="{{ old('total') }}">
                                        <span class="help-block">{{ $errors->first('total') }}</span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('interest') ? ' has-error':'' }}">
                                        <label class="control-label">Interés</label>
                                        <input type="text" class="form-control input-sm input_money" name="interest" placeholder="0.00" value="{{ old('interest') }}">
                                        <span class="help-block">{{ $errors->first('interest') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('interest_discount_percent') ? ' has-error':'' }}">
                                        <label class="control-label">% Descuento</label>
                                        <input type="text" class="form-control input-sm input_money" name="interest_discount_percent" placeholder="0" value="{{ old('interest_discount_percent') }}">
                                        <span class="help-block">{{ $errors->first('interest_discount_percent') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                        <label class="control-label">Total</label>
                                        <input type="text" class="form-control input-sm input_money" name="interest_total" placeholder="0.00" value="{{ old('total') }}">
                                        <span class="help-block">{{ $errors->first('total') }}</span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('arrears') ? ' has-error':'' }}">
                                        <label class="control-label">Mora</label>
                                        <input type="text" class="form-control input-sm input_money" name="arrears" placeholder="0.00" value="{{ old('arrears') }}">
                                        <span class="help-block">{{ $errors->first('arrears') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('arrears_discount_percent') ? ' has-error':'' }}">
                                        <label class="control-label">% Descuento</label>
                                        <input type="text" class="form-control input-sm input_money" name="arrears_discount_percent" placeholder="0" value="{{ old('arrears_discount_percent') }}">
                                        <span class="help-block">{{ $errors->first('arrears_discount_percent') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                        <label class="control-label">Total</label>
                                        <input type="text" class="form-control input-sm input_money" name="arrears_total" placeholder="0.00" value="{{ old('total') }}">
                                        <span class="help-block">{{ $errors->first('total') }}</span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('charges') ? ' has-error':'' }}">
                                        <label class="control-label">Cargos</label>
                                        <input type="text" class="form-control input-sm input_money" name="charges" placeholder="0.00" value="{{ old('charges') }}">
                                        <span class="help-block">{{ $errors->first('charges') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('charges_discount_percent') ? ' has-error':'' }}">
                                        <label class="control-label">% Descuento</label>
                                        <input type="text" class="form-control input-sm input_money" name="charges_discount_percent" placeholder="0" value="{{ old('charges_discount_percent') }}">
                                        <span class="help-block">{{ $errors->first('charges_discount_percent') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                        <label class="control-label">Total</label>
                                        <input type="text" class="form-control input-sm input_money" name="charges_total" placeholder="0.00" value="{{ old('total') }}">
                                        <span class="help-block">{{ $errors->first('total') }}</span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('others_charges') ? ' has-error':'' }}">
                                        <label class="control-label">Otros Cargos</label>
                                        <input type="text" class="form-control input-sm input_money" name="others_charges" placeholder="0.00" value="{{ old('others_charges') }}">
                                        <span class="help-block">{{ $errors->first('others_charges') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group{{ $errors->first('others_charges_discount_percent') ? ' has-error':'' }}">
                                        <label class="control-label">% Descuento</label>
                                        <input type="text" class="form-control input-sm input_money" name="others_charges_discount_percent" placeholder="0" value="{{ old('others_charges_discount_percent') }}">
                                        <span class="help-block">{{ $errors->first('others_charges_discount_percent') }}</span>
                                    </div>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                        <label class="control-label">Total</label>
                                        <input type="text" class="form-control input-sm input_money" name="others_charges_total" placeholder="0.00" value="{{ old('total') }}">
                                        <span class="help-block">{{ $errors->first('total') }}</span>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Nivel de Atraso</label>
                                        <p class="form-control-static">{{ $arrears_level }} días</p>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Total a Reversar</label>
                                        <p class="form-control-static">{{ 0.00 }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('comments') ? ' has-error':'' }}">
                                        <label class="control-label">Comentarios</label>
                                        <textarea class="form-control input-sm" name="comments"></textarea>
                                        <span class="help-block">{{ $errors->first('comments') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>

                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (in_array($form_type, ['CON', 'FRA']))
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Datos del Clientes (Persona {{ $claim->is_company ? 'Jurídica' : 'Física' }})
                            </h3>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <div class="form-group">
                                        <label class="control-label"># Reclamación</label>
                                        <p class="form-control-static">{{ $claim->claim_number }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-4 text-center">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Tarjetahabiente Principal</label>
                                        <p class="form-control-static">{{ $claim->names . ' ' . $claim->last_names }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-4 text-center">
                                    <div class="form-group">
                                        <label class="control-label">Número de Contacto con el Tarjetahabiente</label>
                                        <p class="form-control-static">
                                            {{ $claim->getOnePhoneNumber() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center">
                                <h5>Número de Tarjeta de Crédito</h5>
                            </div>

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[0] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[1] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[2] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[3] }}</div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[4] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[5] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                    <div class="col-xs-3 well well-sm card_number">*</div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[12] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[13] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[14] }}</div>
                                    <div class="col-xs-3 well well-sm card_number">{{ $claim->product_number[15] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Transacciones de la Tarjeta de Crédito
                            </h3>
                        </div>

                        <div class="panel-body">
                            <table class="table table-bordered table-condensed table-hover table-striped datatable" order-by='1|asc'>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Fecha de la Transacción</th>
                                        <th>Comercio</th>
                                        <th>Ciudad</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (session()->has('tdc_transactions_claim'))
                                        @foreach (session()->get('tdc_transactions_claim') as $index => $statement)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="transactions[]" value="{{ $index }}">
                                                </td>
                                                <td>{{ $statement->getFormatedDateTimeTransaction() }}</td>
                                                <td>{{ $statement->getMerchantName() }}</td>
                                                <td>{{ $statement->getCountry() . '_' . $statement->getCity() }}</td>
                                                <td class="input_money">{{ $statement->getCurrency() . ' ' . number_format($statement->getAmount(), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if ($form_type == 'FRA')
                                {{ csrf_field() }}
                                <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($form_type == 'CON')
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Tipo de Reclamo VISA
                            </h3>
                        </div>

                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach ($claim_types_visa as $claim_type_visa)
                                    <li class="list-group-item">
                                        <input type="radio" name="claim_type_visa" value="{{ $claim_type_visa->id }}">
                                        <b>
                                            {!! $claim_type_visa->es_name !!}
                                        </b>
                                        <p style="margin: 5px 0px;">
                                            {!! $claim_type_visa->es_detail !!}
                                        </p>
                                        <p>
                                            {!! $claim_type_visa->es_detail_2 !!}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </form>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
