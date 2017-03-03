@extends('layouts.master')

@section('title', 'Reclamaciones - ' . get_proreq_param($param->type, false))

@section('page_title', 'Edición ' . get_proreq_param($param->type, false))

@if (can_not_do('process_request_admin'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('process.request.{type}.param.update', ['type' => $param->type, 'param' => $param->id]) }}" id="form" novalidate>
                        <div class="row">
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('code') ? ' has-error':'' }}">
                                    <label class="control-label">Código</label>
                                    <input type="text" class="form-control input-sm" name="code" value="{{ $param->code }}">
                                    <span class="help-block">{{ $errors->first('code') }}</span>
                                </div>
                            </div>

                            @if ($param->type == 'PRO')

                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('process_parent') ? ' has-error':'' }}">
                                        <label class="control-label">Proceso General</label>
                                        <select class="form-control input-sm" name="process_parent">
                                            <option value="">Ninguno</option>
                                            @foreach ($process as $pro)
                                                <option value="{{ $pro->id }}"{{ $param->id_parent == $pro->id ? ' selected':'' }}>{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">{{ $errors->first('process_parent') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-2">
                                    <div class="form-group{{ $errors->first('version') ? ' has-error':'' }}">
                                        <label class="control-label">Versión</label>
                                        <input type="text" class="form-control input-sm" name="version" value="{{ $param->version }}">
                                        <span class="help-block">{{ $errors->first('version') }}</span>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                    <div class="form-group{{ $errors->first('name') ? ' has-error':'' }}">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" class="form-control input-sm" name="name" value="{{ $param->name }}">
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    </div>
                                </div>

                            @else

                                <div class="col-xs-8">
                                    <div class="form-group{{ $errors->first('description') ? ' has-error':'' }}">
                                        <label class="control-label">Descripción</label>
                                        <input type="text" class="form-control input-sm" name="description" value="{{ $param->note }}">
                                        <span class="help-block">{{ $errors->first('description') }}</span>
                                    </div>
                                </div>

                            @endif

                            <div class="col-xs-2">
                                <div class="checkbox">
                                    <label style="margin-top: 18px;">
                                        <input type="checkbox" name="is_active" {{ $param->is_active ? 'checked' : '' }}> Activo
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('process.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
