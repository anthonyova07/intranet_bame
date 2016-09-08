@extends('layouts.master')

@section('title', 'Clientes - NCF')

@section('page_title', 'Editar Detalle (Divisas)')

@if (can_not_do('clientes_ncf'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" action="{{ route('clientes::ncfs::divisas::editar', ['id' => $transaccion->ID]) }}" id="form_consulta">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('descripcion') ? ' has-error':'' }}">
                                <label class="control-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" value="{{ $transaccion->DESCRIPCION }}">
                                <span class="help-block">{{ $errors->first('descripcion') }}</span>
                            </div>
                            <div class="form-group{{ $errors->first('monto') ? ' has-error':'' }}">
                                <label class="control-label">Monto</label>
                                <input type="text" class="form-control input_money" name="monto" value="{{ str_replace(',', '', $transaccion->MONTO) }}">
                                <span class="help-block">{{ $errors->first('monto') }}</span>
                            </div>
                            <div class="pull-right">
                                {{ csrf_field() }}
                                <a href="{{ route('clientes::ncfs::divisas::nuevo') }}" class="btn btn-default">Cancelar</a>
                                <button type="submit" class="btn btn-danger" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
