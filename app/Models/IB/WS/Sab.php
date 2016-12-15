<?php

namespace Bame\Models\IB\WS;

use SoapClient;

class Sab
{
    protected $headers = [];

    protected $client;

    protected $response = null;

    protected $function = '';

    protected $response_codes = [
        '0000' => 'Proceso ejecutado satisfactoriamente.',
        '8050' => 'Error procesando transacción.',
        '8051' => 'Transacción rechazada por el sistema central.',
        '8052' => 'Insuficiencia de fondos.',
        '9714' => 'No. de Cuenta Invalida o no existe.',
        '9715' => 'Cuenta se encuentra en estatus no disponible.',
        '9730' => 'Cliente Invalido o no Existe.',
        '9731' => 'Cliente no posee productos disponibles.',
        '9901' => 'Parámetros de Entradas incorrectos.',
        '9902' => 'Canal no disponible en estos momentos.',
        '9903' => 'Transacción invalida o no existe o no aplica para reverso.',
        '9920' => 'Tipo de transacción no disponible.',
        '9930' => 'Límite de operación excedido.',
        '9999' => 'Error Interno en el sistema.',
        '10000' => 'Timeout sistema central.',
    ];

    public function __construct()
    {
        $this->client = new SoapClient(env('SAB_WSDL'), [
            'soap_version' => SOAP_1_2
        ]);

        $this->setHeader();
    }

    public function getHeader()
    {
        return $this->getResponse()->HeaderInfo;
    }

    public function setHeader()
    {
        $this->headers = [
            'HeaderInfo' => [
                'PartnerId' => env('SAB_HEADER_PARTNER'),
                'BranchCode' => env('SAB_HEADER_BRANCH'),
                'TellerId' => env('SAB_HEADER_TELLER'),
                'Channel' => env('SAB_HEADER_CHANNEL'),
                'PartnerUser' => env('SAB_HEADER_PARTNER_USER'),
            ]
        ];
    }

    public function validateAccount($account)
    {
        $this->function = 'validateAccount';

        $this->params['validateAccountRQ'] = array_merge($this->headers, ['Account' => $account]);

        $this->response = $this->client->ValidateAccount($this->params);
    }

    public function getResponse()
    {
        switch ($this->function) {
            case 'validateAccount':
                return $this->response->ValidateAccountResult;
                break;

            default:
                return null;
                break;
        }
    }

    public function getResponseCode()
    {
        return $this->getResponse()->ResponseCode;
    }

    public function getResponseDescription()
    {
        return $this->response_codes[$this->getResponse()->ResponseCode];
    }

    public function getCustomer()
    {
        return $this->getResponse()->CustomerData;
    }

    public function getAccount()
    {
        return $this->getResponse()->Account;
    }

    public function err()
    {
        return !($this->getResponseCode() == '0000');
    }

    public function toObject()
    {
        $obj = new \stdClass;

        $obj->customer = $this->getCustomer();
        $obj->account = $this->getAccount();

        return $obj;
    }
}
