@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Reclamación ' . $form->claim->claim_number . ' (Formulario de ' . get_form_types($form->form_type) . ')')

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @if ($form->form_type == 'CAI')

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
                            <div class="col-xs-1">
                                <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $form->claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            </div>
                            <div class="col-xs-2 text-center">
                                <div class="form-group">
                                    <label class="control-label"># Reclamación</label>
                                    <p class="form-control-static">{{ $form->claim->claim_number }}</p>
                                </div>
                            </div>

                            <div class="col-xs-2 text-center">
                                <div class="form-group">
                                    <label class="control-label">Nombre del Cliente</label>
                                    <p class="form-control-static">{{ $form->claim->names . ' ' . $form->claim->last_names }}</p>
                                </div>
                            </div>

                            <div class="col-xs-2 text-center">
                                <div class="form-group">
                                    <label class="control-label">Tipo de Producto</label>
                                    <p class="form-control-static">
                                        {{ in_array($form->claim->product_intranet, ['PRECOM', 'PRECON', 'PREHIP']) ? 'Préstamo' : 'Tarjeta de Crédito' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-xs-1 text-center">
                                <div class="form-group">
                                    <label class="control-label">Tipo de Moneda</label>
                                    <p class="form-control-static">{{ $form->claim->currency }}</p>
                                </div>
                            </div>

                            <div class="col-xs-2 text-center">
                                <div class="form-group">
                                    <label class="control-label"># Producto</label>
                                    <p class="form-control-static">{{ $form->claim->product_number }}</p>
                                </div>
                            </div>

                            <div class="col-xs-1">
                                <a style="font-size: 13px;" class="label btn-warning" target="__blank" href="{{ route('customer.claim.print.form', ['claim_id' => $form->claim->id, 'form_type' => $form->form_type, 'form_id' => $form->id]) }}">Imprimir</a>
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

                        <div class="row text-center">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Capital</label>
                                    <p class="form-control-static">{{ number_format($form->capital, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">% Descuento</label>
                                    <p class="form-control-static">{{ $form->capital_discount_percent }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Total</label>
                                    <p class="form-control-static">{{ number_format($form->capital_total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Interés</label>
                                    <p class="form-control-static">{{ number_format($form->interest, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group{{ $errors->first('interest_discount_percent') ? ' has-error':'' }}">
                                    <label class="control-label">% Descuento</label>
                                    <p class="form-control-static">{{ $form->interest_discount_percent }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Total</label>
                                    <p class="form-control-static">{{ number_format($form->interest_total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Mora</label>
                                    <p class="form-control-static">{{ number_format($form->arrears, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">% Descuento</label>
                                    <p class="form-control-static">{{ $form->arrears_discount_percent }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Total</label>
                                    <p class="form-control-static">{{ number_format($form->arrears_total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Cargos</label>
                                    <p class="form-control-static">{{ number_format($form->charges, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">% Descuento</label>
                                    <p class="form-control-static">{{ $form->charges_discount_percent }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">Total</label>
                                    <p class="form-control-static">{{ number_format($form->charges_total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <div class="form-group{{ $errors->first('others_charges') ? ' has-error':'' }}">
                                    <label class="control-label">Otros Cargos</label>
                                    <p class="form-control-static">{{ number_format($form->others_charges, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group">
                                    <label class="control-label">% Descuento</label>
                                    <p class="form-control-static">{{ $form->others_charges_discount_percent }}</p>
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="form-group{{ $errors->first('total') ? ' has-error':'' }}">
                                    <label class="control-label">Total</label>
                                    <p class="form-control-static">{{ number_format($form->others_charges_total, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Nivel de Atraso</label>
                                    <p class="form-control-static">{{ $form->arrears_level }} días</p>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Total a Reversar</label>
                                    <p class="form-control-static">{{ number_format($form->total_to_reverse, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('comments') ? ' has-error':'' }}">
                                    <label class="control-label">Comentarios</label>
                                    <p class="form-control-static">{{ $form->comments }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endif

    @if (in_array($form->form_type, ['FRA', 'CON']))

        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Datos del Clientes (Persona {{ $form->claim->is_company ? 'Jurídica' : 'Física' }})
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-1">
                                <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $form->claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            </div>

                            <div class="col-xs-3 text-center">
                                <div class="form-group">
                                    <label class="control-label"># Reclamación</label>
                                    <p class="form-control-static">{{ $form->claim->claim_number }}</p>
                                </div>
                            </div>

                            <div class="col-xs-3 text-center">
                                <div class="form-group">
                                    <label class="control-label">Nombre Tarjetahabiente Principal</label>
                                    <p class="form-control-static">{{ $form->claim->names . ' ' . $form->claim->last_names }}</p>
                                </div>
                            </div>

                            <div class="col-xs-3 text-center">
                                <div class="form-group">
                                    <label class="control-label">Número de Contacto con el Tarjetahabiente</label>
                                    <p class="form-control-static">
                                        {{ $form->claim->getOnePhoneNumber() }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-xs-1">
                                <a style="font-size: 13px;" class="label btn-warning" target="__blank" href="{{ route('customer.claim.print.form', ['claim_id' => $form->claim->id, 'form_type' => $form->form_type, 'form_id' => $form->id]) }}">Imprimir</a>
                            </div>
                        </div>

                        <div class="row text-center">
                            <h5>Número de Tarjeta de Crédito</h5>
                        </div>

                        <div class="row">
                            <div class="col-xs-3">
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[0] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[1] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[2] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[3] }}</div>
                            </div>
                            <div class="col-xs-3">
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[4] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[5] }}</div>
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
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[12] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[13] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[14] }}</div>
                                <div class="col-xs-3 well well-sm card_number">{{ $form->claim->product_number[15] }}</div>
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
                                    <th>Fecha de la Transacción</th>
                                    <th>Comercio</th>
                                    <th>Ciudad</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form->transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_date->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $transaction->merchant_name }}</td>
                                        <td>{{ $transaction->country . '_' . $transaction->city }}</td>
                                        <td>{{ number_format($transaction->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif

    @if ($form->form_type == 'CON')
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Tipo de Reclamo TARJETA
                        </h3>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <b>
                                    {{ $form->claim_es_name }}
                                </b>
                                <p style="margin: 5px 0;">
                                    {{ $form->claim_es_detail }}
                                </p>
                                <p>
                                    {{ $form->claim_es_detail_2 }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Datos del Oficial del Banco
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="col-xs-4 text-center">
                        <div class="form-group">
                            <label class="control-label">Nombre y Apellido</label>
                            <p class="form-control-static">{{ $form->created_by_name }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="form-group">
                            <label class="control-label">Teléfono</label>
                            <p class="form-control-static">{{ $form->created_by_phone }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="form-group">
                            <label class="control-label">Fecha de Respuesta</label>
                            <p class="form-control-static">{{ $form->response_date->format('d/m/Y') }}</p>
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
