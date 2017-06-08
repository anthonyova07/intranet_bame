@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Tasas de Interés - Vigencia desde ' . $date_history->effec_date->format('d/m/Y'))

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">

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
