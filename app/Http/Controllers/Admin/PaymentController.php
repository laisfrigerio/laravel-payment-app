<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Paypal\OrderService as PaypalOrderService;
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
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];
        
        $request->validate($rules);

        $paymentPlatform = resolve(PaypalOrderService::class);
        return $paymentPlatform->store($request->all());
    }
    
    public function details(string $orderId)
    {
        $paymentPlatform = resolve(PaypalOrderService::class);
        return $paymentPlatform->details($orderId);
    }
    
    public function approval(Request $request)
    {
        $orderId = $request->get("token");
        $paymentPlatform = resolve(PaypalOrderService::class);
        $response = $paymentPlatform->capture($orderId);
        
        if ($response === false) {
            return redirect("home")->withErrors("We cannot capture the payment. Try again, please.");
        }
        
        return redirect()->route("home");
    }
    
    public function cancelled()
    {
        return redirect()
            ->route("home")
            ->withErrors("You cancelled the payment.");
    }
}
