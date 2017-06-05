@extends('layouts.master')

@section('title', 'Tesorería - Productos')

@section('page_title', 'Nuevo Producto')

{{-- @if (can_not_do('treasury_rates_admin'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('treasury.rates.product.store') }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control input-sm" name="name" value="{{ old('name') }}">
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <label class="control-label">Tipo</label>
                                <select class="form-control input-sm" name="rate_type">
                                    @foreach (get_treasury_rate_types() as $key => $rate_type)
                                        <option value="{{ $key }}" {{ old('rate_type') == $key ? 'selected':'' }}>{{ $rate_type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-3">
                                <label class="control-label">Contenido</label>
                                <select class="form-control input-sm" name="content">
                                    @foreach (get_treasury_rate_contents() as $key => $content)
                                        <option value="{{ $key }}" {{ old('content') == $key ? 'selected':'' }}>{{ $content }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
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
    </script>

@endsection
