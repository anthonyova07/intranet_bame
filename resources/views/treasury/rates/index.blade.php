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
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
              <div class="panel-body">
                  <a style="font-size: 25px;padding: 15px;font-weight: bold;" class="btn btn-danger btn-xs btn-block" href="{{ route('treasury.rates.create') }}">Actualizar Tasa</a>
              </div>
            </div>
        </div>
    </div>

    <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
        <h1 style="margin: 0;text-align: center;">Mantenimiento de Parametros</h1>
    </div>

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">
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
                                <th style="width: 25px"></th>
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
                                        @if (in_array($product->content, ['V', 'R']))
                                            <a
                                                href="{{ route('treasury.rates.product.index', array_merge(['product' => $product->id], Request::all())) }}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ver Detalle de {{ $product->name }}">
                                                <i class="fa fa-share fa-fw"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
        <h1 style="margin: 0;text-align: center;">Histórico de Tasas</h1>
    </div>

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">

            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Búscar Tasas</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('treasury.rates.index') }}" id="form">
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
                            <div class="col-xs-12">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs btn-block" id="btn_submit" data-loading-text="Buscando tasas...">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th style="width: 112px;">Actualizado por</th>
                                <th style="width: 112px;">Fecha de Actualización</th>
                                {{-- <th>Fecha de la Tasa</th> --}}
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dates as $date)
                                <tr>
                                    <td>{{ $date->createname }}</td>
                                    <td>{{ $date->created_at->format('d/m/Y H:i:s') }}</td>
                                    {{-- <td>{{ $date->effec_date->format('d/m/Y') }}</td> --}}
                                    <td align="center">
                                        <a
                                            href="{{ route('treasury.rates.show', array_merge(['date' => $date->id], Request::all())) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Tasas Registradas">
                                            <i class="fa fa-share fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $dates->links() }}
                </div>
            </div>
        </div>

    </div>

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
