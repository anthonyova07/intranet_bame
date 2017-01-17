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

            <div class="panel panel-default">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Comentario</th>
                            <th>Editado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($claim_statuses as $claim_status)
                            <tr>
                                <td>{{ $claim_status->description }}</td>
                                <td>{{ $claim_status->comment }}</td>
                                <td>{{ $claim_status->created_by_name }} a las {{ $claim_status->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
