@extends('layouts.master')

@section('title', 'Mercadeo -> Acompañantes')

@section('page_title', 'Mantenimiento de Acompañantes')

@section('contents')

    <div class="row">
        <div class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="{{ route('marketing.event.accompanist.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ old('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="col-xs-2">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando..." style="margin-top: 27px;">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.event.accompanist.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Relación</th>
                                <th>Creado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accompanists as $accompanist)
                                <tr>
                                    <td>{{ $accompanist->names . ' ' . $accompanist->last_names }}</td>
                                    <td>{{ '(' . get_identification_types($accompanist->identification_type) . ') ' . $accompanist->identification }}</td>
                                    <td>{{ get_relationship_types($accompanist->relationship) }}</td>
                                    <td>{{ $accompanist->created_at }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.event.accompanist.edit', ['id' => $accompanist->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        {{-- <a
                                            onclick="cancel('{{ $accompanist->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar {{ $accompanist->names . ' ' . $accompanist->last_names }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('marketing.event.accompanist.destroy', ['id' => $accompanist->id]) }}"
                                            method="post" id="form_eliminar_{{ $accompanist->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $accompanists->links() }}
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
            res = confirm('Realmente desea eliminar esta acompanate?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
