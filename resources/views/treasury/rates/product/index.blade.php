@extends('layouts.master')

@section('title', 'Tesorería -> Tasas')

@section('page_title', 'Detalle del Producto ' . $product->name)

@if (can_not_do('treasury_rates'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-info btn-xs" href="{{ route('treasury.rates.index', Request::except(['product'])) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    <a class="btn btn-danger btn-xs" href="{{ route('treasury.rates.product.{product}.detail.create', ['product' => $product->id]) }}">Nuevo Detalle</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Secuencia</th>
                                <th>Descripción</th>

                                @if ($product->content == 'R')
                                    <th>Rangos</th>
                                @endif

                                <th>Activo</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->details as $detail)
                                <tr>
                                    <td>{{ $detail->sequence }}</td>
                                    <td>{{ $detail->descrip }}</td>

                                    @if ($product->content == 'R')
                                        <td>{{ $product->ranges }}</td>
                                    @endif

                                    <td>{{ $detail->is_active ? 'Si':'No' }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('treasury.rates.product.{product}.detail.edit', ['detail' => $detail->id, 'product' => $product->id]) }}"
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

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
