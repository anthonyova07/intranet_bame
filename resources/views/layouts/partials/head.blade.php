<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jeison Peguero">
    <link rel="icon" href="{{ route('home') }}/images/favicon.ico">

    <title>Intranet BAME - @yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ route('home') }}/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ route('home') }}/css/bootstrap-theme.min.css" rel="stylesheet"> --}}
    <link href="{{ route('home') }}/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ route('home') }}/css/jquery-ui.min.css" rel="stylesheet">
    <link href="{{ route('home') }}/css/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="{{ route('home') }}/css/fullcalendar.min.css" rel="stylesheet">

    <!-- Editor HTML5 -->
    <link href="{{ route('home') }}/css/bootstrap3-wysihtml5.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ route('home') }}/css/metisMenu.min.css" rel="stylesheet">
    <link href="{{ route('home') }}/css/animate.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ route('home') }}/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ route('home') }}/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="{{ route('home') }}/css/bame.css?last_update={{ config('bame.js.not_cache') }}" rel="stylesheet" type="text/css">

    <style>
        .birthdate {
            background-image: url({{ route('home') }}/images/birthdate.png);
        }

        .service_year {
            background-image: url({{ route('home') }}/images/service_year.png);
        }

        .payment_days {
            background-image: url({{ route('home') }}/images/money.png);
        }

        .event {
            background-image: url({{ route('home') }}/images/event.png);
        }

        .goesgreen {
            background-image: url({{ route('home') }}/images/goesgreen.png);
        }

        .holiday {
            background-image: url({{ route('home') }}/images/holiday.png);
        }
    </style>

    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
