<?php

namespace Bame\Models\IB\WS;

use SoapClient;

class Sab
{
    protected $params = [];

    protected $client;

    public function __construct()
    {
        $this->client = new SoapClient(env('SAB_WSDL'), [
            'soap_version' => SOAP_1_2
        ]);
    }

    public function setParam($partnerId, $branchCode, $tellerId, $channel, $partnerIdUser)
    {
        $this->params = [
            'validateAccountRQ' => [
                'HeaderInfo' => [
                    'PartnerId' => $partnerId,
                    'BranchCode' => $branchCode,
                    'TellerId' => $tellerId,
                    'Channel' => $channel,
                    'PartnerUser' => $partnerIdUser,
                ]
            ],
        ];

        return $this;
    }

    public function validateAccount($account)
    {
        $this->params['validateAccountRQ'] = array_merge($this->params['validateAccountRQ'], ['Account' => $account]);

        return $this->client->ValidateAccount($this->params);
    }
}
