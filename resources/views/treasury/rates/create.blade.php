@extends('layouts.master')

@section('title', 'Tesorería - Tasas')

@section('page_title', 'Nueva Tasa')

{{-- @if (can_not_do('treasury_rates_admin'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')
    <form method="post" action="{{ route('treasury.rates.store') }}" id="form" novalidate>
        {{ csrf_field() }}
        <div class="row">

            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('effective_date') ? ' has-error':'' }}">
                                    <label class="control-label">Fecha de Vigencia</label>
                                    <input type="date" class="form-control input-sm" name="effective_date" value="{{ old('effective_date') }}">
                                    <span class="help-block">{{ $errors->first('effective_date') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-10 col-xs-offset-1">

                @foreach ($products as $product)

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered table-condensed table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td{!! $product->content == 'V' ? ' colspan="2"':'' !!} class="text-center" style="width: 50%;font-size: {{ $product->content == 'V' ? '18':'12' }}px;font-weight: bold;vertical-align: middle;">{{ $product->name }}</td>
                                        @if ($product->content == 'U')
                                            <td style="width: 50%;">
                                                <input type="text" class="form-control input-sm" name="{{ $product->content . '_' . $product->id }}">
                                            </td>
                                        @endif

                                        @if ($product->content == 'R')
                                            @foreach ($product->ranges() as $index => $range)
                                                <td class="text-center" style="vertical-align: middle;">{{ $range }}</td>
                                            @endforeach
                                        @endif
                                    </tr>

                                    @if ($product->content == 'V')
                                        @foreach ($product->details()->activeOnly()->get() as $detail)
                                            <tr>
                                                <td class="text-center" style="width: 50%;font-size: 12px;font-weight: bold;vertical-align: middle;">{{ $detail->descrip }}</td>
                                                <td style="width: 50%;">
                                                    <input type="text" class="form-control input-sm" name="{{ $product->content . '_' . $product->id . '_' . $detail->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if ($product->content == 'R')
                                        @foreach ($product->details()->activeOnly()->get() as $detail)
                                            <tr>
                                                <td class="text-center" style="width: 50%;font-size: 12px;font-weight: bold;vertical-align: middle;">{{ $detail->descrip }}</td>
                                                @foreach ($product->ranges() as $index => $range)
                                                    <td>
                                                        <input type="text" class="form-control input-sm" name="{{ $product->content . '_' . $product->id . '_' . $detail->id }}[]">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                @endforeach

                <div class="col-xs-4 col-xs-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a class="btn btn-info btn-xs" href="{{ route('treasury.rates.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
