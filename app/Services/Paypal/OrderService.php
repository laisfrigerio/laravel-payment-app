<?php

namespace App\Services\Paypal;

use App\Traits\CustomHttpRequest;
use Illuminate\Http\Request;

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
        parent::__construct();
    }
    
    /**
     * Create new order on paypal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $currency = $request->get("currency");
        $value    =  $request->get("value");

        $order =  $this->makeRequest(
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
    
        dd($order);
        $orderLinks = collect($order->links);
        $approve =$orderLinks->where("rel", "approve")->first();
        return redirect($approve->href);
    }
    
    public function details(string $orderId)
    {
        return $this->makeRequest(
            "/v2/checkout/orders/{$orderId}",
            "POST",
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            true
        );
    }
    
    public function capture(string $approvalId)
    {
        return $this->makeRequest(
            "/v2/checkout/orders/${$approvalId}/capture",
            "POST",
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            true
        );
    }
}
