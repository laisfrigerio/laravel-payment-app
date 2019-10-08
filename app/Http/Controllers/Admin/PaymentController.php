<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Paypal\OrderService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pay(Request $request)
    {
        $rules = [
            'value'            => ['required', 'numeric', 'min:5'],
            'currency'         => ['required', 'exists:currencies,iso'],
            'payment-platform' => ['required', 'exists:payment_platforms,id'],
        ];
        
        $request->validate($rules);

        $paymentPlatform = resolve(OrderService::class);
        return $paymentPlatform->store($request);
    }
    
    public function details(string $orderId)
    {
        $paymentPlatform = resolve(OrderService::class);
        return $paymentPlatform->details($orderId);
    }
    
    public function capture($orderId)
    {
        $paymentPlatform = resolve(OrderService::class);
        return $paymentPlatform->capture($orderId);
    }
    
    public function approval()
    {
        //
    }
    public function cancelled()
    {
        //
    }
}
