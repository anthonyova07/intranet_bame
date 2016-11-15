@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Reclamación #' . $form->claim->claim_number . ' (Formulario de Consumo)')

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

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
                        <div class="col-xs-3">
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
                                <p class="form-control-static">{{ $form->principal_cardholder_name }}</p>
                            </div>
                        </div>

                        <div class="col-xs-3 text-center">
                            <div class="form-group">
                                <label class="control-label">Número de Contacto con el Tarjetahabiente</label>
                                <p class="form-control-static">
                                    {{ $form->cardholder_contact_number }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <h5>Número de Tarjeta de Crédito</h5>
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[0] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[1] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[2] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[3] }}</div>
                        </div>
                        <div class="col-xs-3">
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[4] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[5] }}</div>
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
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[12] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[13] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[14] }}</div>
                            <div class="col-xs-3 well well-sm card_number">{{ $form->cc_number[15] }}</div>
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

    @if ($form->form_type == 'CON')
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

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
