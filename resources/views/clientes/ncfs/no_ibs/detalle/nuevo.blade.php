\@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Nueva Transacción (No IBS)')

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('clientes::ncfs::no_ibs::detalle::nuevo') }}" id="form_consulta">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('descripcion') ? ' has-error':'' }}">
                                    <label class="control-label">Descripción</label>
                                    <input type="text" class="form-control" name="descripcion" value="{{ old('descripcion') }}">
                                    <span class="help-block">{{ $errors->first('descripcion') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('monto') ? ' has-error':'' }}">
                                    <label class="control-label">Monto</label>
                                    <input type="text" class="form-control input_money" name="monto" value="{{ old('monto') }}">
                                    <span class="help-block">{{ $errors->first('monto') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('dia') ? ' has-error':'' }}">
                                    <label class="control-label">Día</label>
                                    <input type="number" class="form-control" name="dia" value="{{ old('dia') }}" max="31" min="1">
                                    <span class="help-block">{{ $errors->first('dia') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('mes') ? ' has-error':'' }}">
                                    <label class="control-label">Mes</label>
                                    <select class="form-control" name="mes">
                                        @foreach (get_months() as $key => $mes)
                                            <option value="{{ $key }}" {{ old('mes') == $key ? 'selected':'' }}>{{ $mes }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('mes') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group{{ $errors->first('anio') ? ' has-error':'' }}">
                                    <label class="control-label">Año</label>
                                    <input type="number" class="form-control" name="anio" value="{{ old('anio') ? old('anio'):(new DateTime)->format('Y') }}" max="{{ (new DateTime)->format('Y') }}" min="2015">
                                    <span class="help-block">{{ $errors->first('anio') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a href="{{ route('clientes::ncfs::no_ibs::nuevo') }}" class="btn btn-default btn-sm">Cancelar</a>
                        <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
