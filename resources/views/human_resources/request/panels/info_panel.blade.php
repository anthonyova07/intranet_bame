<div class="col-xs-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                Datos de la Solicitud
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label"># de Solicitud</label>
                        <p class="form-control-static">{{ $human_resource_request->reqnumber }}</p>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label">Tipo de Solicitud</label>
                        <p class="form-control-static">{{ rh_req_types($human_resource_request->reqtype) }}</p>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label">Estado</label>
                        <p class="form-control-static">{{ $human_resource_request->reqstatus }}</p>
                    </div>
                    {{-- @if (can_not_do('human_resource_request_approverh'))
                        <div class="form-group">
                            <label class="control-label">Estado</label>
                            <p class="form-control-static">{{ $human_resource_request->reqstatus }}</p>
                        </div>
                    @else
                        <form method="post" action="{{ route('human_resources.request.changestatus', ['request_id' => $human_resource_request->id]) }}" id="form">
                            <div class="input-group">
                                <label class="control-label">Estado</label>
                                <select class="form-control input-sm" name="status">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $human_resource_request->reqstatus == $status->name ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn" style="padding-top: 23px;">
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                                </span>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    @endif --}}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-9">
                    <div class="form-group">
                        <label class="control-label">Motivo en Caso de Rechazo por RRHH</label>
                        <p class="form-control-static">{{ $human_resource_request->reasonreje }}</p>
                    </div>
                </div>
                <div class="col-xs-3">
                    <form name="paid_form" action="{{ route('human_resources.request.paid', ['request_id' => $human_resource_request->id]) }}" method="post">
                        <div class="radio" style="margin-top: 0px;">
                            <label style="font-weight: bold;">
                                @if (!can_not_do('human_resource_request_approverh'))
                                    <input type="checkbox" id="paid_button" name="paid"{{ $human_resource_request->detail->paid ? ' checked':'' }}> Remunerado
                                @else
                                    <input type="checkbox" disabled name="paid"{{ $human_resource_request->detail->paid ? ' checked':'' }}> Remunerado
                                @endif
                            </label>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#paid_button').change(function (e) {
        $('form[name=paid_form]').submit();
    });
</script>
