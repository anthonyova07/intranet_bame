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
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    @if (!in_array($human_resource_request->reqtype, ['CAR']))
                        <div class="form-group">
                            <label class="control-label">Motivo en Caso de Rechazo por RRHH</label>
                            <p class="form-control-static">{{ $human_resource_request->reasonreje }}</p>
                        </div>
                    @endif
                </div>
                @if (in_array($human_resource_request->reqtype, ['PER', 'AUS']))
                    <div class="col-xs-6">
                        @if (!can_not_do('human_resource_request'))
                            <form id="paid_form" action="{{ route('human_resources.request.paid', ['request_id' => $human_resource_request->id]) }}" method="post">
                                <label class="control-label">Remunerado</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="paid_check" data-toggle="tooltip" title="Remunerado" name="paid"{{ $human_resource_request->detail->paid ? ' checked':'' }}>
                                    </span>
                                    <input type="text" id="paid_reason" name="paid_reason" maxlength="500" data-toggle="tooltip" title="Motivo sino es remunerado" placeholder="Motivo sino es remunerado" class="form-control input-sm" value="{{ $human_resource_request->detail->paid_reason }}">
                                    <span class="input-group-btn">
                                        <input type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Enviando..." value="Enviar">
                                    </span>
                                </div>
                                {{ csrf_field() }}
                            </form>
                        @else
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" disabled id="paid_check" data-toggle="tooltip" title="Remunerado" name="paid"{{ $human_resource_request->detail->paid ? ' checked':'' }}>
                                </span>
                                <input type="text" disabled placeholder="Motivo sino es remunerado" class="form-control input-sm" value="{{ $human_resource_request->detail->paid_reason }}">
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#paid_form').submit(function (event) {
        $('#btn_submit').button('loading');
    });

    var paid_reason = $('#paid_reason');

    $('#paid_check').change(function () {
        if ($(this).is(':checked')) {
            paid_reason.prop('required', false);
        } else {
            paid_reason.prop('required', true);
        }
    });
</script>
