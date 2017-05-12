@extends('layouts.master')

@section('title', 'Mercadeo -> Pregunta Frecuente')

@section('page_title', 'Mantenimiento de Pregunta Frecuente')

@if (can_not_do('marketing_faqs'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Preguntas Frecuentes</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.faqs.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Pregunta</th>
                                <th>Tema</th>
                                <th style="width: 36px;">Activo</th>
                                <th style="width: 2px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $faq)
                                <tr>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ $faq->theme->name }}</td>
                                    <td>{{ $faq->is_active ? 'Si':'No' }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.faqs.edit', ['faqs' => $faq->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
        <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
    </div>

    <div class="row">

        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Temas de Preguntas</h3>
                </div>
                <div class="panel-body">
                    <a class="btn btn-danger btn-xs" href="{{ route('marketing.faqs.themes.create') }}">Nuevo</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-hover table-condensed datatable" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="width: 36px;">Activo</th>
                                <th style="width: 2px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($themes as $theme)
                                <tr>
                                    <td>{{ $theme->name }}</td>
                                    <td>{{ $theme->is_active ? 'Si':'No' }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.faqs.themes.edit', ['themes' => $theme->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Editar"
                                            class="naranja">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
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
    </script>

@endsection
