@extends('layouts.master')

@section('title', 'Home')

@section('page_title', html_entity_decode($vacant->name))

@section('contents')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-xs-4">
                    @if (session()->has('user'))
                        <form method="post" action="{{ route('human_resources.vacant.apply', ['id' => $vacant->id]) }}" enctype="multipart/form-data">
                            <div class="form-group{{ $errors->first('curriculum') ? ' has-error':'' }}">
                                <label class="control-label">Cargar Curriculum Vitae <small style="font-size: 11px;" class="label label-warning">MAX 10MB</small></label>
                                <input type="file" name="curriculum">
                                <span class="help-block">{{ $errors->first('curriculum') }}</span>
                            </div>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-block bame_tada">
                                @if ($vacant->isSubscribe())
                                    Actualizar Curriculum
                                @else
                                    Enviar Curriculum
                                @endif
                            </button>
                        </form>
                    @else
                        <button class="btn btn-default btn-block bame_wobble" style="font-weight: bold;" disabled>Debe iniciar sesión para poder aplicar.</button>
                    @endif
                </div>

                <div class="col-xs-8">
                    <div style="color: #616365;">
                        {!! html_entity_decode($vacant->detail) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
