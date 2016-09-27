@extends('layouts.master')

@section('title', 'Rompete el Coco')

@section('page_title', 'Rompete el Coco')

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="{{ route('marketing.break_coco.store') }}" id="form">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="form-group{{ $errors->first('title') ? ' has-error':'' }}">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control input-sm" name="title" value="{{ $coco->get()->title }}">
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group{{ $errors->first('active') ? ' has-error':'' }}">
                                    <label>
                                        <input type="checkbox" {{ $coco->get()->active ? 'checked':'' }} name="active" data-toggle="tooltip" style="margin-top: 35px;"> Activo
                                    </label>
                                    <span class="help-block">{{ $errors->first('active') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->first('descriptions') ? ' has-error':'' }}">
                            <label class="control-label">Descripciones</label>
                            <textarea class="form-control input-sm" name="descriptions" rows="5">@foreach ($coco->get()->descriptions as $description){{ $description->order . '-' . $description->description . chr(13) . chr(10) }}@endforeach</textarea>
                            <span class="help-block">{{ $errors->first('descriptions') }}</span>
                        </div>
                        <div class="form-group{{ $errors->first('awards') ? ' has-error':'' }}">
                            <label class="control-label">Premios</label>
                            <textarea class="form-control input-sm" name="awards" rows="5">@foreach ($coco->get()->awards as $award){{ $award->order . '-' . $award->award . chr(13) . chr(10) }}@endforeach</textarea>
                            <span class="help-block">{{ $errors->first('awards') }}</span>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando idea...">Enviar</button>
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
