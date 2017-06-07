@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Tasas de Interés Vigencia desde el 05/04/2017')

@section('contents')

    <div class="row">

        <div class="col-xs-8 col-xs-offset-2">

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 9px 15px;">
                        <h4 class="panel-title" style="font-size: 25px;">
                            <a data-toggle="collapse" data-parent="#faqs" href="#activos">
                                Activas
                            </a>
                        </h4>
                    </div>
                    <div id="activos" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group" id="activos_1">

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#activos_1" href="#activos_producto_1">
                                                Tasas Préstamos RD$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="activos_producto_1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Comercial</td>
                                                        <td>22.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Comercial Pyme</td>
                                                        <td>21.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Consumo hasta RD$ 100,000.00</td>
                                                        <td>28.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Consumo entre RD$ 100,001 y RD$ 300,000</td>
                                                        <td>26.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Consumo a partir de RD$ 300,001 en adelante</td>
                                                        <td>25.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Consumo Garantía Hipotecaria</td>
                                                        <td>22.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hipotecarios</td>
                                                        <td>16.95%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vehículos Nuevos</td>
                                                        <td>18.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vehículos Usados</td>
                                                        <td>24.00%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#activos_1" href="#activos_producto_2">
                                                Tasas Préstamos US$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="activos_producto_2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Comercial</td>
                                                        <td>10.25%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#activos_1" href="#activos_producto_3">
                                                Préstamos con Diferenciales
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="activos_producto_3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Préstamos en RD$ con Garantía de CF en RD$</td>
                                                        <td>8 puntos</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Préstamos en US$ con Garantía de CF en US$</td>
                                                        <td>6 puntos</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Préstamos en RD$ con Garantía de CF en US$</td>
                                                        <td>Consultar VP Negocios los casos</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 9px 15px;">
                        <h4 class="panel-title" style="font-size: 25px;">
                            <a data-toggle="collapse" data-parent="#faqs" href="#pasivas">
                                Pasivas
                            </a>
                        </h4>
                    </div>
                    <div id="pasivas" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group" id="pasivas_1">

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_1">
                                                Depósitos a Plazo Fijo RD$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6"></th>
                                                        <th colspan="2" class="text-center">Sin Redención Anticipada</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th>30 días</th>
                                                        <th>60 días</th>
                                                        <th>90 días</th>
                                                        <th>180 días</th>
                                                        <th>1 año</th>
                                                        <th>1.5 años</th>
                                                        <th>2 años</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10,000 - 49,000</td>
                                                        <td>6.00%</td>
                                                        <td>6.15%</td>
                                                        <td>6.25%</td>
                                                        <td>6.35%</td>
                                                        <td>6.50%</td>
                                                        <td>6.15%</td>
                                                        <td>6.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>50,000 - 99,000</td>
                                                        <td>6.15%</td>
                                                        <td>6.25%</td>
                                                        <td>6.35%</td>
                                                        <td>6.50%</td>
                                                        <td>6.75%</td>
                                                        <td>6.25%</td>
                                                        <td>6.35%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>100,000 - 499,999</td>
                                                        <td>6.50%</td>
                                                        <td>6.65%</td>
                                                        <td>6.75%</td>
                                                        <td>6.85%</td>
                                                        <td>7.00%</td>
                                                        <td>6.65%</td>
                                                        <td>6.75%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>500,000 - 999,999</td>
                                                        <td>7.00%</td>
                                                        <td>7.15%</td>
                                                        <td>7.25%</td>
                                                        <td>7.50%</td>
                                                        <td>7.75%</td>
                                                        <td>7.15%</td>
                                                        <td>7.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1,000,000 - 4,999,999</td>
                                                        <td>8.00%</td>
                                                        <td>8.15%</td>
                                                        <td>8.25%</td>
                                                        <td>8.50%</td>
                                                        <td>8.75%</td>
                                                        <td>8.15%</td>
                                                        <td>8.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5,000,000  en adelante</td>
                                                        <td>9.00%</td>
                                                        <td>9.10%</td>
                                                        <td>9.25%</td>
                                                        <td>9.35%</td>
                                                        <td>9.50%</td>
                                                        <td>9.10%</td>
                                                        <td>9.25%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_2">
                                                Depósitos a Plazo Fijo US$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>30 días</th>
                                                        <th>60 días</th>
                                                        <th>90 días</th>
                                                        <th>180 días</th>
                                                        <th>1 año</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>5,000 - 99,999</td>
                                                        <td>1.00%</td>
                                                        <td>1.25%</td>
                                                        <td>1.50%</td>
                                                        <td>1.75%</td>
                                                        <td>2.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>100,000- 399,999</td>
                                                        <td>1.75%</td>
                                                        <td>2.00%</td>
                                                        <td>2.25%</td>
                                                        <td>2.25%</td>
                                                        <td>2.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>400,000 - 699,999</td>
                                                        <td>1.75%</td>
                                                        <td>2.00%</td>
                                                        <td>2.25%</td>
                                                        <td>2.50%</td>
                                                        <td>2.75%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>700,000 - 999,999</td>
                                                        <td>2.25%</td>
                                                        <td>2.50%</td>
                                                        <td>2.75%</td>
                                                        <td>3.00%</td>
                                                        <td>3.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1,000,000 en adelante</td>
                                                        <td>2.75%</td>
                                                        <td>3.00%</td>
                                                        <td>3.25%</td>
                                                        <td>3.50%</td>
                                                        <td>3.50%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_3">
                                                Cuenta Corriente Remunerada
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 200,000</td>
                                                        <td>3.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 500,000</td>
                                                        <td>3.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 1,000,000</td>
                                                        <td>4.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 2,000,000</td>
                                                        <td>4.50%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_4">
                                                Cuenta de Ahorro más por menos RD$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 1,001</td>
                                                        <td>1.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 5,001</td>
                                                        <td>2.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 10,001</td>
                                                        <td>2.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 20,001</td>
                                                        <td>3.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 30,001</td>
                                                        <td>3.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de RD$ 50,001</td>
                                                        <td>4.00%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_5">
                                                Cuenta Corriente Remunerada sin Comisión
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Balance diario disponible a partir de RD$100,000</td>
                                                        <td>3.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance diario disponible a partir de RD$500,000</td>
                                                        <td>3.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance diario disponible a partir de RD$1,000,000</td>
                                                        <td>3.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance diario disponible a partir de RD$2,000,000</td>
                                                        <td>4.00%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_6">
                                                Cuenta de Ahorro más por menos US$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD101</td>
                                                        <td>0.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD251</td>
                                                        <td>0.50%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD401</td>
                                                        <td>0.75%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD601</td>
                                                        <td>1.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD801</td>
                                                        <td>1.25%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Para Bce Promedio a partir de USD1,001</td>
                                                        <td>1.50%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_7">
                                                Ahorro RD$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_7" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>2.00%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" style="padding: 6px 15px;background-color:#616365">
                                        <h4 class="panel-title" style="font-size: 20px;">
                                            <a data-toggle="collapse" data-parent="#pasivas_1" href="#pasivas_producto_8">
                                                Ahorro US$
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="pasivas_producto_8" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered table-condensed table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>1.00%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

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
