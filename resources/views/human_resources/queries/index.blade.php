@extends('layouts.master')

@section('title', 'Recursos Humanos -> Vacantes')

@section('page_title', 'Reportes de Recuersos Humanos')

@if (can_not_do('human_resources_queries'))
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
                            Reporte Cuentas tipo H201/H202/H251
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_cuentas') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Vinculados por gestión
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_vinculados_gestion') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Oficial Asignado (Bianca / Victoria)
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_oficial_asignado') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Relación del Cliente como Empleado
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_cliente_empleado') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Tarjetas Empleados
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_tdc_empleado') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-file-excel-o fa-4x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            Reporte Prestamos Empleados
                        </div>
                    </div>
                </div>
                <a href="{{ route('human_resources.queries.reporte_loan_empleado') }}">
                    <div class="panel-footer" style="padding: 2px 70px;">
                        <span class="pull-left">Descargar</span>
                        <span class="pull-right"><i class="fa fa-arrow-down"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#search_field').keyup(function (e) {
            var str = $(this).val().trim().toLowerCase();

            if (str != '') {
                $('#reports .col-xs-3').each(function (index, value) {
                    var tag = $(value);
                    var text = $(tag.children('div').children('div').children('div').children('div')[1]).text().trim();

                    if (text.toLowerCase().indexOf(str) >= 0) {
                        tag.show('slow');
                    } else {
                        tag.hide('slow');
                    }
                });
            } else {
                $('#reports .col-xs-3').each(function (index, value) {
                    $(value).show('slow');
                });
            }
        });
    </script>

@endsection
