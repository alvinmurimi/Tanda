<?php

namespace Alvo\Tanda;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Tanda
{
    private $client_id;
    private $client_secret;
    private $oauth;
    private $org_id;
    private $scope;
    private $client;
    private $b64Val;
    private $endpoint;
    private $env;

    public function __construct()
    {
        $this->client_id = config('tanda.client_id');
        $this->client_secret = config('tanda.client_secret');
        $this->env = config('tanda.env');
        $this->org_id = config('tanda.org_id');
        if($this->env == 'sandbox'){
            $this->oauth = 'https://io-proxy-443.tanda.co.ke/sandbox/accounts/v1/oauth/token';
            $this->endpoint = "https://io-proxy-443.tanda.co.ke/sandbox/io/v1/organizations/".$this->org_id."/requests";
        }else{
            $this->oauth = 'https://io-proxy-443.tanda.co.ke/accounts/v1/oauth/token';
            $this->endpoint = "https://io-proxy-443.tanda.co.ke/io/v1/organizations/".$this->org_id."/requests";
        }
        $this->scope = "iowallets.transaction.read iowallets.transaction.readWrite";
        $this->client = $this->client_id.":".$this->client_secret;
        $this->b64Val = base64_encode($this->client);
        
    }

    private function get_access_token()
    {
        return Http::withHeaders([
            'Authorization' => 'Basic '.$this->b64Val,
        ])->asForm()->post($this->oauth, ['grant_type' => 'client_credentials'])->json()['access_token'];
    }

    public function balances()
    {
        $u = "https://io-proxy-443.tanda.co.ke/sandbox/wallets/v1/orgs/".$this->org_id."/balances?accountTypes=01,02";
        $url = $this->env == 'sandbox' ? $u : str_replace('/sandbox', '', $u); 
        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->get($url)[0]['balances'];
    }

    public function pinless_airtime($provider, $account, $amount)
    {
        $payload = [
            "commandId" => "TopupFlexi",
            "serviceProviderId" => $provider, //SAFARICOM, AIRTEL, TELKOM
            "requestParameters" => [
                    [
                        "id" => "amount",//10 to 10,000
                        "value" => $amount,
                        "label" => "Amount"
                    ],
                    [
                        "id" => "accountNumber",
                        "value" => $account,
                        "label" => "Phone No."
                    ]

                ],
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.topup_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];

        $response = HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload);
        return $response->json();
    }

    public function buy_tokens($account, $amount)
    {
        $payload = [
            "commandId" => "VoucherFlexi",
            "serviceProviderId" => "KPLC",
            "requestParameters" => [
                    [
                        "id" => "amount",
                        "value" => $amount, //10 to 35,000
                        "label" => "Amount"
                    ],
                    [
                        "id" => "accountNumber",
                        "value" => $account, //Meter number
                        "label" => "Bill Account Number"
                    ]

                ],
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.tokens_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];

        $response = HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload);
        return $response->json();
    }

    public function pay_tv($provider, $account, $amount)
    {
        $payload = [
            "commandId" => "TopupFix",
            "serviceProviderId" => $provider,
            "requestParameters" => [
                    [
                        "id" => "amount",
                        "value" => $amount, //10 to 20,000
                        "label" => "Amount"
                    ],
                    [
                        "id" => "accountNumber",
                        "value" => $account, //Box account number
                        "label" => "Bill Account Number"
                    ]

                ],
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.paytv_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];

        $response = HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload);
        return $response->json();   
    }

    public function bill_pay($provider, $account, $amount)
    {
        $payload = [
            "commandId" => "BillPay",
            "serviceProviderId" => $provider, //KPLC, NAIROBI_WTR
            "requestParameters" => [
                    [
                        "id" => "amount",
                        "value" => $amount, //100 - 35000
                        "label" => "Amount"
                    ],
                    [
                        "id" => "accountNumber",
                        "value" => $account, //KPLC Postpaid / Nairobi Wtr Meter Number
                        "label" => "Bill Account Number"
                    ]

                ],
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.billpay_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];

        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload)->json();  
    }

    public function voucherfix($provider, $amount)
    {
        $payload = [
            "commandId" => "VoucherFix",
            "serviceProviderId" => $provider, //SAFARICOM, TELKOM, AIRTEL
            "requestParameters" => [
                    [
                        "id" => "amount", 
                        "value" => $amount, //20,50,100,250,500,1000, telkom=200 !250,
                        "label" => "Amount"
                    ]

                ],
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.voucher_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];

        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload)->json();
    }

    public function query($transaction)
    {
        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->get($this->endpoint."/".$transaction)->json();
    }
}