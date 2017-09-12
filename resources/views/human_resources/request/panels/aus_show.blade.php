<div class="row">
    @include('human_resources.request.panels.colaborator_panel', [
        'human_resource_request' => $human_resource_request,
        'type' => $human_resource_request->reqtype,
    ])

    @include('human_resources.request.panels.supervisor_panel', [
        'human_resource_request' => $human_resource_request,
        'type' => $human_resource_request->reqtype,
    ])
</div>

<div class="row">
    @include('human_resources.request.panels.info_panel', [
        'human_resource_request' => $human_resource_request,
    ])

    @include('human_resources.request.panels.rhuser_panel', [
        'human_resource_request' => $human_resource_request,
    ])
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Detalle de la Solicitud ({{ rh_req_types($human_resource_request->reqtype) }})</h3>
            </div>

            <div class="panel-body">
                <div class="row text-center">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="radio">
                            <label style="font-size: 16px;font-weight: bold;">
                                <input type="radio" disabled name="permission_type" {{ $human_resource_request->detail->pertype == 'one_day' ? 'checked' : '' }} value="one_day"> Por un día o menos
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha</label>
                                        <input type="date" style="width: 135px;" readonly class="form-control input-sm" name="permission_date" value="{{ $human_resource_request->detail->pertype == 'one_day' ? $human_resource_request->detail->perdatfrom->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Hora Desde</label>
                                        <input type="time" readonly class="form-control input-sm" name="permission_time_from" value="{{ $human_resource_request->detail->pertimfrom }}">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('permission_time_to') ? ' has-error':'' }}">
                                        <label class="control-label">Hora Hasta</label>
                                        <input type="time" readonly class="form-control input-sm" name="permission_time_to" value="{{ $human_resource_request->detail->pertimto }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('user') == $human_resource_request->created_by || session('user') == session('employee')->supervisor_emp->useremp)
                    @include('human_resources.request.panels.reintegrate_form', [
                        'human_resource_request' => $human_resource_request,
                    ])
                @else
                    @include('human_resources.request.panels.reintegrate_form_show', [
                        'human_resource_request' => $human_resource_request,
                    ])
                @endif

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" style="font-size: 16px;">
                                Motivo del Permiso
                            </label>
                            <div class="radio" style="margin-top: 0px;">
                                <label style="font-weight: bold;">
                                    <input type="radio" disabled name="per" checked> {{ $human_resource_request->detail->reaforabse }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="control-label" style="font-size: 16px;">
                                Adjuntos
                            </label>
                            <div style="margin-top: 0px;">
                                <ul class="list-group">
                                    @foreach ($human_resource_request->files() as $file)
                                        <li class="list-group-item" style="font-size: 15px;padding: 5px;">
                                            <a href="{{ route('human_resources.request.downloadattach', ['request_id' => $human_resource_request->id, 'file_name' => $file]) }}">{{ $file }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
