@extends('layouts.master')

@section('title', 'Mercadeo - Preguntas Frecuentes')

@section('page_title', 'Nueva Pregunta Frecuente')

@if (can_not_do('marketing_faqs'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('marketing.faqs.store') }}" id="form">
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="form-group{{ $errors->first('question') ? ' has-error':'' }}">
                                    <label class="control-label">Pregunta</label>
                                    <input type="text" class="form-control input-sm" name="question" value="{{ old('question') }}">
                                    <span class="help-block">{{ $errors->first('question') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('theme') ? ' has-error':'' }}">
                                    <label class="control-label">Tema</label>
                                    <select class="form-control input-sm" name="theme">
                                        @foreach ($themes as $theme)
                                            <option value="{{ $theme->id }}" {{ old('theme') == $theme->id ? 'selected':'' }}>{{ $theme->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $errors->first('theme') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('active') ? ' has-error':'' }}">
                                    <label>
                                        <input type="checkbox" checked name="active" data-toggle="tooltip" style="margin-top: 30px;"> Activo
                                    </label>
                                    <span class="help-block">{{ $errors->first('active') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('answer') ? ' has-error':'' }}">
                                    <label class="control-label">Respuesta</label>
                                    <textarea class="form-control input-sm textarea" name="answer" rows="10">{{ old('answer') }}</textarea>
                                    <span class="help-block">{{ $errors->first('answer') }}</span>
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <a class="btn btn-info btn-xs" href="{{ route('marketing.faqs.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Guardando...">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });
    </script>

@endsection
