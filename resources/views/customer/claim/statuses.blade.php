@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Historico de Estatus de la Reclamaciones ' . $claim->claim_number)

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-2" style="padding: 0 2px;">
                        <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['claim_id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    </div>
                </div>
            </div>

            @foreach ($claim_statuses as $claim_status)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Descripción</label>
                                <p class="form-control-static">{{ $claim_status->description }}</p>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Comentario</label>
                                <p class="form-control-static">{{ $claim_status->comment }}</p>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label class="control-label">Creado por</label>
                                <p class="form-control-static">{{ $claim_status->created_by_name }} a las {{ $claim_status->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
