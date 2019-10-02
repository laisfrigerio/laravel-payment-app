<?php

use Illuminate\Database\Seeder;
use \App\Models\PaymentPlatform;

class PaymentPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::create([
            "name" => "PayPal",
            "image" => "images/payment-platforms/paypal.jpg"
        ]);
    
        PaymentPlatform::create([
            "name" => "Stripe",
            "image" => "images/payment-platforms/stripe.jpg"
        ]);
    }
}
