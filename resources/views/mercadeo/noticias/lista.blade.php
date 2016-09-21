@extends('layouts.master')

@section('title', 'Mercadeo -> Noticias')

@section('page_title', 'Mantenimiento de Noticias')

@if (can_not_do('mercadeo_noticias'))
    @section('contents')
        @include('partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Filtros de Búsqueda</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('mercadeo::noticias::lista') }}" id="form_consulta">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('termino') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control" name="termino" placeholder="término de busqueda..." value="{{ old('termino') }}">
                                    <span class="help-block">{{ $errors->first('termino') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('fecha_desde') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control" name="fecha_desde" value="{{ old('fecha_desde') }}">
                                    <span class="help-block">{{ $errors->first('fecha_desde') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('fecha_hasta') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control" name="fecha_hasta" value="{{ old('fecha_hasta') }}">
                                    <span class="help-block">{{ $errors->first('fecha_hasta') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" id="btn_submit" data-loading-text="Buscando noticias...">Buscar Noticia</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a class="btn btn-danger btn-sm" href="{{ route('mercadeo::noticias::nueva') }}">Nueva Noticia</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th style="width:50px;">Tipo</th>
                                <th style="width: 120px;">Fecha</th>
                                <th style="width: 26px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td>{{ $noticia->TITLE }}</td>
                                    <td>{{ get_news_types($noticia->TYPE) }}</td>
                                    <td>{{ $noticia->CREATED_AT }}</td>
                                    <td align="center">
                                        <a href="{{ route('mercadeo::noticias::editar', ['id' => $noticia->ID]) }}" data-toggle="tooltip" title="Editar" class="naranja"><i class="fa fa-edit fa-fw"></i></a>
                                        <a href="{{ route('mercadeo::noticias::eliminar', ['id' => $noticia->ID]) }}" class="link_eliminar rojo" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times fa-fw"></i></a>
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
        $('#form_consulta').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        $('.link_eliminar').click(function (event) {
            res = confirm('Realmente desea eliminar esta noticia?');
            console.log(res);
            if (!res) {
                event.preventDefault();
                return;
            }

            $(this).remove();
        });
    </script>

@endsection
