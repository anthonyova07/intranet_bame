@extends('layouts.master')

@section('title', 'Mercadeo -> Loteria')

@section('page_title', 'Con Bancamérica el que ahorra es el que gana')

@if (can_not_do('marketing_lottery'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif

@section('contents')

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <div class="well well-sm" style="margin: 0px;">
                        <span style="font-size: 5em;font-weight: 800;" id="ticket">---</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <a id="getticket" class="label btn-danger btn-xs btn-block" style="padding: 24px;font-size: 40px;" href="javascript:void(0)">Escojer Ticket</a>
                </div>
            </div>
        </div>

    </div>

    <div id="winner_modal" class="modal fade active" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center" style="padding: 6px 6px 6px 15px;color: #ffffff;background-color: #d82f27;">
                    <h4 class="modal-title" style="font-size: 3em;">Ganador</h4>
                </div>
                <table class="table table-bordered table-condensed table-striped">
                    <tbody style="font-size: 2em;">
                        <tr>
                            <td><b>Boleto</b></td>
                            <td id="customer_ticket"></td>
                        </tr>
                        <tr>
                            <td><b># Cliente</b></td>
                            <td id="customer_number"></td>
                        </tr>
                        <tr>
                            <td><b>Identificación</b></td>
                            <td id="customer_id"></td>
                        </tr>
                        <tr>
                            <td><b>Nombre</b></td>
                            <td id="customer_name"></td>
                        </tr>
                        <tr>
                            <td><b>Premio</b></td>
                            <td>RD$ 25,000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (!can_not_do('marketing_lottery_adm') && !$tickets->count())
        <div class="row" style="border-bottom: 1px solid #777;border-top: 1px solid #777;margin: 8px 0 25px 0;border-width: 5px;">
            <h1 style="margin: 0;text-align: center;">Mantenimientos de Parametros</h1>
        </div>

        <div class="row">

        <div class="col-xs-6 col-xs-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Generar Boletos</h3>
                </div>
                <div class="panel-body text-center">
                    <a style="font-size: 4em;" class="btn btn-danger btn-xs btn-block" href="{{ route('marketing.lottery.create') }}">Generar Boletos</a>
                </div>
            </div>
        </div>

    </div>

    @endif

    <script type="text/javascript">
        var getticket = $('#getticket');
        var customers = JSON.parse('{!! $customers->toJson() !!}');
        var tickets = JSON.parse('{!! $tickets->toJson() !!}');

        var customer_ticket = $('#customer_ticket');
        var customer_number = $('#customer_number');
        var customer_id = $('#customer_id');
        var customer_name = $('#customer_name');

        var ticket = null;
        var random = null;

        getticket.click(function () {
            // clearInterval(interval);
            if (getticket.attr('disabled') == undefined && tickets.length > 0) {
                getticket.attr('disabled', true);

                var interval = setInterval(function () {
                    random = get_random(tickets.length);
                    ticket = tickets[random];

                    $('#ticket').html(ticket.Boleto);
                }, 50);

                setTimeout(function () {
                    clearInterval(interval);

                    setWinner(ticket);
                }, 5000);
            } else {
                alert('No existen boletos generados.');
            }
        });

        function get_random(to)
        {
            return Math.floor(Math.random() * to);
        }

        function setWinner(ticket) {
            var winner = customers.find(function (customer) {
                return customer.codigoCliente == ticket.codigoCliente;
            });

            customer_ticket.html(ticket.Boleto);
            customer_number.html(winner.codigoCliente);
            customer_id.html(winner.Identificacion);
            customer_name.html(winner.nombreCliente);

            $('#winner_modal').modal('show');
        }
    </script>

@endsection
