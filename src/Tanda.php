<?php

namespace Alvoo\Tanda;

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
        }
        $this->oauth = 'https://io-proxy-443.tanda.co.ke/accounts/v1/oauth/token';
        $this->endpoint = "https://io-proxy-443.tanda.co.ke/io/v1/organizations/".$this->org_id."/requests";
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
        $uri = "https://io-proxy-443.tanda.co.ke/sandbox/wallets/v1/orgs/".$this->org_id."/balances?accountTypes=01,02";
        $url = $this->env == 'sandbox' ? $uri : str_replace('/sandbox', '', $uri); 
        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->get($url)[0]['balances'];
    }

    public function submit($commandID, $serviceProviderId, $account = null, $amount, $callback)
    {
        $requestParameters = [
            [
                "id" => "amount",
                "value" => $amount,
                "label" => "Amount"
            ]
        ];
        if(!is_null($account)){
            $requestParameters[] = [
                "id" => "accountNumber",
                "value" => $account,
                "label" => "Account Number"
            ];
        }
        
        $payload = [
            "commandId" => $commandID,
            "serviceProviderId" => $serviceProviderId,
            "requestParameters" => $requestParameters,
            "referenceParameters" => [
                    [
                        "id" => "resultUrl",
                        "value" => config('tanda.'.$callback.'_callback'),
                        "label" => "Hook"
                    ]
            ]
        ];
        return Http::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->post($this->endpoint, $payload)->json();
    }
    public function pinlessAirtime($provider, $account, $amount)
    {
        return $this->submit(
            'TopupFlexi', $provider, $account, $amount, 'topup'
        );
    }

    /*
    *   This method is no longer supported as of 31/08/2022
    *
    public function buyTokens($account, $amount)
    {
        return $this->submit(
            'VoucherFlexi', 'KPLC', $account, $amount, 'tokens'
        );
    }
    */

    public function payTV($provider, $account, $amount)
    {
        return $this->submit(
            'TopupFix', $provider, $account, $amount, 'paytv'
        );
    }

    public function billPay($provider, $account, $amount)
    {
        return $this->submit(
            'BillPay', $provider, $account, $amount, 'billpay'
        );
    }

    public function voucherFix($provider, $amount)
    {
        return $this->submit(
            'VoucherFix', $provider, null, $amount, 'voucher'
        );
    }

    public function query($transaction)
    {
        return HTTP::withToken($this->get_access_token())
                        ->accept('application/json')
                        ->get($this->endpoint."/".$transaction)->json();
    }
}