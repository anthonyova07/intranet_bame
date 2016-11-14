@extends('layouts.master')

@section('title', 'Reclamaciones - ' . get_ct_dc($ct_dc->type, false))

@section('page_title', 'Nuevo ' . get_ct_dc($ct_dc->type, false))

@if (can_not_do('customer_claim_ctdc'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        @if ($ct_dc->type == 'VISA')

            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{ route('customer.claim.{type}.ct_dc.update', ['type' => $ct_dc->type, 'ct_dc' => $ct_dc->id]) }}" id="form" novalidate>
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-10">
                                        <div class="form-group{{ $errors->first('es_name') ? ' has-error':'' }}">
                                            <label class="control-label">Nombre ES</label>
                                            <input type="text" class="form-control input-sm" name="es_name" placeholder="versión en español" value="{{ $ct_dc->es_name }}">
                                            <span class="help-block">{{ $errors->first('es_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="checkbox">
                                            <label style="margin-top: 18px;">
                                                <input type="checkbox" name="is_active" {{ $ct_dc->is_active ? 'checked' : '' }}> Activo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('es_detail') ? ' has-error':'' }}">
                                            <label class="control-label">Detalle ES</label>
                                            <input type="text" class="form-control input-sm" name="es_detail" placeholder="versión en español" value="{{ $ct_dc->es_detail }}">
                                            <span class="help-block">{{ $errors->first('es_detail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('es_detail_2') ? ' has-error':'' }}">
                                            <label class="control-label">Detalle 2 ES</label>
                                            <input type="text" class="form-control input-sm" name="es_detail_2" placeholder="versión en español" value="{{ $ct_dc->es_detail_2 }}">
                                            <span class="help-block">{{ $errors->first('es_detail_2') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('en_name') ? ' has-error':'' }}">
                                            <label class="control-label">Nombre EN</label>
                                            <input type="text" class="form-control input-sm" name="en_name" placeholder="versión en ingles" value="{{ $ct_dc->en_name }}">
                                            <span class="help-block">{{ $errors->first('en_name') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('en_detail') ? ' has-error':'' }}">
                                            <label class="control-label">Detalle EN</label>
                                            <input type="text" class="form-control input-sm" name="en_detail" placeholder="versión en ingles" value="{{ $ct_dc->en_detail }}">
                                            <span class="help-block">{{ $errors->first('en_detail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group{{ $errors->first('en_detail_2') ? ' has-error':'' }}">
                                            <label class="control-label">Detalle 2 EN</label>
                                            <input type="text" class="form-control input-sm" name="en_detail_2" placeholder="versión en ingles" value="{{ $ct_dc->en_detail_2 }}">
                                            <span class="help-block">{{ $errors->first('en_detail_2') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.claim.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

        @else

            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{ route('customer.claim.{type}.ct_dc.update', ['type' => $ct_dc->type, 'ct_dc' => $ct_dc->id]) }}" id="form" novalidate>
                            <div class="row">
                                <div class="col-xs-10">
                                    <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                        <label class="control-label">Descripción</label>
                                        <input type="text" class="form-control input-sm" name="description" value="{{ $ct_dc->description }}">
                                        <span class="help-block">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="checkbox">
                                        <label style="margin-top: 18px;">
                                            <input type="checkbox" name="is_active" {{ $ct_dc->is_active ? 'checked' : '' }}> Activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('customer.claim.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

        @endif

    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
