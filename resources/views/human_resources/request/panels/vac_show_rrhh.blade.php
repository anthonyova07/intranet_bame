@if (!can_not_do('human_resource_request'))
    <form method="post" action="{{ route('human_resources.request.savevacrhform', ['request_id' => $human_resource_request->id]) }}" id="form">
        @foreach (request()->only(['access']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <div class="row">
            <div class="col-xs-12">
                <h3 class="text-center" style="font-size: 16px;margin-top: 0px;">Para Uso de Recursos Humanos</h3>
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('vac_day_corresponding') ? ' has-error':'' }}">
                                <label class="control-label">Días Correspondientes</label>
                                <input type="number" class="form-control input-sm" name="vac_day_corresponding" value="{{ $human_resource_request->detail->dayscorres }}">
                                <span class="help-block">{{ $errors->first('vac_day_corresponding') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('vac_day_taken_at_moment') ? ' has-error':'' }}">
                                <label class="control-label">Días Tomados al Moment.</label>
                                <input type="number" class="form-control input-sm" name="vac_day_taken_at_moment" value="{{ $human_resource_request->detail->daystakedm }}">
                                <span class="help-block">{{ $errors->first('vac_day_taken_at_moment') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group{{ $errors->first('vac_day_pending') ? ' has-error':'' }}">
                                <label class="control-label">Días Pendientes</label>
                                <input type="number" class="form-control input-sm" name="vac_day_pending" value="{{ $human_resource_request->detail->dayspendin }}">
                                <span class="help-block">{{ $errors->first('vac_day_pending') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_day_pending') ? ' has-error':'' }}">
                              <label class="control-label">Aplica Bono Vacacional / Año</label>
                              <div class="input-group">
                                  <span class="input-group-addon">
                                      <input type="checkbox" name="applybonus"{{ $human_resource_request->detail->applybonus ? ' checked' : '' }}>
                                  </span>
                                  <input type="text" class="form-control input-sm" name="bonusyear" placeholder="Año Corres." value="{{ $human_resource_request->detail->bonusyear }}">
                              </div>
                              <span class="help-block">{{ $errors->first('vac_day_pending') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('bonusrea') ? ' has-error':'' }}">
                                <label class="control-label">Motivo si Aplica Bono Vacacional</label>
                                <input type="text" class="form-control input-sm" name="bonusrea" value="{{ $human_resource_request->detail->bonusrea }}">
                                <span class="help-block">{{ $errors->first('bonusrea') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_bonus') ? ' has-error':'' }}">
                                <label class="control-label">Fecha a Pagar Bono (si aplica)</label>
                                <input type="date" class="form-control input-sm" name="vac_date_bonus" value="{{ $human_resource_request->detail->datebonus }}">
                                <span class="help-block">{{ $errors->first('vac_date_bonus') }}</span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group{{ $errors->first('vac_date_bonus_sd') ? ' has-error':'' }}">
                                <label class="control-label">Fecha a Pagar Diferencial <abbr title="Vacaciones">Vac.</abbr> (si aplica)</label>
                                <input type="date" class="form-control input-sm" name="vac_date_bonus_sd" value="{{ $human_resource_request->detail->datebonusd }}">
                                <span class="help-block">{{ $errors->first('vac_date_bonus_sd') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group{{ $errors->first('vac_note') ? ' has-error':'' }}">
                                <label class="control-label">Observaciones</label>
                                <textarea class="form-control input-sm" placeholder="Observación" name="vac_note">{{ $human_resource_request->detail->note }}</textarea>
                                <span class="help-block">{{ $errors->first('vac_note') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando...">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
