<?php

namespace App\Billing;


use GuzzleHttp\Client;
use Illuminate\Support\Manager;

class PaymentGatewayManager extends Manager
{
    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'clickBank';
    }

    public function createClickBankDriver()
    {
        return new ClickBankGateway(
            new Client([
                'base_uri' => 'https://api.clickbank.com/rest/1.3',
                'headers' => [
                    'apiKey' => config('services.clickBank.apiKey'),
                    'devKey' => config('services.clickBank.devKey')
                ]
            ])
        );
    }
}
