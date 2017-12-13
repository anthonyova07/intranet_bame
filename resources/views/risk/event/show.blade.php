@extends('layouts.master')

@section('title', 'Riesgo - Eventos')

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

    @if ($risk_event->is_event == null)
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-6" style="padding: 0 2px;">
                            <a class="btn btn-danger btn-block" href="{{ route('risk.event.mark_event', array_merge(Request::all(), ['risk_event' => $risk_event->id, 'is_event' => 0])) }}"><i class="fa fa-remove"></i> No es Evento</a>
                        </div>
                        <div class="col-xs-6" style="padding: 0 2px;">
                            <a class="btn btn-success btn-block" href="{{ route('risk.event.mark_event', array_merge(Request::all(), ['risk_event' => $risk_event->id, 'is_event' => 1])) }}"><i class="fa fa-check"></i> Es Evento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                        @if ($risk_event->is_event)
                            <li><a href="#evaluacion" data-toggle="tab"><b>Evaluación</b></a></li>
                            <li><a href="#contabilidad" data-toggle="tab"><b>Contabilidad</b></a></li>
                        @endif
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

                        @if ($risk_event->is_event)
                            <div class="tab-pane" id="evaluacion">

                                <form method="post" action="{{ route('risk.event.save_evaluation', $risk_event->id) }}" id="form">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('loss_type') ? ' has-error':'' }}">
                                                <label class="control-label">Tipo de Pérdida</label>
                                                <select class="form-control input-sm" name="loss_type">
                                                    <option value="">Selecciona uno</option>
                                                    @foreach ($params->where('type', 'TP') as $param)
                                                        <option value="{{ $param->id }}" {{ $risk_event->loss_type == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">{{ $errors->first('loss_type') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label class="control-label">Código de Evento</label>
                                                <p class="form-control-static">{{ $risk_event->event_code or '(No asignado)' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('risk_link') ? ' has-error':'' }}">
                                                <label class="control-label">Riesgo Vinculado</label>
                                                <select class="form-control input-sm" name="risk_link">
                                                    <option value="">Selecciona uno</option>
                                                    @foreach ($params->where('type', 'RV') as $param)
                                                        <option value="{{ $param->id }}" {{ $risk_event->risk_link == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">{{ $errors->first('risk_link') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('risk_factor') ? ' has-error':'' }}">
                                                <label class="control-label">Factor de Riesgo</label>
                                                <select class="form-control input-sm" name="risk_factor">
                                                    <option value="">Selecciona uno</option>
                                                    @foreach ($params->where('type', 'FR') as $param)
                                                        <option value="{{ $param->id }}" {{ $risk_event->risk_facto == $param->id ? 'selected':'' }}>{{ $param->note }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">{{ $errors->first('risk_factor') }}</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('event_start') ? ' has-error':'' }}">
                                                <label class="control-label">Fecha de Inicio del Evento</label>
                                                <input type="date" class="form-control input-sm" name="event_start" value="{{ $risk_event->event_star }}">
                                                <span class="help-block">{{ $errors->first('event_start') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('event_end') ? ' has-error':'' }}">
                                                <label class="control-label">Fecha de Finalización del Evento</label>
                                                <input type="date" class="form-control input-sm" name="event_end" value="{{ $risk_event->event_end }}">
                                                <span class="help-block">{{ $errors->first('event_end') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('event_disc') ? ' has-error':'' }}">
                                                <label class="control-label">Fecha Descubrimiento del Evento</label>
                                                <input type="date" class="form-control input-sm" name="event_disc" value="{{ $risk_event->event_disc }}">
                                                <span class="help-block">{{ $errors->first('event_disc') }}</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label class="control-label">Creado por</label>
                                                <p class="form-control-static">{{ $risk_event->rcreatenam }}</p>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label class="control-label">Creado el</label>
                                                <p class="form-control-static">{{ $risk_event->rcreatedat ? date_create($risk_event->rcreatedat)->format('d/m/Y') : '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane" id="contabilidad">

                                <form method="post" action="{{ route('risk.event.save_accounting', $risk_event->id) }}" id="form">

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group{{ $errors->first('post_date') ? ' has-error':'' }}">
                                                <label class="control-label">Fecha de Contabilización</label>
                                                <input type="date" class="form-control input-sm" name="post_date" value="{{ $risk_event->post_date }}">
                                                <span class="help-block">{{ $errors->first('post_date') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-6">
                                            <div class="form-group{{ $errors->first('account') ? ' has-error':'' }}">
                                                <label class="control-label">Cuenta Contable</label>
                                                <input type="text" class="form-control input-sm" placeholder="0000000000" name="account" value="{{ $risk_event->account }}">
                                                <span class="help-block">{{ $errors->first('account') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('amount_nac') ? ' has-error':'' }}">
                                                <label class="control-label">Monto Perdida RD$</label>
                                                <input type="text" class="form-control input-sm input_money" placeholder="0.00" name="amount_nac" value="{{ $risk_event->amount_nac }}">
                                                <span class="help-block">{{ $errors->first('amount_nac') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('amount_ori') ? ' has-error':'' }}">
                                                <label class="control-label">Monto Perdida Moneda Origen</label>
                                                <input type="text" class="form-control input-sm input_money" placeholder="0.00" name="amount_ori" value="{{ $risk_event->amount_ori }}">
                                                <span class="help-block">{{ $errors->first('amount_ori') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('amount_ins') ? ' has-error':'' }}">
                                                <label class="control-label">Monto Recuperado por Seguro</label>
                                                <input type="text" class="form-control input-sm input_money" placeholder="0.00" name="amount_ins" value="{{ $risk_event->amount_ins }}">
                                                <span class="help-block">{{ $errors->first('amount_ins') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group{{ $errors->first('amount_rec') ? ' has-error':'' }}">
                                                <label class="control-label">Monto Recuperado</label>
                                                <input type="text" class="form-control input-sm input_money" placeholder="0.00" name="amount_rec" value="{{ $risk_event->amount_rec }}">
                                                <span class="help-block">{{ $errors->first('amount_rec') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label class="control-label">Creado por</label>
                                                <p class="form-control-static">{{ $risk_event->ccreatenam }}</p>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label class="control-label">Creado el</label>
                                                <p class="form-control-static">{{ $risk_event->ccreatedat ? date_create($risk_event->ccreatedat)->format('d/m/Y') : '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-4">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        @endif

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
