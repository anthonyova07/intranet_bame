@extends('layouts.master')

@section('title', 'Tesorería -> Reportes')

@section('page_title', 'Reportes de Tesorería')

@if (can_not_do('treasury_queries'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
              <div class="panel-body">
                  <input type="text" id="search_field" placeholder="Busqueda rapida de reporte" class="form-control input-lg" autofocus>
              </div>
            </div>
        </div>
    </div>

    <div class="row" id="reports">
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Encaje Legal
                        </div>
                        <div class="col-xs-12">
                            <form id="form_encaje_legal">
                                <div class="col-xs-6" style="padding: 0 1px 0 0;">
                                    <select class="form-control input-sm" name="month_encaje_legal" style="margin-top: 6px;">
                                        @foreach (get_months() as $key => $value)
                                            @if ($datetime->format('m') == $key)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-6" style="padding: 0 0 0 1px;">
                                    <select class="form-control input-sm" name="currency_encaje_legal" style="margin-top: 6px;">
                                        <option value="DOP">Pesos</option>
                                        <option value="USD">Dolares</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="{{ route('treasury.queries.reporte_encaje_legal') }}" id="btn_encaje_legal">
                    <div class="panel-footer" style="padding: 2px 65px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        @include('layouts.functions_js.busqueda_rapida');

        $('#btn_encaje_legal').click(function (e) {
            // e.preventDefault();
            $(this).attr('href', $(this).attr('href') + '?' + $('#form_encaje_legal').serialize());
        });
    </script>

@endsection
