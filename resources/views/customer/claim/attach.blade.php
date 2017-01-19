@extends('layouts.master')

@section('title', 'Clientes - Reclamaciones')

@section('page_title', 'Adjuntos de la Reclamación (' . $claim->claim_number . ')')

@if (can_not_do('customer_claim'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    @if (!$claim->is_closed)
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Carga de Archivos</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{ route('customer.claim.attach', ['claim_id' => $claim->id]) }}" id="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                        <label class="control-label">Archivos <div class="label label-warning"> MAX: 10MB</div></label>
                                        <input type="file" name="files[]" multiple>
                                        <span class="help-block">{{ $errors->first('term') }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Subiendo archivos...">Subir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <a class="btn btn-info btn-xs" href="{{ route('customer.claim.show', ['id' => $claim->id]) }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|asc'>
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th style="width: 90px;">Subido por</th>
                                <th style="width: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claim->attaches as $attach)
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ route('customer.claim.attach.download', ['claim_id' => $claim->id, 'attach' => $attach->id]) }}" download style="font-size: 16px;">{{ $attach->file }}</a>
                                    </td>
                                    <td style="font-size: 14px;vertical-align: middle;">
                                        {{ $attach->created_by_name }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if (!$claim->is_closed)
                                            @if ($attach->created_by == session()->get('user'))
                                                <a
                                                    onclick="cancel('{{ $attach->id }}', this)"
                                                    href="javascript:void(0)"
                                                    style="font-size: 20px;"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Eliminar Adjunto {{ $attach->file }}"
                                                    class="rojo link_anular">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                </a>
                                                <form
                                                    style="display: none;"
                                                    action="{{ route('customer.claim.attach.delete', ['claim_id' => $attach->claim_id,'attach' => $attach->id]) }}"
                                                    method="post" id="form_eliminar_{{ $attach->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este adjunto?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
