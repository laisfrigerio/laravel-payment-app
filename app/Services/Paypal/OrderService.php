<?php

namespace App\Services\Paypal;

use App\Traits\CustomHttpRequest;

/**
 * Class responsible for control de paypal orders
 *
 * Class OrderService
 * @package App\Services\Paypal
 */
class OrderService extends PaypalService
{
    use CustomHttpRequest;
    
    /**
     * OrderService constructor.
     */
    public function __construct()
    {
        // call parent construct to set base uri, client id and client secret
        parent::__construct();
    }
    
    /**
     * Create new order on paypal
     *
     * @param $value
     * @param $currency
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function store($value, $currency)
    {
        return $this->makeRequest(
            "/v2/checkout/orders",
            "POST",
            [],
            [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => strtoupper($currency),
                            'value' => $value,
                        ],
                    ]
                ],
                'application_context' => [
                    'brand_name' => config("app.name"),
                    'shipping_reference' => 'NO_SHIPPING',
                    'user_account' => 'PAY_NOW',
                    'return_url' => route('approval'),
                    'cancel_url' => route('cancelled'),
                ],
            ],
            [],
            true
        );
    }
}
