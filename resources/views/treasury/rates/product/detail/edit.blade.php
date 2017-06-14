@extends('layouts.master')

@section('title', 'Tesorería - Productos')

@section('page_title', 'Edición Detalle del Producto ' . $product_detail->product->name)

@if (can_not_do('treasury_rates'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('treasury.rates.product.{product}.detail.update', ['detail' => $product_detail->id, 'product' => $product_detail->pro_id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('sequence') ? ' has-error':'' }}">
                                    <label class="control-label">Secuencia</label>
                                    <input type="text" class="form-control input-sm" name="sequence" value="{{ $product_detail->sequence }}">
                                    <span class="help-block">{{ $errors->first('sequence') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control input-sm" name="description" value="{{ $product_detail->descrip }}">
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $product_detail->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('treasury.rates.product.index', ['product' => $product_detail->pro_id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
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
