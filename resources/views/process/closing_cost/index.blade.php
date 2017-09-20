@extends('layouts.master')

@section('title', 'Procesos -> Costos de Cierre')

@section('page_title', 'Costos de Cierre')

{{-- @if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Solicitud</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('process.closing_cost.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('credit_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Crédito</label>
                                    <select class="form-control input-sm" name="credit_type">
                                        <option value="">Todos</option>
                                        @foreach ($credits_type as $credit_type)
                                            <option value="{{ $credit_type->id }}" {{ old('credit_type') == $credit_type->id ? 'selected':'' }}>{{ $credit_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('credit_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('warranty_type') ? ' has-error':'' }}">
                                    <label class="control-label">Tipo de Garantía</label>
                                    <select class="form-control input-sm" name="warranty_type">
                                        <option value="">Todos</option>
                                        @foreach ($warranties_type as $warranty_type)
                                            <option value="{{ $warranty_type->id }}" {{ old('warranty_type') == $warranty_type->id ? 'selected':'' }}>{{ $warranty_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('warranty_type') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando...">Buscar</button>
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
                    <a class="btn btn-danger btn-xs" href="{{ route('process.closing_cost.create') }}">Nuevo Gasto de Cierre</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Tipo de Crédito</th>
                                <th>Tipo de Garantía</th>
                                <th>Rangos</th>
                                <th>Tarifa</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($closing_costs as $closing_cost)
                                <tr>
                                    <td>{{ $closing_cost->reqnumber }}</td>
                                    <td>{{ $closing_cost->reqtype }}</td>
                                    <td>{{ $closing_cost->process }}</td>
                                    <td>{{ $closing_cost->reqstatus }}</td>
                                    <td>{{ $closing_cost->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $closing_cost->createname }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('process.request.show', array_merge(['request' => $closing_cost->id], Request::all())) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Solicitud">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>

                    {{ $closing_costs->links() }}
                </div>
            </div>
        </div>

    </div>


    {{-- @if (!can_not_do('process_request_admin')) --}}
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Crédito</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('process.closing_cost.{type}.param.create', ['type' => 'TIPCRE']) }}">Nuevo</a>
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
                                @foreach ($credits_type as $credit_type)
                                    <tr>
                                        <td>{{ $credit_type->name }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('process.closing_cost.{type}.param.edit', ['type' => 'TIPCRE', 'param' => $credit_type->id]) }}"
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
                        <h3 class="panel-title">Tipos de Garantía</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('process.closing_cost.{type}.param.create', ['type' => 'TIPGAR']) }}">Nuevo</a>
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
                                @foreach ($warranties_type as $warranty_type)
                                    <tr>
                                        <td>{{ $warranty_type->name }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('process.closing_cost.{type}.param.edit', ['type' => 'TIPGAR', 'param' => $warranty_type->id]) }}"
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

        </div>

    {{-- @endif --}}

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
