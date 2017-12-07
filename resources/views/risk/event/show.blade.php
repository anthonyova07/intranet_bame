@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Evento de Riesgo Operacional #' . ($risk_event->event_code ? $risk_event->event_code : '(No asignado)'))

{{-- @if (can_not_do('risk_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('risk.event.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-6" style="padding: 0 2px;">
                        <a class="btn btn-danger btn-block" href="{{ route('risk.event.index', Request::all()) }}"><i class="fa fa-remove"></i> No es Evento</a>
                    </div>
                    <div class="col-xs-6" style="padding: 0 2px;">
                        <a class="btn btn-success btn-block" href="{{ route('risk.event.index', Request::all()) }}"><i class="fa fa-check"></i> Es Evento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos del Evento</h3>
                    <span class="pull-right" style="margin-top: -18px;">
                        Creado por: {{ $risk_event->createname }} el {{ $risk_event->created_at->format('d/m/Y h:i a') }}
                    </span>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#detalle" data-toggle="tab"><b>Detalle</b></a></li>
                        <li><a href="#evaluacion" data-toggle="tab"><b>Evaluación</b></a></li>
                    </ul>

                    <div class="tab-content" style="margin-top: 10px;">

                        <div class="tab-pane active" id="detalle">

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Linea de Negocio</label>
                                        <p class="form-control-static">{{ $risk_event->business_line->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Evento</label>
                                        <p class="form-control-static">{{ $risk_event->event->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Divisa</label>
                                        <p class="form-control-static">{{ $risk_event->currency_type->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Sucursal</label>
                                        <p class="form-control-static">{{ $risk_event->branch_office->note }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Área o Departamento</label>
                                        <p class="form-control-static">{{ $risk_event->area_department->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Canal de Distribución</label>
                                        <p class="form-control-static">{{ $risk_event->distribution_channel->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Proceso</label>
                                        <p class="form-control-static">{{ $risk_event->pro->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">SubProceso</label>
                                        <p class="form-control-static">{{ $risk_event->subpro->note }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->descriptio) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Consecuencia</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->consequenc) }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Control Asociado</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->assoc_cont) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="evaluacion">

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Pérdida</label>
                                        <p class="form-control-static">{{ $risk_event->loss ? $risk_event->loss->note : '' }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Evento</label>
                                        <p class="form-control-static">{{ $risk_event->event->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Divisa</label>
                                        <p class="form-control-static">{{ $risk_event->currency_type->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Sucursal</label>
                                        <p class="form-control-static">{{ $risk_event->branch_office->note }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Área o Departamento</label>
                                        <p class="form-control-static">{{ $risk_event->area_department->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Canal de Distribución</label>
                                        <p class="form-control-static">{{ $risk_event->distribution_channel->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">Proceso</label>
                                        <p class="form-control-static">{{ $risk_event->pro->note }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label class="control-label">SubProceso</label>
                                        <p class="form-control-static">{{ $risk_event->subpro->note }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->descriptio) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Consecuencia</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->consequenc) }}</p>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Control Asociado</label>
                                        <p class="form-control-static">{{ nl2br($risk_event->assoc_cont) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function send_form(form, a) {
            $('#a_' + form).val(a);
            $('#form_' + form).submit();
        }

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este adjunto?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
