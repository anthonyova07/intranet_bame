<!DOCTYPE html>
<html>
    <head>
        <title>Página no Encotrada</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #FFFFFF;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #f31928;
                font-family: 'Museo';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title" style="font-size: 40px;font-weight: bold;">¡Esta página no está disponible!</div>
                <div style="font-size: 32px;font-weight: bold;font-style: italic;letter-spacing: 1px;">Es posible que el enlace que has seguido esté roto o que se haya eliminado la página.</div>
                <img src="{{ route('home') . '/images/logo.png' }}" style="margin-top: 40px;">
            </div>
        </div>
    </body>
</html>
