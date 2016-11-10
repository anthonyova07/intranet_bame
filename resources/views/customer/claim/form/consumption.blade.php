@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Reclamación (Formulario de Consumo)')

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <form method="post" action="{{ route('customer.claim.form.consumption', ['id' => $id]) }}" id="form">

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
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre Tarjetahabiente Principal</label>
                                    <p class="form-control-static">{{ $claim->names . ' ' . $claim->last_names }}</p>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Número de Contacto con el Tarjetahabiente</label>
                                    <p class="form-control-static">
                                        @if ($claim->cell_phone)
                                            {{ $claim->cell_phone }}
                                        @elseif ($claim->residential_phone)
                                            {{ $claim->residential_phone }}
                                        @else
                                            {{ $claim->office_phone }}
                                        @endif
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
                                    <th>Débito</th>
                                    <th>Crédito</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session()->has('tdc_transactions_claim'))
                                    @foreach (session()->get('tdc_transactions_claim') as $index => $statement)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="transactions[]" value="{{ $index }}">
                                            </td>
                                            <td>{{ $statement->getFormatedDateTransaction() }}</td>
                                            <td>{{ $statement->getConcept() }}</td>
                                            @if ($statement->isDebit())
                                                <td class="input_money">{{ $statement->getCurrency() . ' ' . number_format($statement->getAmount(), 2) }}</td>
                                                <td class="input_money">0.00</td>
                                            @else
                                                <td class="input_money">0.00</td>
                                                <td class="input_money">{{ $statement->getCurrency() . ' ' . number_format($statement->getAmount(), 2) }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
                            @foreach (get_claim_types_visa() as $claim_type)
                                <li class="list-group-item">
                                    <input type="radio" name="claim_type" value="{{ $claim_type->id }}">
                                    <b>
                                        {{ $claim_type->id }}.
                                        {!! str_replace(['{field1}', '{field2}', '{field3}'], '<b><input type="text" name="fields' . $claim_type->id . '[]"></b>', $claim_type->es_name) !!}
                                    </b>
                                    <p>
                                        {!! str_replace(['{field1}', '{field2}', '{field3}'], '<b><input type="text" name="fields' . $claim_type->id . '[]"></b>', $claim_type->es_detail) !!}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atras</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
