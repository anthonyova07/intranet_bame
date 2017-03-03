@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Solicitud de Proceso #' . $process_request->reqnumber)

@if (can_not_do('process_request'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('process.request.index', Request::all()) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos de la Solicitud Estatus:
                        @if (!$process_request->requested)
                            @if ($process_request->getStatus() === '0')
                                Rechazada
                            @elseif ($process_request->getStatus() === '1')
                                Aprobada
                            @else
                                Pendiente
                            @endif
                        @else
                            Solicitada
                        @endif
                    </h3>
                    <span>
                        Solicitada por: {{ $process_request->createname }} el {{ $process_request->created_at->format('d/m/Y H:i:s') }}
                    </span>
                    @if ($process_request->reqstatus)
                        <span class="pull-right">
                            Estatus: {{ $process_request->reqstatus }}
                        </span>
                    @endif
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#datos_solicitud" data-toggle="tab"><b>Detalle</b></a></li>
                        <li><a href="#datos_aprobacion" data-toggle="tab"><b>Aprobaciones</b></a></li>
                        <li><a href="#datos_estatus" data-toggle="tab"><b>Estatus</b></a></li>
                        <li><a href="#datos_adjuntos" data-toggle="tab"><b>Adjuntos</b></a></li>
                    </ul>

                    <div class="tab-content" style="margin-top: 10px;">
                        <div class="tab-pane active" id="datos_solicitud">

                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Tipo de Solicitud</label>
                                        <br>
                                        <span class="form-control-static">{{ $process_request->reqtype }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Proceso Impactado</label>
                                        <br>
                                        <span class="form-control-static">{{ $process_request->process }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Subproceso Impactado</label>
                                        <br>
                                        <span class="form-control-static">{{ $process_request->subprocess }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <textarea class="form-control input-sm" readonly="readonly" rows="5" name="description">{{ $process_request->note }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Análisis de Causa</label>
                                        <textarea class="form-control input-sm" readonly="readonly" rows="5" name="cause_analysis">{{ $process_request->causeanaly }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Personas que Intervinieron en el Análisis</label>
                                        <textarea class="form-control input-sm" readonly="readonly" rows="5" name="people_involved">{{ $process_request->peoinvolve }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label">Entregables</label>
                                        <textarea class="form-control input-sm" readonly="readonly" rows="5" name="deliverable">{{ $process_request->deliverabl }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Observaciones</label>
                                        <textarea class="form-control input-sm" readonly="readonly" rows="5" name="observations">{{ $process_request->observatio }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="datos_aprobacion">

                            @if (!can_not_do('process_request_admin') && !$is_approved)
                                <div class="row">
                                    <div class="col-xs-8 col-xs-offset-2">
                                        <form action="{{ route('process.request.addusers', ['process_request' => $process_request->id]) }}" method="post">
                                            <div class="col-xs-10">
                                                <div class="text-center form-group{{ $errors->first('users') ? ' has-error':'' }}">
                                                    <label class="control-label" style="font-size: 16px;">Agregar Usuarios</label>
                                                    <input type="text" name="users" class="form-control input-sm">
                                                    <span class="help-block">{{ $errors->first('users') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                {{ csrf_field() }}
                                                <button style="margin-top: 26px;" type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Agregar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                        <thead>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            {{-- <th>Comentario</th> --}}
                                            <th style="width: 116px;">Fecha</th>
                                            <th style="width: 170px;"></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($process_request->approvals as $approval)
                                                <tr>
                                                    <td>{{ $approval->userapprov }}</td>
                                                    <td>{{ $approval->username }}</td>
                                                    {{-- <td>{{ $approval->comment }}</td> --}}
                                                    <td>{{ $approval->approvdate ? $approval->approvdate->format('d/m/Y H:i:s'):'' }}</td>
                                                    <td class="text-center">
                                                        @if ($approval->approved === '0')
                                                            <span style="font-size: 14px;letter-spacing: 1px;" class="label label-danger">Rechazada</span>
                                                        @elseif ($approval->approved === '1')
                                                            <span style="font-size: 14px;letter-spacing: 1px;" class="label label-success">Aprobada</span>
                                                        @else
                                                            <span style="font-size: 14px;letter-spacing: 1px;" class="label label-warning">Pendiente</span>
                                                        @endif

                                                        @if (!$is_approved)
                                                            @if (!can_not_do('process_request_approval'))
                                                                @if ($approval->userapprov === session()->get('user'))
                                                                    <a
                                                                        href="{{ route('process.request.approval', ['process_request' => $process_request->id, 'a' => '1']) }}"
                                                                        class="link_activar verde"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        style="font-size: 20px;"
                                                                        title="Aprobar">
                                                                        <i class="fa fa-check fa-fw"></i>
                                                                    </a>
                                                                    <a
                                                                        href="{{ route('process.request.approval', ['process_request' => $process_request->id, 'a' => '0']) }}"
                                                                        class="link_anular rojo"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        style="font-size: 20px;"
                                                                        title="Rechazar">
                                                                        <i class="fa fa-times fa-fw"></i>
                                                                    </a>
                                                                @endif
                                                            @endif

                                                            @if (!can_not_do('process_request_admin'))
                                                                <a
                                                                    href="{{ route('process.request.deleteuser', ['process_request' => $process_request->id, 'u' => $approval->userapprov]) }}"
                                                                    class="link_anular rojo"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    style="font-size: 20px;"
                                                                    title="Eliminar Aprobación">
                                                                    <i class="fa fa-trash fa-fw"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="datos_estatus">

                            @if (!can_not_do('process_request_admin') && !$is_approved)
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form action="{{ route('process.request.addstatus', ['process_request' => $process_request->id]) }}" method="post">
                                            <div class="col-xs-3">
                                                <div class="form-group{{ $errors->first('status') ? ' has-error':'' }}">
                                                    <label class="control-label" style="font-size: 16px;">Estatus</label>
                                                    <select class="form-control input-sm" name="status">
                                                        <option value="">Seleccione un Estatus</option>
                                                        @foreach ($status->sortBy('note') as $s)
                                                            <option value="{{ $s->id }}"{{ old('status') == $s->id ? ' selected':'' }}>{{ $s->note }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block">{{ $errors->first('status') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="form-group{{ $errors->first('comment') ? ' has-error':'' }}">
                                                    <label class="control-label" style="font-size: 16px;">Comentario</label>
                                                    <input type="text" name="comment" class="form-control input-sm">
                                                    <span class="help-block">{{ $errors->first('comment') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                {{ csrf_field() }}
                                                <button style="margin-top: 26px;" type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Agregar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-bordered table-condensed table-striped table-hover">
                                        <thead>
                                            <th>Estatus</th>
                                            <th>Comentario</th>
                                            <th style="width: 116px;">Creado por</th>
                                            <th style="width: 116px;">Fecha</th>
                                        </thead>
                                        <tbody>
                                            @if ($process_request->status)
                                                @foreach ($process_request->status->sortByDesc('created_at') as $status)
                                                    <tr>
                                                        <td>{{ $status->status }}</td>
                                                        <td>{{ $status->comment }}</td>
                                                        <td>{{ $status->createname }}</td>
                                                        <td>{{ $status->created_at->format('d/m/Y H:i:s') }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="datos_adjuntos">

                            @if (!can_not_do('process_request_admin') && !$is_approved)
                                <div class="row">
                                    <div class="col-xs-12">
                                        <form method="post" action="{{ route('process.request.addattach', ['process_request' => $process_request->id]) }}" id="form" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <div class="form-group{{ $errors->first('files') ? ' has-error':'' }}">
                                                        <label class="control-label">Archivos <div class="label label-warning"> MAX: 10MB</div></label>
                                                        <input type="file" name="files[]" multiple>
                                                        <span class="help-block">{{ $errors->first('files') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    {{ csrf_field() }}
                                                    <button style="margin-top: 16px;" type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Subiendo archivos...">Subir</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                                        <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th style="width: 90px;">Subido por</th>
                                                <th style="width: 10px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($process_request->attaches as $attach)
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        <a href="{{ route('process.request.downloadattach', ['process_request' => $process_request->id, 'attach' => $attach->id]) }}" target="__blank" style="font-size: 16px;">{{ $attach->file }}</a>
                                                    </td>
                                                    <td style="font-size: 14px;vertical-align: middle;">
                                                        {{ $attach->createname }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if (!$is_approved)
                                                            <a
                                                                onclick="cancel('{{ $attach->id }}', this)"
                                                                href="javascript:void(0)"
                                                                style="font-size: 20px;"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Eliminar Adjunto {{ $attach->file }}"
                                                                class="rojo link_anular">
                                                                <i class="fa fa-trash fa-fw"></i>
                                                            </a>
                                                            <form
                                                                style="display: none;"
                                                                action="{{ route('process.request.deleteattach', ['process_request' => $process_request->id,'attach' => $attach->id]) }}"
                                                                method="post" id="form_eliminar_{{ $attach->id }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
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

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('select[name=process]').change(function (e) {
            var process = $(this).val();
            var subprocess = $('select[name=subprocess]');
            subprocess.show();

            $('select[name=subprocess] option').each(function (index, value) {
                var parent = $(this).attr('parent');

                if (process == parent) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

                subprocess.val(-1);
            });
        });

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
