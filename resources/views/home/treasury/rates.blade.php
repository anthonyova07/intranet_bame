@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@if ($backoffice)
    @section('page_title', 'Histórico de Tasas Interés - ' . ($date_history ? ('Actualizado en ' . $date_history->created_at->format('d/m/Y h:i:s a')) : 'No existen tasas definidas'))
@else
    @section('page_title', 'Tasas de Interés - ' . ($date_history ? ('Vigencia desde ' . $date_history->created_at->format('d/m/Y')) : 'No existen tasas definidas'))
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">

            @if ($backoffice)
                <div class="panel panel-default">
                    <div class="panel-body">
                    <a class="btn btn-info btn-xs" href="{{ route('treasury.rates.index', Request::except('date')) }}"><i class="fa fa-arrow-left"></i> Atras</a>
                    </div>
                </div>
            @endif

            <div class="panel-group" id="rates">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 9px 15px;">
                        <h4 class="panel-title" style="font-size: 25px;">
                            <a data-toggle="collapse" data-parent="#rates" href="#activos">
                                Activas
                            </a>
                        </h4>
                    </div>
                    <div id="activos" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group" id="activos_1">

                                @if ($date_history)
                                    @foreach ($date_history->products->where('rate_type', 'A')->sortBy('name') as $product)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                                <h4 class="panel-title" style="font-size: 20px;">
                                                    <a data-toggle="collapse" data-parent="#activos_1" href="#{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="{{ $product->id }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                                        @if ($product->content == 'U')
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $product->details->first()->value }}</td>
                                                                </tr>
                                                            </tbody>
                                                        @endif

                                                        @if ($product->content == 'V')
                                                            <tbody>
                                                                @foreach ($product->details as $detail)
                                                                    <tr>
                                                                        <td>{{ $detail->descrip }}</td>
                                                                        <td>{{ $detail->value }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @endif

                                                        @if ($product->content == 'R')
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    @foreach ($product->ranges() as $index => $range)
                                                                        <th>{{ $range }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($product->details->sortBy('sequence') as $detail)
                                                                    <tr>
                                                                        <td>{{ $detail->descrip }}</td>
                                                                        @foreach ($detail->ranges as $range)
                                                                            <td>{{ $range->value }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 9px 15px;">
                        <h4 class="panel-title" style="font-size: 25px;">

                            <a data-toggle="collapse" data-parent="#rates" href="#pasivas">
                                Pasivas
                            </a>
                        </h4>
                    </div>
                    <div id="pasivas" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group" id="pasivas_1">

                                @if ($date_history)
                                    @foreach ($date_history->products->where('rate_type', 'P')->sortBy('name') as $product)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                                <h4 class="panel-title" style="font-size: 20px;">
                                                    <a data-toggle="collapse" data-parent="#pasivas_1" href="#{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="{{ $product->id }}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                                        @if ($product->content == 'U')
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $product->details->first()->value }}</td>
                                                                </tr>
                                                            </tbody>
                                                        @endif

                                                        @if ($product->content == 'V')
                                                            <tbody>
                                                                @foreach ($product->details->sortBy('sequence') as $detail)
                                                                    <tr>
                                                                        <td>{{ $detail->descrip }}</td>
                                                                        <td>{{ $detail->value }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @endif

                                                        @if ($product->content == 'R')
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    @foreach ($product->ranges() as $index => $range)
                                                                        <th>{{ $range }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($product->details->sortBy('sequence') as $detail)
                                                                    <tr>
                                                                        <td>{{ $detail->descrip }}</td>
                                                                        @foreach ($detail->ranges as $range)
                                                                            <td>{{ $range->value }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

    </script>
@endsection
