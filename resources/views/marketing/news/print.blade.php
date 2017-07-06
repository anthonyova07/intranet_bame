<!DOCTYPE html>
<html>
<head>
    <title>Noticia: {{ $news->title }}</title>
    <style>
        body {
            font-family: 'Juhl';
            color: #616365;
            /*background-image: url({{ route('home') . '/images/bame_background.png' }});
            background-repeat: no-repeat;
            background-size: 100% 100%;*/
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .table_td {
            padding: 3px;
        }
        th, td {
            border-bottom: 1px solid #CCCCCC;
            border-top: 1px solid #CCCCCC;
            border-left: 1px solid #CCCCCC;
            border-right: 1px solid #CCCCCC;
        }
        .fecha {
            border: 1px solid #616365;
            width: 185px;
            padding: 3px;
            margin: 10px;
            border-radius: 6px;
            color: #777;
            text-align: center;
        }
        .fecha_title {
            text-align: left;
            margin-left: -42px;
            font-style: italic;
            font-weight: bold;
            text-decoration: initial;
            position: absolute;
        }
        .sign_field {
            border: 0;
        }
        .img-thumbnail {
            display: inline-block;
            max-width: 100%;
            height: auto;
            padding: 4px;
            line-height: 1.42857143;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
        }
    </style>
</head>
    <body style="font-size: 80%;">
        <table width="100%" border="0">
            <tbody>
                <tr valign="top">
                    <td class="table_td" rowspan="2" style="border: 0;">
                        <img src="{{ route('home') . '/images/logo.jpg' }}" style="width: 220px;">
                    </td>
                    <td class="table_td" align="right" width="408" style="border: 0;">
                        {{-- <b style="font-size: 24px;font-style: italic;">{{ $news->title }}</b> --}}
                        {{-- <br> --}}
                        {{-- <div style="color: #777777;font-size: 12px;">Emitido por Bancamérica 101-11784-2</div> --}}
                    </td>
                </tr>
                <tr align="right">
                    <td class="table_td" style="border: 0;">
                        <div class="fecha">
                            <div class="fecha_title">Fecha</div>
                            {{ $news->created_at->format('d') }}
                            <b>/</b>
                            {{ $news->created_at->format('m') }}
                            <b>/</b>
                            {{ $news->created_at->format('Y') }}
                            &nbsp;&nbsp;&nbsp;
                            {{ $news->created_at->format('h') }}
                            <b>:</b>
                            {{ $news->created_at->format('i') }}
                            <b>:</b>
                            {{ $news->created_at->format('s') }}
                            {{ $news->created_at->format('a') }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <h1 style="text-align: center;">{{ $news->title }}</h1>

        <div style="text-align: center;">
            @if ($news->image == '' || !$news->image)
                <img class="img-thumbnail" src="{{ route('home') . $news->imgbanner . '?id=' . uniqid() }}">
            @else
                <img class="img-thumbnail" src="{{ route('home') . $news->image . '?id=' . uniqid() }}">
            @endif
        </div>

        <div style="text-align: justify;">
            {!! html_entity_decode($news->detail) !!}
        </div>

        @include('layouts.partials.print_and_exit')
    </body>
</html>
