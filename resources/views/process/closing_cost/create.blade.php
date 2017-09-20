@extends('layouts.master')

@section('title', 'Procesos - Gastos de Cierre')

@section('page_title', 'Carga de Gastos de Cierre desde Gestidoc')

@if (can_not_do('process_closing_cost'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <form method="post" action="{{ route('process.closing_cost.store') }}" id="form">
        @if ($closing_cost)
            <input type="hidden" name="exists" value="si">
        @endif

        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">URL Gasto de Cierre desde Gestidoc</h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('closing_cost') ? ' has-error':'' }}">
                                    <label class="control-label">URL Gasto de Cierre desde Gestidoc</label>
                                    <input type="text" class="form-control input-sm" name="closing_cost" value="{{ $closing_cost ? $closing_cost->closincost : '' }}">
                                    <span class="help-block">{{ $errors->first('closing_cost') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
