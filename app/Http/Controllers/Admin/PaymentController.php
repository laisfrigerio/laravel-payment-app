<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        
        return $request->all();
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
