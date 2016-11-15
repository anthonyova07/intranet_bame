@extends('layouts.master')

@section('title', 'Clientes -> Reclamaciones')

@section('page_title', 'Reclamaciones')

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
                    <h3 class="panel-title">Búscar Reclamación</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('customer.claim.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando vacantos...">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.create') }}">Nuevo Reclamación</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th># Reclamación</th>
                                <th># Cliente</th>
                                <th>Identificación</th>
                                <th>Monto</th>
                                <th>Fec. Respuesta</th>
                                <th>Estado</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claims as $claim)
                                <tr>
                                    <td>{{ $claim->claim_number }}</td>
                                    @if ($claim->is_company)
                                        <td>{{ '(' . $claim->customer_number . ') ' . $claim->legal_name }}</td>
                                    @else
                                        <td>{{ '(' . $claim->customer_number . ') ' . $claim->names . ' ' . $claim->last_names }}</td>
                                    @endif
                                    <td>{{ ($claim->identification == '') ? $claim->passport : $claim->identification }}</td>
                                    <td class="text-right">{{ $claim->currency . ' ' . number_format($claim->amount, 2) }}</td>
                                    <td>{{ $claim->response_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="label label-{{ $claim->is_closed ? 'success' : 'danger' }}">{{ $claim->is_closed ? 'Cerrada' : 'En Proceso' }}</span>
                                    </td>
                                    <td>{{ $claim->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $claim->created_by_name }}</td>
                                    <td align="center">
                                        <a
                                            href=""
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            href="{{ route('customer.claim.show', array_merge(['id' => $claim->id], Request::all())) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Reclamación">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $claims->links() }}
                </div>
            </div>
        </div>

    </div>


    @if (!can_not_do('customer_claim_ctdc'))
        <div class="row" style="border-top: 1px solid #777;margin-top: 8px;margin-bottom: 25px;border-width: 5px;"></div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Reclamaciones</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.ct_dc.create', ['type' => 'CT']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claim_types as $claim_type)
                                    <tr>
                                        <td>{{ $claim_type->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.ct_dc.edit', ['type' => 'CT', 'ct_dc' => $claim_type->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Canales de Distribución</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.ct_dc.create', ['type' => 'DC']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distribution_channels as $channel)
                                    <tr>
                                        <td>{{ $channel->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.ct_dc.edit', ['type' => 'DC', 'ct_dc' => $channel->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Reclamaciones VISA</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.ct_dc.create', ['type' => 'VISA']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre ES</th>
                                    <th>Nombre EN</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claim_types_visa as $claim_type_visa)
                                    <tr>
                                        <td>{{ $claim_type_visa->es_name }}</td>
                                        <td>{{ $claim_type_visa->en_name }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.ct_dc.edit', ['type' => 'VISA', 'ct_dc' => $claim_type_visa->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este vacanto?');

            if (!res) {
                vacant.prvacantDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
