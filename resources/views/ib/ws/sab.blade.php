@extends('layouts.master')

@section('title', 'IB')

@section('page_title', 'Transacciones SAB')

{{-- @if (can_not_do('marketing_event'))
    @section('contents')
        @include('layouts.partials.access_denied')
    @endsection
@endif --}}

@section('contents')

    @if (!session()->has('customer_ib_sab'))
    <div class="row">
        <div class="col-xs-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="{{ route('ib.ws.sab.index') }}" id="form">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group{{ $errors->first('date_from') ? ' has-error':'' }}">
                                    <label class="control-label">Cuenta</label>
                                    <input type="text" class="form-control input-sm" name="account" placeholder="# de Cuenta">
                                    <span class="help-block">{{ $errors->first('date_from') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" id="btn_submit" data-loading-text="Validando cuenta...">Validar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    Información del Cliente
                    <a
                        class="label btn-warning pull-right btn-xs"
                        href="javascript:void(0)"
                        onclick="action('eliminar_all', this)"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Cancelar Todo"
                        style="color: #FFFFFF;">
                        <i class="fa fa-close"></i>
                    </a>
                    <form
                        style="display: none;"
                        action="{{ route('ib.ws.sab.destroy', ['id' => 'all']) }}"
                        method="post" id="form_eliminar_all">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 25%;"><b>Nombre Legal:</b></td>
                                <td style="width: 25%;">{{ session()->get('customer_ib_sab')->customer->CustomerName }}</td>
                                <td style="width: 25%;"><b>Identificación:</b></td>
                                <td style="width: 25%;">{{ session()->get('customer_ib_sab')->customer->IdentificationType . ' ' . session()->get('customer_ib_sab')->customer->IdentificationNumber }}</td>
                            </tr>
                            <tr>
                                <td style="width: 25%;"><b>Nombre Corto:</b></td>
                                <td style="width: 25%;">{{ session()->get('customer_ib_sab')->customer->CustomerShortName }}</td>
                                <td style="width: 25%;"><b>Código de Cliente:</b></td>
                                <td style="width: 25%;">{{ session()->get('customer_ib_sab')->customer->Cif }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Información del Producto</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 25%;"><b>Número:</b></td>
                                <td style="width: 25%;">{{ session()->get('customer_ib_sab')->account->AccountNumber }}</td>
                                <td style="width: 25%;"><b>Tipo de Producto:</b></td>
                                <td style="width: 25%;">{{ sab_account_types(session()->get('customer_ib_sab')->account->Type) }}</td>
                            </tr>
                            <tr>
                                <td style="width: 25%;"><b>Moneda:</b></td>
                                <td style="width: 25%;">{{ sab_currencies(session()->get('customer_ib_sab')->account->Currency) }}</td>
                                <td style="width: 25%;"><b>Tipo de Producto:</b></td>
                                <td style="width: 25%;">{{ sab_account_types(session()->get('customer_ib_sab')->account->Type) }}</td>
                            </tr>
                            <tr>
                                <td style="width: 25%;"><b>Balance Actual:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->CurrentBalance, 2) }}</td>
                                <td style="width: 25%;"><b>Balance Disponible:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->AvailableBalance, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="width: 25%;"><b>Deuda Pendiente:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->DuePayment, 2) }}</td>
                                <td style="width: 25%;"><b>Monto Vencido:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->OverDueAmount, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="width: 25%;"><b>Pago Minino:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->MinPayment, 2) }}</td>
                                <td style="width: 25%;"><b>Monto Vencido:</b></td>
                                <td style="width: 25%;">{{ number_format(session()->get('customer_ib_sab')->account->OverDueAmount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script type="text/javascript">
        $('#form').submit(function (event) {
            $('#btn_submit').button('loading');
        });

        function action(id, el)
        {
            switch (id) {
                case 'eliminar_all':
                    res = confirm('Realmente desea cancelar todo?');
                    break;
                case 'save':
                    res = confirm('Realmente desea guardar este ncf?');
                    break;
                default:
                    res = confirm('Realmente desea eliminar este detalle?');
            }

            if (!res) {
                event.preventDefault();
                return;
            }

            $(el).remove();

            $('#form_' + id).submit();
        }
    </script>

@endsection
