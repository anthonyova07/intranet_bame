@extends('layouts.master')

@section('title', 'Tesorería -> Tasas')

@section('page_title', 'Mantenimiento de Tasas')

@if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Solicitud</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('process.request.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando tasas...">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('treasury.rates.create') }}">Nueva Tasa</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Fecha de la Tasa</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 112px;">Creado por</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($process_requests as $process_request)
                                <tr>
                                    <td>{{ $process_request->reqnumber }}</td>
                                    <td>{{ $process_request->reqtype }}</td>
                                    <td>{{ $process_request->process }}</td>
                                    <td>{{ $process_request->reqstatus }}</td>
                                    <td>{{ $process_request->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $process_request->createname }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('process.request.show', array_merge(['request' => $process_request->id], Request::all())) }}"
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

                    {{-- {{ $process_requests->links() }} --}}
                </div>
            </div>
        </div>

    </div>


    {{-- @if (!can_not_do('treasury_rates_admin')) --}}
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

            <div class="col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tipos de Productos</h3>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-danger btn-xs" href="{{ route('treasury.rates.product.create') }}">Nuevo</a>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Contenido</th>
                                    <th>Activo</th>
                                    <th style="width: 2px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ get_treasury_rate_types($product->rate_type) }}</td>
                                        <td>{{ get_treasury_rate_contents($product->content) }}</td>
                                        <td>{{ $product->is_active ? 'Si':'No' }}</td>
                                        <td align="center">
                                            <a
                                                href="{{ route('treasury.rates.product.edit', ['id' => $product->id]) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Editar"
                                                class="naranja">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                            <a
                                                href="{{ route('treasury.rates.product.index', array_merge(['product' => $product->id], Request::all())) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ver Solicitud">
                                                <i class="fa fa-share fa-fw"></i>
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
