<?php

namespace App\Services\Paypal;

use App\Models\Currency;
use App\Models\Order;
use App\Models\PaymentPlatform;
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
        // call parent construct to set base uri, client id and client secret
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
        $value    = $request->get("value");

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
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('approval'),
                    'cancel_url' => route('cancelled'),
                ],
            ],
            [],
            true
        );
    
        $orderLinks = collect($order->links);
        $approve =$orderLinks->where("rel", "approve")->first();
    
        Order::create([
            "id" => $order->id,
            "currency_id" => Currency::find($currency)->iso,
            "payment_platform_id" => PaymentPlatform::find(1)->id,
            "approval_link" => $approve->href,
            "value" => str_replace(",", ".", $value),
        ]);
        
        return redirect($approve->href);
    }
    
    public function createOrder($currency, $value)
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
