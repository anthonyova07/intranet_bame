@extends('layouts.master')

@section('title', 'Tesorería - Productos')

@section('page_title', 'Edición Producto')

{{-- @if (can_not_do('treasury_rates_admin'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('treasury.rates.product.update', ['id' => $product->id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ $product->name }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <label class="control-label">Tipo</label>
                                <select class="form-control input-sm" name="rate_type">
                                    @foreach (get_treasury_rate_types() as $key => $rate_type)
                                        <option value="{{ $key }}" {{ $product->rate_type == $key ? 'selected':'' }}>{{ $rate_type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <label class="control-label">Contenido</label>
                                <select class="form-control input-sm" name="content">
                                    @foreach (get_treasury_rate_contents() as $key => $content)
                                        <option value="{{ $key }}" {{ $product->content == $key ? 'selected':'' }}>{{ $content }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-3">
                                <div {!! $product->content == 'R' ? '':'style="display: none;"' !!} class="ranges form-group{{ $errors->first('ranges') ? ' has-error':'' }}">
                                    <label class="control-label">Rangos (Separados por Coma)</label>
                                    <input type="text" class="form-control input-sm" name="ranges" value="{{ $product->ranges }}">
                                    <span class="help-block">{{ $errors->first('ranges') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('treasury.rates.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
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

        @include('treasury.rates.product.partials.selector_ranges')
    </script>

@endsection
