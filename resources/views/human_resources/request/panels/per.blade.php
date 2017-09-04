<form method="post" action="{{ route('human_resources.request.store', ['type' => $type]) }}" id="form">

    <div class="row">
        @include('human_resources.request.panels.colaborator_panel', [
            'type' => $type,
        ])

        @include('human_resources.request.panels.supervisor_panel', [
            'type' => $type,
        ])
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Detalle de la Solicitud ( {{ $type_desc }} )</h3>
                </div>

                <div class="panel-body">

                    @include('human_resources.request.panels.permission_form')

                    <div class="row">
                        <div class="col-xs-4">
                            {{ csrf_field() }}
                            <a class="btn btn-info btn-xs" href="{{ route('human_resources.request.index') }}"><i class="fa fa-arrow-left"></i> Atrás</a>
                            <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Enviando...">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
    $('input[name=permission_type]').change(function () {
        var type = $(this).val();
        if (type == 'one_day') {
            $('#one_day').show('fast');
            $('#multiple_days').hide('fast');
        } else if (type == 'multiple_days') {
            $('#multiple_days').show('fast');
            $('#one_day').hide('fast');
        }
    });
</script>
