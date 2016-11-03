@extends('layouts.master')

@section('title', 'Mercadeo -> Rómpete el Coco (Ideas)')

@section('page_title', 'Ideas de Rómpete el Coco')

@if (can_not_do('marketing_coco_idea'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-condensed" order-by='0|desc'>
                        <thead>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <th>Correo</th>
                                <th>Idea</th>
                                <th style="width: 112px;">Fecha Creación</th>
                                <th style="width: 52px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ideas as $idea)
                                <tr>
                                    <td>{{ $idea->names }}</td>
                                    <td>{{ $idea->mail }}</td>
                                    <td>{{ substr(str_replace('<br />', '', $idea->idea), 0, 50) }}</td>
                                    <td>{{ $idea->created_at }}</td>
                                    <td align="center">
                                        <a
                                            href="{{ route('marketing.break_coco.ideas.show', ['id' => $idea->id]) }}"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Ver Idea">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        {{-- <a
                                            onclick="cancel('{{ $vacant->id }}', this)"
                                            href="javascript:void(0)"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Eliminar"
                                            class="rojo link_delete">
                                            <i class="fa fa-close fa-fw"></i>
                                        </a>
                                        <form
                                            action="{{ route('human_resources.vacant.destroy', ['id' => $vacant->id]) }}"
                                            method="post" id="form_eliminar_{{ $vacant->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $ideas->links() }}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#form').submit(function (vacant) {
            $('#btn_submit').button('loading');
        });

        function cancel(id, el)
        {
            res = confirm('Realmente desea eliminar este vacanto?');

            if (!res) {
                vacant.prvacantDefault();
                return;
            }

            $(el).remove();

            $('#form_eliminar_' + id).submit();
        }
    </script>

@endsection
