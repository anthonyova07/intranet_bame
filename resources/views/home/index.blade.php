@extends('layouts.master')

@section('title', 'Intranet Bancamérica')

@section('page_title', 'Bienvenid@ a la Intranet Bancamérica')

@section('contents')
    <div class="row">
        <div class="col-xs-12">

            <div class="col-xs-5 col-noticias news">
                @if ($column_new)
                    <div class="row titulo-columna">
                        La Columna del Presidente
                    </div>
                    <div class="row text-center" style="margin-bottom: 10px;">
                        <img style="max-width: 402px;" src="{{ route('home') . $column_new->image }}">
                    </div>
                    <div class="row parrafo-columna text-justify">
                        <p style="height: 220px;max-height: 180px;"><b>{{ substr(strip_tags($column_new->title), 0, 80) . '...' }}</b> {!! substr(strip_tags(html_entity_decode($column_new->detail)), 0, 500)  . '...' !!}</p>
                    </div>
                    <div class="row text-center">
                        <a href="{{ route('home.news', ['id' => $column_new->id]) }}" class="link_noticias">Ver Más</a>
                    </div>
                @endif
            </div>

            <div class="col-xs-7">

                <div class="row" style="margin-bottom: 13px;">
                    <div class="col-xs-12 news" style="margin-left: 12px;">

                        <div class="carousel slide carousel-banners" data-ride="carousel" data-interval="3000" style="width: 100%;height: 226px;margin-top: 9px;">
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="display: none;">
                                @foreach ($banners_news as $index => $banner)
                                    <li data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active':'' }}"></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @foreach ($banners_news as $index => $banner)
                                    <div class="item {{ $index == 0 ? 'active':'' }}">
                                        <img src="{{ route('home') . $banner->image }}" style="height: 232px;margin: auto;">
                                        <div class="carousel-caption" style="right: 0;left: 0;margin-bottom: -44px;">
                                            <a href="http://bancamerica.com.do/" target="__blank" class="link_noticias_no_effect">Ver Detalle</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="javascript:void(0)" onclick="$('.carousel-banners').carousel('prev')" data-slide="prev">
                                <span class="icon-prev"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control"  href="javascript:void(0)" onclick="$('.carousel-banners').carousel('next')" data-slide="next">
                                <span class="icon-next"></span>
                                <span class="sr-only">Next</span>
                            </a>

                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 news" style="margin-top: 5px;margin-left: 12px;">

                        <div class="carousel slide carousel-noticias" data-ride="carousel" data-interval="5000" style="width: 100%;height: 281px;margin-top: 9px;">
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="display: none;">
                                @foreach ($news as $index => $new)
                                    <li data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active':'' }}"></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @foreach ($news as $index => $new)
                                    <div class="item {{ $index == 0 ? 'active':'' }}">
                                        <img src="{{ route('home') . $new->image }}" style="height: 280px;margin: auto;">
                                        <div class="carousel-caption carousel-caption-noticias" style="right: 0;left: 0;margin-bottom: -47px;">
                                            <a data-toggle="tooltip" class="link_noticias" title="Click para más detalles" href="{{ route('home.news', ['id' => $new->id]) }}">{{ substr($new->title, 0, 85) . '...' }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="javascript:void(0)" onclick="$('.carousel-noticias').carousel('prev')" data-slide="prev">
                                <span class="icon-prev"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control"  href="javascript:void(0)" onclick="$('.carousel-noticias').carousel('next')" data-slide="next">
                                <span class="icon-next"></span>
                                <span class="sr-only">Next</span>
                            </a>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row" style="border-top: 1px solid #777;margin-top: 8px;border-width: 5px;">

    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-default panel-wiget">
                <div class="panel-heading">
                    <h3 class="panel-title">Sobre Nosotros</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-8" style="padding-left: 0px;">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="well well-sm" style="margin-bottom: 10px;">
                                    <h4 class="list-group-item-heading" style="color: #d82f27;">Visión</h4>
                                    <p class="list-group-item-text">
                                        Ser reconocidos como el mejor banco de la República Dominicana en términos de eficiencia, rentabilidad, confianza, respuesta al cliente y responsabilidad social.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="well well-sm" style="margin-bottom: 10px;">
                                    <h4 class="list-group-item-heading" style="color: #d82f27;">Misión</h4>
                                    <p class="list-group-item-text">
                                        Proveer soluciones financieras a las necesidades de nuestros clientes con un servicio de excelencia contribuyendo al crecimiento económico y desarrollo de la República Dominicana.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="well well-sm" style="margin-bottom: 0px;">
                                    <h3 class="list-group-item-heading" style="color: #d82f27;">Valores</h3>
                                    <table class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <td><b data-toggle="tooltip" title="Honestos, confiables y sinceros">INTEGRIDAD</b></td>
                                                <td><b data-toggle="tooltip" title="Sencillos y comedidos">PRUDENCIA</b></td>
                                                <td><b data-toggle="tooltip" title="Superamos las expectativas de nuestros clientes">EXCELENCIA</b></td>
                                                <td><b data-toggle="tooltip" title="Mejora constante de calidad y eficiencia">COMPROMISO</b></td>
                                                <td><b data-toggle="tooltip" title="Apego, fidelidad y respeto">LEALTAD</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="row">
                            <div class="well well-sm" style="margin-bottom: 0px;">
                                <h3 class="list-group-item-heading text-center" style="color: #d82f27;font-size: 24px;">Código de Ética</h3>
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <a target="_blank" data-toggle="tooltip" title="Click para ver" href="http://intranet_bame:8077/files/gesti_doc/human_resources/Codigo_de_Etica_y_Conducta/Manual_de_Normas_Codigo_de_Etica_y_Conducta.pdf">
                                                    <i style="font-size: 183px;color: #d82f27;" class="fa fa-book"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-4">
            <div class="panel panel-default" style="margin-top: 8px;">

                <div class="panel-body text-center">
                    <img src="{{ route('home') . '/marketing/coco/rompete_el_coco.png' }}" style="width: 220px;">
                </div>

                @if ($coco->get()->active)

                    <div class="panel-body text-center">
                        <h3 style="padding-top: 0;color: #da291c;">{{ $coco->get()->title }}</h3>
                    </div>

                    <div class="panel-body text-center">
                        <ul class="list-group text-left" style="box-shadow: 0 0 0 0;margin-top: 20px;">
                            @foreach ($coco->get()->descriptions->sortBy('order') as $description)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="javascript:void(0)">
                                            <span class="badge btn-info" style="font-size: 35px;width: 40px;background-color: #4f616b;">{{ $description->order }}</span>
                                        </a>
                                    </div>
                                    <div class="media-body" style="font-weight: bold;">
                                        {{ $description->description }}
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>

                    @if ($coco->get()->awards->count())
                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-warning" style="font-size: 24px;">Premios</label>
                            <ul class="list-group text-left" style="box-shadow: 0 0 0 0;margin-top: 20px;">
                                @foreach ($coco->get()->awards->sortBy('order') as $award)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="javascript:void(0)">
                                                <span class="badge btn-warning" style="font-size: 35px;width: 40px;">{{ $award->order }}</span>
                                            </a>
                                        </div>
                                        <div class="media-body" style="font-weight: bold;vertical-align: middle;">
                                            {{ $award->award }}
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel-body text-right" style="margin-top: -38px;">
                        <a href="{{ route('coco') }}" class="btn btn-default btn-sm" style="background-color: #4f616b;color: #ffffff;">Enviar Idea...</a>
                    </div>

                @else

                    <div class="panel-body text-center">
                        <label class="control-label text-center label label-danger" style="font-size: 24px;">Concurso no Disponible</label>
                    </div>

                @endif

            </div>
        </div>

        <div class="col-xs-8">
            <div class="panel panel-default panel-wiget" style="display: block;margin-top: 8px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Calendario Virtual</h3>
                </div>
                <div class="panel-body" style="background-color: #cccccc;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="calendar" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 0px;">
                        <div class="col-xs-12">
                            <div class="panel panel-default" style="margin-bottom: 0px;border-radius: 0;border: 0 solid transparent;">
                                <div class="panel-body" style="letter-spacing: -1px;">
                                    <div class="col-xs-1">

                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <img style="width: 24px;" src="{{ route('home') }}/images/event.png"> <br>Eventos
                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <img style="width: 24px;" src="{{ route('home') }}/images/goesgreen.png"> <br>Goes Green
                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <img style="width: 24px;" src="{{ route('home') }}/images/birthdate.png"> <br>Cumpleaños
                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <img style="width: 24px;" src="{{ route('home') }}/images/money.png"> <br>Días de Pago
                                    </div>
                                    <div class="col-xs-2 text-center">
                                        <img style="width: 24px;" src="{{ route('home') }}/images/service_year.png"> <br>Aniversarios
                                    </div>
                                    <div class="col-xs-1">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-4">

            <div class="panel panel-default panel-wiget">
                <div class="panel-heading">
                    <h3 class="panel-title">Eventos</h3>
                </div>
                <div class="panel-body">
                    @if ($events->count())
                        <div class="list-group">
                            @foreach($events as $event)
                                <a href="{{ route('home.event', ['id' => $event->id]) }}" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        {{ substr($event->title, 0, 70) . '...' }}
                                        <br>
                                        <span class="text-muted small">
                                            <em>{{ $event->start_event->format('d/m/Y h:i:s A') }}</em>
                                        </span>
                                    </h4>
                                    <p class="list-group-item-text" style="word-wrap: break-word;">
                                        {!! substr(strip_tags(html_entity_decode($event->detail)), 0, 170)  . '...' !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-danger" style="font-size: 18px;">No Hay Eventos</label>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-xs-4">

            <div class="panel panel-default panel-wiget">
                <div class="panel-heading">
                    <h3 class="panel-title">Vacantes</h3>
                </div>
                <div class="panel-body">
                    @if ($vacancies->count())
                        <div class="list-group">
                            @foreach($vacancies as $vacant)
                                <a href="{{ route('home.vacant', ['id' => $vacant->id]) }}" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        {{ substr($vacant->name, 0, 70) . '...' }}
                                        <br>
                                        <span class="text-muted small">
                                            <em>{{ $vacant->created_at->format('d/m/Y h:i:s A') }}</em>
                                        </span>
                                    </h4>
                                    <p class="list-group-item-text" style="word-wrap: break-word;">
                                        {!! substr(strip_tags(html_entity_decode($vacant->detail)), 0, 170)  . '...' !!}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="panel-body text-center">
                            <label class="control-label text-center label label-danger" style="font-size: 18px;">No Hay Vacantes</label>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @if ($day_events->count() || $day_birthdays->count() || $day_services->count() || $day_dates->count())
        <div class="modal fade modal_start" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 6px 6px 6px 15px;color: #ffffff;background-color: #d82f27;">
                        <button style="margin: -5px 8px 0 0; font-size: 40px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="font-size: 25px;">Actividades del Día</h4>
                    </div>
                    <div class="modal-body">
                        @if ($day_events->count())
                            <table class="table table-bordered table-hover table-striped" style="margin-bottom: 15px;">
                                <thead>
                                    <tr style="font-size: 18px;">
                                        <th style="width: 68%;">
                                            <img style="width: 25px;" src="{{ route('home') . '/images/event.png' }}">
                                            Eventos
                                        </th>
                                        <th class="text-center" style="width: 16%;"><i style="color: #FF8849;" class="fa fa-hourglass-start"></i> Inicio</th>
                                        <th class="text-center" style="width: 16%;"><i style="color: #FF8849;" class="fa fa-hourglass-end"></i> Fin</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 18px;">
                                    @foreach($day_events as $event)
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <a style="color: #FF8849;" href="{{ route('home.event', ['id' => $event->id]) }}" target="__blank">{{ $event->title }}</a>
                                            </td>
                                            <td style="text-align: right;width: 120px;font-size: 15px;letter-spacing: 1px;">
                                                {{ $event->start_event->format('d/m/y') }}
                                                <br>
                                                {{ $event->start_event->format('h:i a') }}
                                            </td>
                                            <td style="text-align: right;width: 120px;font-size: 15px;letter-spacing: 1px;">
                                                {{ $event->end_subscriptions->format('d/m/y') }}
                                                <br>
                                                {{ $event->end_subscriptions->format('h:i a') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if ($day_birthdays->count())
                            <table class="table table-bordered table-hover table-striped" style="margin-bottom: 15px;">
                                <thead>
                                    <tr>
                                        <th style="font-size: 18px;">
                                            <img style="width: 25px;" src="{{ route('home') . '/images/birthdate.png' }}">
                                            Cumpleaños
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 18px;">
                                    @foreach($day_birthdays as $birthday)
                                        <tr>
                                            <td>
                                                <a style="color: #FF8849;" href="javascript:void(0)">{!! $birthday->full_name !!}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if ($day_services->count())
                            <table class="table table-bordered table-hover table-striped" style="margin-bottom: 15px;">
                                <thead>
                                    <tr style="font-size: 18px;">
                                        <th style="width: 68%;">
                                            <img style="width: 25px;" src="{{ route('home') . '/images/service_year.png' }}">
                                            Aniversarios de Trabajo
                                        </th>
                                        <th class="text-center" style="width: 6%;">Años</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 18px;">
                                    @foreach($day_services as $day_service)
                                        <tr>
                                            <td>
                                                <a style="color: #FF8849;" href="javascript:void(0)">{!! $day_service->full_name !!}</a>
                                            </td>
                                            <td class="text-center" style="width: 120px;font-size: 15px;letter-spacing: 1px;">
                                                {{ calculate_year_of_service($day_service->services_date) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if ($day_dates->count())
                            <table class="table table-bordered table-hover table-striped" style="margin-bottom: 15px;">
                                <thead>
                                    <tr>
                                        <th style="font-size: 18px;" colspan="2">
                                            <img style="width: 25px;" src="{{ route('home') . '/images/calendar.png' }}">
                                            Fechas
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 18px;">
                                    @foreach($day_dates as $date)
                                        @if ($date->group->showinday)
                                            <tr>
                                                <td style="width: 42px;">
                                                    @if ($date->group->name == 'Goes Green')
                                                        <img data-toggle="tooltip" title="Goes Green" style="width: 25px;" src="{{ route('home') . '/images/goesgreen.png' }}">
                                                    @elseif($date->group->name == 'Feriados')
                                                        <img data-toggle="tooltip" title="Feriado" style="width: 25px;" src="{{ route('home') . '/images/holiday.png' }}">
                                                    @else
                                                        <img data-toggle="tooltip" title="Feriado" style="width: 25px;" src="{{ route('home') . '/images/calendar.png' }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a style="color: #FF8849;" href="javascript:void(0)">{!! $date->title !!}</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        calendar('{{ $datetime->format('Y-m-d') }}', [
            @foreach ($dates as $date)
                {
                    start: '{{ $date->startdate->format('Y-m-d') }}',
                    end: '{{ $date->enddate->format('Y-m-d') }}',
                    // color: '{{ $date->group->color }}',
                    backgroundColor: '{{ $date->group->backcolor }}',
                    borderColor: '{{ $date->group->bordcolor }}',
                    textColor: '{{ $date->group->textcolor }}',
                    @if ($date->group->name == 'Goes Green')
                        title: '',
                        className: 'cal_tooltip cal_icon goesgreen {{ str_replace(' ', '|', 'Goes Green: ' . $date->title) }}',
                    @elseif($date->group->name == 'Feriados')
                        title: '{!! $date->title !!}',
                        //cal_icon holiday
                        className: 'cal_tooltip {{ str_replace(' ', '|', 'Día Feriado: ' . $date->title) }}',
                    @else
                        title: '{!! $date->title !!}',
                        className: 'cal_tooltip {{ str_replace(' ', '|', $date->title) }}',
                    @endif
                },
            @endforeach
            @foreach ($events as $event)
                {
                    title: '',
                    start: '{{ $event->start_event->format('Y-m-d') }}',
                    url: '{{ route('home.event', ['id' => $event->id]) }}',
                    className: 'cal_tooltip event cal_icon {{ str_replace(' ', '|', 'Evento: ' . $event->title) }}',
                },
            @endforeach
            @foreach ($payments_days as $index => $payments_day)
                    {
                        title: '',
                        start: '{{ $payments_day }}',
                        className: 'payment_days cal_icon cal_tooltip Día|de|Pago|{{ ($index % 2 == 0) ? '1ra|Quincena' : '2da|Quincena' }}',
                    },
            @endforeach
            @foreach ($birthdates->unique('month_day') as $birthdate)
                {
                    title: '',
                    start: '{{ $datetime->format('Y') .'-'. $birthdate->month_day }}',
                    className: 'birthdate cal_icon ' + '{!! str_replace(' ', '|', $birthdates->where('month_day', $birthdate->month_day)->implode('full_name', ',')) !!}',
                },
            @endforeach
            @foreach ($services_dates->unique('services_month_day') as $service_date)
                @if (isset($service_date->services_month_day))
                    {
                        title: '',
                        start: '{{ $datetime->format('Y') .'-'. $service_date->services_month_day }}',
                        className: 'service_year cal_icon ' + '{!! str_replace(' ', '|', $services_dates->where('services_month_day', $service_date->services_month_day)->implode('full_name', ',')) !!}',
                    },
                @endif
            @endforeach
        ]);
    </script>

@endsection
