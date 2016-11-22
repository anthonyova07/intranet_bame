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
                                        @if ($claim->is_approved == null)
                                            @if ($claim->is_approved == 0)
                                                <span style="letter-spacing: 1px;" class="label label-danger">No Aprobada</span>
                                            @endif
                                        @else
                                            <span style="letter-spacing: 1px;" class="label label-{{ $claim->is_closed ? 'success' : 'danger' }}">{{ $claim->is_closed ? 'Cerrada' : 'En Proceso' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $claim->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $claim->created_by_name }}</td>
                                    <td align="center">
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


    @if (!can_not_do('customer_claim_param'))
        <div class="row" style="border-top: 1px solid #777;margin-top: 8px;margin-bottom: 25px;border-width: 5px;"></div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Reclamaciones</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.param.create', ['type' => 'CT']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claim_types as $claim_type)
                                    <tr>
                                        <td>{{ $claim_type->code }}</td>
                                        <td>{{ $claim_type->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.param.edit', ['type' => 'CT', 'param' => $claim_type->id]) }}"
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
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.param.create', ['type' => 'DC']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distribution_channels as $channel)
                                    <tr>
                                        <td>{{ $channel->code }}</td>
                                        <td>{{ $channel->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.param.edit', ['type' => 'DC', 'param' => $channel->id]) }}"
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
                        <h3 class="panel-title">Tipos de Reclamaciones Tarjeta</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.param.create', ['type' => 'TDC']) }}">Nuevo</a>
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
                                                href="{{ route('customer.claim.{type}.param.edit', ['type' => 'TDC', 'param' => $claim_type_visa->id]) }}"
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
                        <h3 class="panel-title">Tipos de Persona</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.param.create', ['type' => 'KP']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kind_persons as $kind_person)
                                    <tr>
                                        <td>{{ $kind_person->code }}</td>
                                        <td>{{ $kind_person->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.param.edit', ['type' => 'KP', 'param' => $kind_person->id]) }}"
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
                        <h3 class="panel-title">Estatus de Reclamaciones</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('customer.claim.{type}.param.create', ['type' => 'CS']) }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th style="width: 36px;">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claim_statuses as $claim_status)
                                    <tr>
                                        <td>{{ $claim_status->code }}</td>
                                        <td>{{ $claim_status->description }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('customer.claim.{type}.param.edit', ['type' => 'KP', 'param' => $claim_status->id]) }}"
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
