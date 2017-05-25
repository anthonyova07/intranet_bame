@if (!can_not_do('human_resource_request_approverh'))
    <form method="post" action="{{ route('human_resources.request.saveantrhform', ['request_id' => $human_resource_request->id]) }}" id="form">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="text-center" style="font-size: 16px;margin-top: 0px;">Para Uso de Recursos Humanos</h3>
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('client_number') ? ' has-error':'' }}">
                                <label class="control-label"># Cliente</label>
                                <input type="text" class="form-control input-sm" name="client_number" value="{{ $human_resource_request->detail->clientnum }}">
                                <span class="help-block">{{ $errors->first('client_number') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('ant_advance_number') ? ' has-error':'' }}">
                                <label class="control-label"># Anticipo</label>
                                <input type="text" class="form-control input-sm" name="ant_advance_number" value="{{ $human_resource_request->detail->advnumber }}">
                                <span class="help-block">{{ $errors->first('ant_advance_number') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('ant_deposit_date') ? ' has-error':'' }}">
                                <label class="control-label">Fecha depósito del anticipo</label>
                                <input type="date" class="form-control input-sm" name="ant_deposit_date" value="{{ $human_resource_request->detail->advdatdepo }}">
                                <span class="help-block">{{ $errors->first('ant_deposit_date') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('ant_first_due_date') ? ' has-error':'' }}">
                                <label class="control-label">Fecha primer descuento</label>
                                <input type="date" class="form-control input-sm" name="ant_first_due_date" value="{{ $human_resource_request->detail->firsduedat }}">
                                <span class="help-block">{{ $errors->first('ant_first_due_date') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group{{ $errors->first('ant_last_due_date') ? ' has-error':'' }}">
                                <label class="control-label">Fecha último descuento</label>
                                <input type="date" class="form-control input-sm" name="ant_last_due_date" value="{{ $human_resource_request->detail->lastduedat }}">
                                <span class="help-block">{{ $errors->first('ant_last_due_date') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Comentarios</label>
                                <textarea class="form-control input-sm" placeholder="Comentario" name="ant_note">{{ $human_resource_request->detail->note }}</textarea>
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
    </form>
@endif
