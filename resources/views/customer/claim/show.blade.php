@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Reclamación #' . $claim->claim_number)

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('customer.claim.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>

                    <div class="col-xs-10 text-right" style="padding: 0 2px;">
                        @foreach ($claim->forms as $form)
                            <a class="btn btn-default btn-xs" href="{{ route('customer.claim.{claim_id}.{form_type}.form.show', ['form' => $form->id, 'claim_id' => $claim->id, 'form_type' => $form->form_type]) }}"><i class="fa fa-wpforms"></i> Formulario de {{ get_form_types($form->form_type) }}</a>
                        @endforeach

                        {{-- <a class="btn btn-default btn-xs" href=""><i class="fa fa-wpforms"></i> Formulario de Reverso</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos del Reclamante (Persona {{ $claim->is_company ? 'Jurídica' : 'Física' }})</h3>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2" style="width: 50%"><b>Número de Reclamación: </b> {{ $claim->claim_number }}</td>
                                <td colspan="2" style="width: 50%"><b>Fecha/Hora: </b> {{ $claim->created_at->format('d/m/Y h:i:s a') }}</td>
                            </tr>
                            @if (!$claim->is_company)
                                <tr>
                                    <td colspan="2"><b>Nombres:</b> {{ $claim->names }}</td>
                                    <td colspan="2"><b>Apellidos:</b> {{ $claim->last_names }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>No. Cédula:</b> {{ $claim->identification }}</td>
                                    <td colspan="2"><b>No. Pasaporte:</b> {{ $claim->passport }}</td>
                                </tr>
                            @endif

                            @if ($claim->is_company)
                                <tr>
                                    <td colspan="2"><b>Razón Social:</b> {{ $claim->legal_name }}</td>
                                    <td colspan="2"><b>RNC:</b> {{ $claim->identification }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="{{ $claim->is_company ? '2' : '' }}"><b>Teléfonos:</b></td>
                                @if (!$claim->is_company)
                                    <td>
                                        <b>Residencia: </b> {{ $claim->residential_phone }}
                                    </td>
                                @endif
                                <td colspan="{{ $claim->is_company ? '2' : '' }}"><b>Oficina: </b> {{ $claim->office_phone }}</td>
                                @if (!$claim->is_company)
                                    <td>
                                        <b>Celular: </b> {{ $claim->cell_phone }}
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="2"><b>Correo: </b> {{ $claim->mail }}</td>
                                <td colspan="2"><b>Fax: </b> {{ $claim->fax_phone }}</td>
                            </tr>
                            <tr>
                                <td><b>Calle: </b> {{ $claim->street_address }}</td>
                                <td><b>Edificio/Residencial: </b> {{ $claim->building_residential }}</td>
                                <td><b>Apartamento/Casa: </b> {{ $claim->apartment_number }}</td>
                                <td><b>Sector: </b> {{ $claim->sector_address }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Ciudad: </b> {{ $claim->city }}</td>
                                <td colspan="2"><b>Provincia: </b> {{ $claim->province }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($claim->is_company)
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
                                    <td colspan="2" style="width: 50%"><b>Nombre Legal:</b> {{ $claim->agent_legal_name }}</td>
                                    <td colspan="2" style="width: 50%"><b>Cédula/Pasaporte:</b> {{ $claim->agent_identification }}</td>
                                </tr>
                                <tr>
                                    <td><b>Teléfonos:</b></td>
                                    <td><b>Residencia: </b> {{ $claim->agent_residential_phone }}</td>
                                    <td><b>Oficina: </b> {{ $claim->agent_office_phone }}</td>
                                    <td><b>Celular: </b> {{ $claim->agent_cell_phone }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Correo: </b> {{ $claim->agent_mail }}</td>
                                    <td colspan="2"><b>Fax: </b> {{ $claim->agent_fax_phone }}></td>
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
                    {{ $claim->distribution_channel }}
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
                        <div class="col-xs-5">
                            {{ $claim->product_type }}
                        </div>
                        <div class="col-xs-7">
                            <b>#</b> {{ $claim->getProduct() }}
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
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label class="control-label">Monto Reclamado</label>
                                <p class="form-control-static">{{ $claim->currency . ' ' . number_format($claim->amount, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <div class="form-group">
                                <label class="control-label">Tipo de Reclamación</label>
                                <p class="form-control-static">{{ $claim->claim_type }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Oficial de la Reclamación</label>
                                <p class="form-control-static">
                                    {{ $claim->created_by_name }}
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('response_term') ? ' has-error':'' }}">
                                <label class="control-label">Plazo de Respuesta</label>
                                <p class="form-control-static">{{ $claim->response_term }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Fecha de Respuesa</label>
                                <p class="form-control-static">{{ $claim->response_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label class="control-label">Lugar de Respuesta</label>
                                <p class="form-control-static">{{ $claim->response_place }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Observaciones</label>
                                <p class="form-control-static">{{ $claim->observations }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
