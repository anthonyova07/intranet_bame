@extends('layouts.master')

@section('title', 'Mercadeo -> Noticias')

@section('page_title', 'Mantenimiento de Noticias')

@if (can_not_do('marketing_news'))
    @section('contents')
        @include('layouts.partials.access_denied')
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
                    <form method="get" action="{{ route('marketing.news.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group{{ $errors->first('term') ? ' has-error':'' }}">
                                    <label class="control-label">Término</label>
                                    <input type="text" class="form-control input-sm" name="term" placeholder="término de busqueda..." value="{{ request('term') }}">
                                    <span class="help-block">{{ $errors->first('term') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Desde</label>
                                    <input type="date" class="form-control input-sm" name="date_from" value="{{ old('date_from') }}">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group{{ $errors->first('date_to') ? ' has-error':'' }}">
                                    <label class="control-label">Hasta</label>
                                    <input type="date" class="form-control input-sm" name="date_to" value="{{ old('date_to') }}">
                                    <span class="help-block">{{ $errors->first('date_to') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Buscando noticias...">Buscar</button>
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
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.news.create') }}">Nueva</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='2|desc'>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th style="width:50px;">Tipo</th>
                                <th style="width: 30px;">Activa</th>
                                <th style="width: 30px;">Menú</th>
                                <th style="width: 132px;">Fecha Creada</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $new)
                                <tr>
                                    <td>{{ $new->title }}</td>
                                    <td>{{ get_news_types($new->type) }}</td>
                                    <td>{{ $new->is_active ? 'Si' : 'No' }}</td>
                                    <td>{{ $new->menu ? 'Si' : 'No' }}</td>
                                    <td>{{ $new->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.news.edit', ['id' => $new->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                        <a
                                            href="{{ route('marketing.news.print', ['id' => $new->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            target="_blank"
                                            title="Imprimir">
                                            <i class="fa fa-print fa-fw"></i>
                                        </a>
                                        {{-- <a
                                            onclick="cancel('{{ $new->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar {{ $new->men_descri }}"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('marketing.news.destroy', ['id' => $new->id]) }}"
                                            method="post" id="form_eliminar_{{ $new->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $news->links() }}
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
            res = confirm('Realmente desea eliminar esta noticia?');

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
