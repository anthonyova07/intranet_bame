@extends('layouts.master')

@section('title', 'Rómpete el Coco')

@section('page_title', 'Rómpete el Coco - Idea')

@if (can_not_do('marketing_coco_idea'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form>
                        <div class="row">
                            <div class="col-xs-2">
                                <a class="btn btn-info btn-xs" href="{{ route('marketing.break_coco.ideas.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Nombre y Apellido</label>
                                    <div class="form-control-static">{{ $idea->names }}</div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Correo</label>
                                    <div class="form-control-static">{{ $idea->mail }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Idea</label>
                                    <div class="form-control-static">{!! $idea->idea !!}</div>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="tooltip" title="Click para contactar empleado" href="mailto:{{ $idea->mail }}?Subject=Idea de Rompete el Coco&body=Idea del Empleado: ({{ $idea->idea }})">Contactar Empleado</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
